<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 21:54
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["password"]) && isset($_POST["confirmpassword"]) && isset($_POST["subdomain"]) && isset($_POST["hostname"]) && isset($_POST["tld"]))
{

if ($_POST["password"] != $_POST["confirmpassword"])
{
    $_SESSION["domainerror"] = "Passwords do not match, please try again";
    $_SESSION["domainerrorsubdomain"] = $_POST["subdomain"];
    $_SESSION["domainerrorhostname"] = $_POST["hostname"];
    $_SESSION["domainerrortld"] = $_POST["tld"];
    header("location: dashboard.php#newdomain");
}

    //best course of action if website is already in db

    $hash = $db->newWebsite($_SESSION["token"], $_POST["password"], $_POST["subdomain"], $_POST["hostname"], $_POST["tld"]);

    switch($hash)
    {
        case "tokenerror":
            $_SESSION["domainerror"] = "Token is invalid, please sign in again or if you are having further issues please contact us";
            $_SESSION["domainerrorsubdomain"] = $_POST["subdomain"];
            $_SESSION["domainerrorhostname"] = $_POST["hostname"];
            $_SESSION["domainerrortld"] = $_POST["tld"];
            header("location: dashboard.php#newdomain");
            break;
        case "domainused":
            $_SESSION["domainerror"] = "Domain is already used";
            $_SESSION["domainerrorsubdomain"] = $_POST["subdomain"];
            $_SESSION["domainerrorhostname"] = $_POST["hostname"];
            $_SESSION["domainerrortld"] = $_POST["tld"];
            header("location: dashboard.php#newdomain");
            break;
        default:
            $_SESSION["domainsuccess"] = $hash;
            header("location: dashboard.php#newdomain");
            break;
    }
}
