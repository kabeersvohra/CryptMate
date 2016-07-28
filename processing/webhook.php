<?php

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/processing/config.php';

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

$event_id = $event_json->id;
$event = \Stripe\Event::retrieve($event_id);

if ($event->type == 'invoice.payment_succeeded') {
    email_invoice_receipt($event->data->object);
}

http_response_code(200);

function email_invoice_receipt($invoice) {
    $customerID = $invoice->customer;
    $charge = \Stripe\Charge::retrieve($invoice->charge);
    $amount = $charge->amount;
    update_subscription_db($customerID, $amount);
}

function update_subscription_db($customerID, $amount) {
    if ($amount == 300) {

    } elseif ($amount == 3000) {

    }
}