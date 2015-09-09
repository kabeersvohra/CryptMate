<?php
/**
 * Created by PhpStorm.
 * User: Kabeer.Vohra
 * Date: 9/3/2015
 * Time: 3:34 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["password"]) && isset($_POST["confirmpassword"]) && isset($_POST["hash"]) && isset($_POST["email"]))
{
    if ($_POST["password"] == $_POST["confirmpassword"])
    {
        if ($db->resetPassword($_POST["password"], $_POST["hash"], $_POST["email"]))
        {
            $_SESSION["resetpasswordsuccess"] = "Password reset successfully";
            header("Location: ../resetpassword.php");
            exit;
        }
        else
        {
            $_SESSION["resetpassworderror"] = "Password not reset due to an unknown error, please try again";
            header("Location: ../resetpassword.php");
            exit;
        }
    }
    else
    {
        $_SESSION["resetpassworderror"] = "Passwords do not match, please try again";
        header("Location: ../resetpassword.php");
        exit;
    }
}