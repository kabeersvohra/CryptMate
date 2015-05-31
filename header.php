<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 14:06
 */

include_once 'database.php';

$status = true;
$db = new Database("localhost", "root", "NFzdWEmbSyQswrE9", "safecrypt");

$status = $db->connect();

if (!isset($_SESSION)) session_start();

?>

<!DOCTYPE html>
<html>
    <head>
