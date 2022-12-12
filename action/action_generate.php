<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 19:53
 */

include_once '../connectdatabase.php';

if (!isset($_SESSION)) session_start();

$hash = $db->generatePassword($_POST["domain"], $_POST["password"], $_SESSION["token"]);

if (isset($_POST["domain"]) && isset($_POST["password"]) && isset($_SESSION["token"]))
{
    $hash = $db->generatePassword($_POST["domain"], $_POST["password"], $_SESSION["token"]);

    switch($hash)
    {
        case "tokenerror":
            $_SESSION["generateerror"] = "Token is invalid, please sign in again or if you are having further issues please contact us";
            $_SESSION["generateerrorsubdomain"] = $_POST["subdomain"];
            $_SESSION["generateerrorhostname"] = $_POST["hostname"];
            $_SESSION["generateerrortld"] = $_POST["tld"];
            header("Location: ../dashboard.php#generatepassword");
            exit;
        default:
            $_SESSION["generatesuccess"] = $hash;
            header("Location: ../dashboard.php#generatepassword");
            exit;
    }
}
