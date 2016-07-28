<?php

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/processing/config.php';

$stripeToken = $_POST['stripeToken'];
$cryptmateToken = $_SESSION["token"];
$stripePlan = $_POST['stripePlan'];
$stripeCustomer = $_POST['stripeCustomer'];
$subscribe = $_POST['subscribe'];

if (!isset($cryptmateToken))
    badRequest(new Exception("User is not logged in"));

$subscriptionEnd = $db->getSubscriptionEndUnix($cryptmateToken);

if (!isset($stripeToken) && !isset($stripeCustomer) || !isset($stripePlan))
    badRequest(new Exception("Invalid payment token"));

$email = $db->getAccountDetails($cryptmateToken)["email"];

if (!isset($stripeCustomer)) {
    $stripeCustomer = createCustomer($stripeToken, $stripePlan, $subscriptionEnd, $email);
    $db->addStripeCustomerDetails($cryptmateToken, $stripeCustomer, $stripePlan);
    success();
} elseif ($subscribe) {
    $stripeCustomer = $db->getStripeCustomerDetails($cryptmateToken);
    \Stripe\Subscription::create(array(
        "customer" => $stripeCustomer,
        "plan" => $stripePlan
    ));
    success();
} elseif (!$subscribe) {
    $subscription = \Stripe\Subscription::retrieve($stripePlan);
    $subscription->cancel();
}

if (!$subscriptionEnd || $subscriptionEnd < time())
    $subscriptionEnd = "now";


function createCustomer($stripeToken, $stripePlan, $subscriptionEnd, $email) {
    $customer = null;
    try {
        $customer = \Stripe\Customer::create(array(
            "source" => $stripeToken,
            "plan" => $stripePlan,
            "trial_end" => $subscriptionEnd,
            "email" => $email
        ));
    } catch (Exception $e) {
        badRequest($e);
    }
    return $customer;
}

function badRequest(Exception $e) {
    http_response_code(400);
    die($e->getMessage());
}

function success() {
    http_response_code(200);
    die();
}