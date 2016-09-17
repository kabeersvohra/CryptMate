<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 17/09/2016
 * Time: 16:39
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_GET['domain']) && isset($_GET['password']) && isset($_GET['token']))
{
    try {
        $hash = $db->generatePassword($_GET['domain'], $_GET['password'], $_GET['token']);
        echo $hash;
    } catch (Exception $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo $e->getMessage();
    }
}