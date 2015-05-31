<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 22:35
 */

include_once 'header.php';

switch($db->verifyEmail($_GET["email"], $_GET["hash"]))
{
    case true:
        echo "Email verified successfully";
        break;
    case false:
        echo "Email not verified, please try again or request another email verification";
        break;
}