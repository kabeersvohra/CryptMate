<?php

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/processing/config.php';

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

$event_id = $event_json->id;
$event = \Stripe\Event::retrieve($event_id);

if (isset($event->type) && $event->type == 'invoice.payment_succeeded') {
    process_invoice_receipt($event->data->object);
}

http_response_code(200);

function process_invoice_receipt($invoice) {
    $customerID = $invoice->customer;
    $charge = \Stripe\Charge::retrieve($invoice->charge);
    $amount = $charge->amount;
    update_subscription_db($customerID, $amount);
}

function update_subscription_db($customerID, $amount) {
    $monthlyCharge = 300;
    $yearlyCharge = 3000;
    if ($amount == $monthlyCharge) {
        $db->addOneMonth($customerID);
    } elseif ($amount == $yearlyCharge) {
        $db->addOneYear($customerID);
    }
}