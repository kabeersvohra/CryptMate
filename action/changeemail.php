<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 28/07/2015
 * Time: 17:34
 */

include_once '../connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["currentemail"]) && isset($_POST["newemail"]))
{
    $_POST["currentemail"] = strtolower($_POST["currentemail"]);
    $_POST["newemail"] = strtolower($_POST["newemail"]);

    if ($_POST["currentemail"] == $_POST["newemail"])
    {
        $_SESSION["changeemailerror"] = "Both email addresses are the same. Please change to a different email address";
        $_SESSION["changeemailerrorcurrent"] = $_POST["currentemail"];
        $_SESSION["changeemailerrornew"] = $_POST["newemail"];
        header("Location: ../dashboard.php#changeemail");
        exit;
    }

    if ($db->isCurrentEmail($_SESSION["token"], $_POST["currentemail"]))
    {
        if ($db->isNewEmail($_POST["newemail"]))
        {
            if (preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $_POST["newemail"]) == 1)
            {
                if ($db->changeEmail($_SESSION["token"], $_POST["currentemail"], $_POST["newemail"]))
                {
                    $_SESSION["changeemailsuccess"] = "Email address has been successfully changed. Please click on the verification links sent to both email addresses to verify your new email address";
                }
                else
                {
                    $_SESSION["changeemailerror"] = "Unknown error, please try again or contact us directly";
                    $_SESSION["changeemailerrorcurrent"] = $_POST["currentemail"];
                    $_SESSION["changeemailerrornew"] = $_POST["newemail"];
                }

                header("Location: ../dashboard.php#changeemail");
                exit;
            }
            else
            {
                $_SESSION["changeemailerror"] = "New email address is invalid. Please enter a valid email address.";
                $_SESSION["changeemailerrorcurrent"] = $_POST["currentemail"];
                $_SESSION["changeemailerrornew"] = $_POST["newemail"];
                header("Location: ../dashboard.php#changeemail");
                exit;
            }
        }
        else
        {
            $_SESSION["changeemailerror"] = "New email address is already used. Please sign in with that account or change to a different email address";
            $_SESSION["changeemailerrorcurrent"] = $_POST["currentemail"];
            $_SESSION["changeemailerrornew"] = $_POST["newemail"];
            header("Location: ../dashboard.php#changeemail");
            exit;
        }

    }
    else
    {
        $_SESSION["changeemailerror"] = "Current email address is incorrect. Please check it and try again";
        $_SESSION["changeemailerrorcurrent"] = $_POST["currentemail"];
        $_SESSION["changeemailerrornew"] = $_POST["newemail"];
        header("Location: ../dashboard.php#changeemail");
        exit;
    }
}