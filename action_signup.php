<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 16:20
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

if ($_POST["password"] != $_POST["confirmpassword"])
{
    $_SESSION["signuperror"] = "Passwords do not match, please try again";
    $_SESSION["signuperrorusername"] = $_POST["username"];
    $_SESSION["signuperroremail"] = $_POST["email"];
    header("location: signup.php");
}

$token = $db->createUser($_POST["username"], $_POST["password"], $_POST["email"]);

switch ($token)
{
    case "username":
        $_SESSION["signuperror"] = "Username is already taken, please try another";
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("location: signup.php");
        break;
    case "email":
        $_SESSION["signuperror"] = "You have already signed up with this email address, please <a href='login.php'>log in</a>";
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("location: signup.php");
        break;
    default:
        $_SESSION["signupsuccess"] = "Successfully signed up, please verify your email address and log in";
        header("location: signup.php");
}