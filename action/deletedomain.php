<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 17:45
 */

include_once '../connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["domain"]))
{
    if ($db->deleteDomain($_POST["domain"], $_SESSION["token"]))
    {
        $_SESSION["deletedomainsuccess"] = "Domain successfully deleted";
        header("Location: ../dashboard.php#deletedomain");
        exit;
    }
    else
    {
        $_SESSION["deletedomainerror"] = "Domain not deleted due to an unforseen error, please try again or contact customer support.";
        header("Location: ../dashboard.php#deletedomain");
        exit;
    }
}
else
{
    $_SESSION["deletedomainerror"] = "No domain specified, please select a domain to delete";
    header("Location: ../dashboard.php#deletedomain");
    exit;
}