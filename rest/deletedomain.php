<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 18/09/2016
 * Time: 11:13
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST['domain']) && isset($_POST['token']))
{
    try {
        $success = $db->deleteDomain($_POST['domain'], $_POST['token']);
        echo $success;
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