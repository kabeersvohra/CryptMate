<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 14:06
 */

include 'database.php';

$status = true;
$db = new Database("localhost", "root", "NFzdWEmbSyQswrE9", "safecrypt");

$status = $db->connect();

?>

<html>
    <head>