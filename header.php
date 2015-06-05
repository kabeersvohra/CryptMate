<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 14:06
 */

include_once 'database.php';

$status = true;
$db = new Database("localhost",
    "XAbGnfREj3YGbl9U",
    "jxki3u6ugPlyoS1YhqRQk6UNQwBVXfcIc1A6H6w16NpHYf8rIgZP0nkPr8FvDAiL",
    "safecrypt");

$status = $db->connect();

if (!isset($_SESSION)) session_start();

if (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
