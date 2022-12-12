<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 19:12
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if ($db->deleteAccount($_SESSION['token']))
{
    unset ($_SESSION['token']);
    header("Location: ../");
    exit;
}
else
{
    $_SESSION["deleteaccounterror"] = "There was an unexpected error while deleting your account. Please try again or contact customer support and we will be happy to assist you.";
    header("Location: ../dashboard.php#deleteaccount");
    exit;
}
