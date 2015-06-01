<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:19
 */

if (!isset($_SESSION)) session_start();
$loggedin = isset($_SESSION["token"]);
if ($loggedin)
    unset($_SESSION["token"]);

include_once 'header.php';

if ($loggedin)
    echo "You have logged out successfully";
else
    echo "You are not logged in, please log in";

