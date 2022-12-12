<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 04/08/2015
 * Time: 14:33
 */

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

// Send an empty HTTP 200 OK response to acknowledge receipt of the notification
header('HTTP/1.1 200 OK');

// Assign payment notification values to local variables
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$payment_fee = $_POST['payment_fee'];
$txn_id = $_POST['txn_id'];
$txn_type = $_POST['txn_type'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$payer_name = $_POST['first_name'] . " " . $_POST['last_name'];
$subscriber_id = $_POST['subscr_id'];

// Build the required acknowledgement message out of the notification just received
$req = 'cmd=_notify-validate';               // Add 'cmd=_notify-validate' to beginning of the acknowledgement
foreach ($_POST as $key => $value) {         // Loop through the notification NV pairs
    $value = urlencode(stripslashes($value));  // Encode these values
    $req  .= "&$key=$value";                   // Add the NV pairs to the acknowledgement
}

// Set up the acknowledgement request headers
$header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";                    // HTTP POST request
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

// Open a socket for the acknowledgement request
$fp = fsockopen('tls://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// Send the HTTP POST request back to PayPal for validation
fputs($fp, $header . $req);


while (!feof($fp)) {                     // While not EOF
    $res = fgets($fp, 1024);               // Get the acknowledgement response
    if (strcmp ($res, "VERIFIED") == 0) {  // Response contains VERIFIED - process notification
        $isNewTransaction = $db->isNewTransaction($txn_id);
        $db->createNewTransaction($txn_id, $txn_type, $payment_status, $payment_amount, $payment_currency, $payment_fee, $payer_email, $payer_name, $payer_token, $receiver_email, $subscriber_id, $res);

        if (strcmp ($res, "VERIFIED") == 0) {

            if (($receiver_email == "kabeer@vohra.eu") && ($txn_type == "subscr_payment") && ($payment_status == "Completed") && ($isNewTransaction))
            {
                if ($payment_amount == 3)
                {
                    $db->addOneMonth($payer_token);
                }
                else if ($payment_amount == 30)
                {
                    $db->addOneYear($payer_token);
                }
            }

        }
    }
}

fclose($fp);  // Close the file

?>