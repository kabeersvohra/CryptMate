<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 01/08/2015
 * Time: 02:54
 */

include_once '../database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if(isset($_POST["oldpassword"]) && isset($_POST["newpassword"]) && isset($_POST["confirmpassword"]))
{
    if ($_POST["newpassword"] == $_POST["confirmpassword"])
    {
        if (preg_match('/^.*(?=.{7,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $_POST["newpassword"]) != 1)
        {
            $_SESSION["changepassworderror"] = "Password must be at least 7 characters long and contain an uppercase digit, a lowercase digit and a number";
        }
        else
        {
            switch ($db->changePassword($_POST["oldpassword"], $_POST["newpassword"], $_SESSION["token"]))
            {
                case 1:
                    //success
                    $_SESSION["changepasswordsuccess"] = "Password has been successfully changed";
                    break;
                case 2:
                    $_SESSION["changepassworderror"] = "The old password is incorrect. Please try again";
                    //old pass is wrong
                    break;
                case 3:
                    $_SESSION["changepassworderror"] = "Unknown error, please try again or contact us directly";
                    //unknown error
                    break;
            }
        }
    }
    else
    {
        $_SESSION["changepassworderror"] = "Passwords do not match, please try again";
    }


header("Location: ../dashboard.php#changepassword");
exit;

}