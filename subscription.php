<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 03/08/2015
 * Time: 18:39
 */

if (!isset($_SESSION)) session_start();

include_once 'database/connectdatabase.php';

?>

<?php include("headers/header.php") ?>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/landing-page.css" rel="stylesheet">
<link href="css/navbar.css" rel="stylesheet">

<?php include_once 'headers/navbar.php' ?>

<div class="container" style="margin-top: 70px;">

    <div class="row">
        <?php
        if ($db->getSubscriptionEnded($_SESSION["token"]))
            echo "<p>Subscription ended:</p>";
        else
            echo "<p>Subscription ends:</p>";
        ?>
        <p><?= $db->getSubscriptionEnd($_SESSION["token"]) ?></p>
    </div>
    
    <div class="row options">
        <div class='wrapper'>
            <div class='package col-sm-5 col-md-4 col-md-offset-2 col-sm-offset-1'>
                <div class='name'>Monthly</div>
                <div class='price month'>£3</div>
                <div class='trial'>Free 30 day trial</div>
                <ul class="checks">
                    <li class="check">
                        <strong>Unlimited</strong>
                        websites
                    </li>
                    <li class="check">
                        <strong>Unlimited</strong>
                        passwords
                    </li>
                    <li class="check">
                        <strong>Unlimited</strong>
                        devices
                    </li>
                </ul>
                <div style="text-align: center;">
                   <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="D5S4UG668P5P8">
                        <input type="image" src="https://www.sandbox.paypal.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
            </div>

            <div class='package col-sm-5 col-md-4'>
                <div class='name'>Yearly</div>
                <div class='price year'>£30</div>
                <div class='trial'>Free 30 day trial</div>
                <ul class="checks">
                    <li class="check">
                        <strong>Unlimited</strong>
                        websites
                    </li>
                    <li class="check">
                        <strong>Unlimited</strong>
                        passwords
                    </li>
                    <li class="check">
                        <strong>Unlimited</strong>
                        devices
                    </li>
                </ul>
                <div style="text-align: center;">
                   <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="D5S4UG668P5P8">
                        <input type="image" src="https://www.sandbox.paypal.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row" style="padding-top: 10px;">
        <p>You can unsubscribe at any time. If you choose to unsubscribe you will be able to use your account until the subscription ends. To unsubscribe to monthy or yearly plans please click the button below:</p>
        <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=F8VHSXJ66RVHG">
            <IMG SRC="https://www.paypalobjects.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
        </A>
        <p>Please note that if you did not subscribe with a paypal account and you subscribed directly with a credit/debit card that you would need to call paypal to have the subscription cancelled.</p>
    </div>
</div>
