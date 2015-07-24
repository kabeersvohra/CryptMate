<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 19:53
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

$hash = $db->generatePassword($_POST["domain"], $_POST["password"], $_SESSION["token"]);

if (isset($_POST["domain"]) && isset($_POST["password"]) && isset($_SESSION["token"]))
{
    $hash = $db->generatePassword($_POST["domain"], $_POST["password"], $_SESSION["token"]);

    switch($hash)
    {
        case "tokenerror":
            echo "Token is invalid, please sign in again or if you are having further issues please contact us";
            break;
        default:
            echo "Generated hash is $hash";
            break;
    }
}
