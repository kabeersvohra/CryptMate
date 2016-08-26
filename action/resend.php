<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 16:07
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (!isset($_SESSION)) session_start();

if ((!isset($_POST["email"])) || (!isset($_POST["username"])))
{
    header('Location: login.php');
    exit;
}
else
{
    if($db->resendVerification($_POST["email"], $_POST["username"])) {
        $_SESSION["resendsuccess"] = true;
        header('Location: ../resendemailverification.php');
        exit;
    }
    else
    {
        $_SESSION["resendsuccess"] = false;
        header('Location: ../resendemailverification.php');
        exit;
    }
}