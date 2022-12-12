<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 16:07
 */

include_once 'header.php';

if (($_POST["email"] != "") || ($_POST["username"] != ""))
{
    if($db->resendVerification($_POST["email"], $_POST["username"])) {
        echo "Email verification has been resent, please check your inbox";
    }
    else
    {
        echo "Account not found in database, please check your credentials or make an account if you have not already done so.";
    }
}