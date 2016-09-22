<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 17/09/2016
 * Time: 16:39
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST['domain']) && isset($_POST['password']) && isset($_POST['token']))
{
    try {
        $hash = $db->generatePassword($_POST['domain'], $_POST['password'], $_POST['token']);
        echo $hash;
        exit;
    } catch (Exception $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo $e->getMessage();
        exit;
    }
}
else
{
    header("HTTP/1.1 400 Bad Request");
    echo 'invalidParameters';
    exit;
}