<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 19:05
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["username"]) && isset($_POST["password"]))
{
    $token = $db->verifyUser($_POST["username"], $_POST["password"]);

    switch($token)
    {
        case "unverified":
            $_SESSION["loginerror"] = "unverified";
            $_SESSION["loginerrorusername"] = $_POST["username"];
            header('Location: login.php');
            break;
        case "username":
            $_SESSION["loginerror"] = "username";
            $_SESSION["loginerrorusername"] = $_POST["username"];
            header('Location: login.php');
            break;
        case "password":
            $_SESSION["loginerror"] = "password";
            $_SESSION["loginerrorusername"] = $_POST["username"];
            header('Location: login.php');
            break;
        default:
            $_SESSION["token"] = $token;
            $_SESSION["success"] = true;
            header('Location: login.php');
            break;
    }
}
