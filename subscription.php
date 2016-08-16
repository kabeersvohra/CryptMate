<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 03/08/2015
 * Time: 18:39
 */

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

$_SESSION["token"] = "HCoUQ9yGbjSP4iyLLAClrXCVbh3Uc2ZHuds9cOFbVlROrdq2BScSDFDCKtkKl0iDbyBbc5cYgRCvUQmlwn2ZStpqMz2Xx0qyxSxxMxjQfKcXqo8NBYAhfQySdnFAkUWFAj3cFcRIKTv16qBvf1CkGY1JbuajeUOE3FExFl6f5o6YFvjIlLSPyJox4mH66lzXQ2klddq6rkTWD3uOCbr1IFnzQUuL7RyKIGWLJaFYkoLLh4pH3GxAaKZOvhnpYLXx";

?>
<head>
    <?php include("headers/header.php") ?>
    <link href="css/subscription.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
</head>



<?php include_once 'headers/navbar.php' ?>

<div class="container" style="padding-top: 70px; text-align: center;">

    <div class="row">
        <?php
        if ($db->getSubscriptionEnded($_SESSION["token"]))
            echo "<p>Subscription ended:</p>";
        else
            echo "<p>Subscription ends:</p>";
        ?>
        <p style='margin-bottom: 0;'><?= $db->getSubscriptionEnd($_SESSION["token"]) ?></p>
    </div>
    
    <div class="row options">
        <div class='wrapper'>
            <div class='package col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-md-4 col-md-offset-2 col-sm-offset-1'>
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
                    <button id="monthlySubscribe" type="button" data-toggle="modal" href="#paymentModal">sub</button>
                </div>
            </div>

            <div class='package col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-md-4'>
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

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post" id="checkout">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" align="center">Checkout</h4>
                        <p align="center">CryptMate Monthly</p>
                    </div>
                    <div class="modal-body">
                        <div class="message-wrapper"></div>
                        <h1 align="center">£3</h1>

                        <div class="form-group">
                            <label>Name On Card</label>
                            <input type="text" class="form-control" name="card_holder_name">
                        </div>

                        <div class="form-group">
                            <label for="ccnumber">Card Number</label>
                            <input type="text" class="form-control" id="ccnumber">
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>CVC</label>
                                <input type="text" class="form-control" id="securitycode">
                            </div>
                            <div class="col-xs-6">
                                <label>EXP (MM/YY)</label>
                                <input type="text" class="form-control" id="expdate">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Checkout</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_iMSLKp40qU6IPtvS1mLtQEli');
</script>
<script src="js/jquery.js"></script>
<script src="js/subscription.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>