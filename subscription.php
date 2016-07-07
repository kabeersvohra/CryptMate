<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 03/08/2015
 * Time: 18:39
 */

if (!isset($_SESSION)) session_start();

include_once 'database/connectdatabase.php';

$_SESSION["token"] = "HCoUQ9yGbjSP4iyLLAClrXCVbh3Uc2ZHuds9cOFbVlROrdq2BScSDFDCKtkKl0iDbyBbc5cYgRCvUQmlwn2ZStpqMz2Xx0qyxSxxMxjQfKcXqo8NBYAhfQySdnFAkUWFAj3cFcRIKTv16qBvf1CkGY1JbuajeUOE3FExFl6f5o6YFvjIlLSPyJox4mH66lzXQ2klddq6rkTWD3uOCbr1IFnzQUuL7RyKIGWLJaFYkoLLh4pH3GxAaKZOvhnpYLXx";

?>

<?php include("headers/header.php") ?>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/landing-page.css" rel="stylesheet">
<link href="css/navbar.css" rel="stylesheet">
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_iMSLKp40qU6IPtvS1mLtQEli');
</script>
<script type="text/javascript" src="js/subscription.js"></script>
<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>


<?php include_once 'headers/navbar.php' ?>

<div class="container" style="margin-top: 70px; text-align: center;">

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
    
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" id="monthlySubscribe">
                        <span class="payment-errors"></span>

                        <div class="form-row">
                            <label>
                                <span>Card Number</span>
                                <input type="text" size="20" data-stripe="number">
                            </label>
                        </div>

                        <div class="form-row">
                            <label>
                                <span>Expiration (MM/YY)</span>
                                <input type="text" size="2" data-stripe="exp_month">
                            </label>
                            <span> / </span>
                            <input type="text" size="2" data-stripe="exp_year">
                        </div>

                        <div class="form-row">
                            <label>
                                <span>CVC</span>
                                <input type="text" size="4" data-stripe="cvc">
                            </label>
                        </div>
                        <input type="submit" class="submit" value="Submit Payment">
                    </form>
                </div>

            </div>

        </div>
    </div>

</div>
