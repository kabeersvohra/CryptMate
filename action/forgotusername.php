<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 23:04
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["email"]))
{
    if ($db->remindUsername($_POST["email"]))
    {
        $_SESSION['forgottenusernamesuccessmsg'] = "Success!  Please check your email for further instructions";
    }
    else
    {
        $_SESSION['forgottenusernamefailuremsg'] = "The credentials provided were not found.  Please try again";
    }
    header('Location: ../forgottenusername.php');
    exit;
}
