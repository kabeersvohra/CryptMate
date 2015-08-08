<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 03/08/2015
 * Time: 18:39
 */

if (!isset($_SESSION)) session_start();

if(file_exists('../database/connectdatabase.php'))
    include_once '../database/connectdatabase.php';

?>

<div class="col-sm-6 col-sm-offset-3" style="text-align: center;">

    <div class="row">
        <?php
        if ($db->getSubscriptionEnded($_SESSION["token"]))
            echo "<p>Subscription ended:</p>";
        else
            echo "<p>Subscription ends:</p>";
        ?>
        <p><?= $db->getSubscriptionEnd($_SESSION["token"]) ?></p>
    </div>

    <div class="col-sm-6" style="padding-top: 10px;">
        <p>To subscribe monthly for &pound;3 a month please click the button below:</p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="custom" value="<?= $_SESSION['token'] ?>"/>
            <input type="hidden" name="hosted_button_id" value="6JC32FUHENKDW">
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>

    <div class="col-sm-6" style="padding-top: 10px;">
        <p>To subscribe annually for &pound;30 a year please click the button below:</p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="custom" value="<?= $_SESSION['token'] ?>"/>
            <input type="hidden" name="hosted_button_id" value="544YSVW6REK3U">
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>

    <div class="col-sm-6 col-sm-offset-3" style="padding-top: 10px;">
        <p>You can unsubscribe at any time. If you choose to unsubscribe you will be able to use your account until the subscription ends. To unsubscribe to monthy or yearly plans please click the button below:</p>
        <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=F8VHSXJ66RVHG">
            <IMG SRC="https://www.paypalobjects.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
        </A>
        <p>Please note that if you did not subscribe with a paypal account and you subscribed directly with a credit/debit card that you would need to call paypal to have the subscription cancelled.</p>
    </div>

</div>