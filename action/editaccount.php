<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 16:20
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmpassword"]))
{

    if ($_POST["name"] == "")
    {
        $_SESSION["editerror"] = "Name is a required field, please enter a name";
        $_SESSION["editerrorname"] = $_POST["name"];
        $_SESSION["editerrorusername"] = $_POST["username"];
        $_SESSION["editerroremail"] = $_POST["email"];
        header("Location: ../signup.php");
        exit;
    }

    $_POST["username"] = strtolower($_POST["username"]);
    if (preg_match('/^[a-z0-9_-]{3,16}$/', $_POST["username"]) != 1)
    {
        $_SESSION["signuperror"] = "Username must be between 3 and 16 characters and contain only letters, numbers or hyphens.";
        $_SESSION["signuperrorname"] = $_POST["name"];
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("Location: ../signup.php");
        exit;
    }

    $_POST["email"] = strtolower($_POST["email"]);
    if (preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $_POST["email"]) != 1)
    {
        $_SESSION["signuperror"] = "Email address is incorrect, please enter a valid email address";
        $_SESSION["signuperrorname"] = $_POST["name"];
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("Location: ../signup.php");
        exit;
    }

    if ($_POST["password"] != $_POST["confirmpassword"])
    {
        $_SESSION["signuperror"] = "Passwords do not match, please try again";
        $_SESSION["signuperrorname"] = $_POST["name"];
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("Location: ../signup.php");
        exit;
    }

    if (preg_match('/^.*(?=.{7,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $_POST["password"]) != 1)
    {
        $_SESSION["signuperror"] = "Password must be at least 7 characters long and contain an uppercase digit, a lowercase digit and a number";
        $_SESSION["signuperrorname"] = $_POST["name"];
        $_SESSION["signuperrorusername"] = $_POST["username"];
        $_SESSION["signuperroremail"] = $_POST["email"];
        header("Location: ../signup.php");
        exit;
    }

    $token = $db->createUser($_POST["name"], $_POST["username"], $_POST["password"], $_POST["email"]);

    switch ($token)
    {
        case "username":
            $_SESSION["signuperror"] = "Username is already taken, please try another";
            $_SESSION["signuperrorname"] = $_POST["name"];
            $_SESSION["signuperrorusername"] = $_POST["username"];
            $_SESSION["signuperroremail"] = $_POST["email"];
            header("Location: ../signup.php");
            exit;
        case "email":
            $_SESSION["signuperror"] = "You have already signed up with this email address, please <a href='../login.php'>log in</a>";
            $_SESSION["signuperrorname"] = $_POST["name"];
            $_SESSION["signuperrorusername"] = $_POST["username"];
            $_SESSION["signuperroremail"] = $_POST["email"];
            header("Location: ../signup.php");
            exit;
        default:
            $_SESSION["signupsuccess"] = "Successfully signed up, please verify your email address and log in";
            header("Location: ../signup.php");
            exit;
    }
}