<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 18/09/2016
 * Time: 11:13
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_GET['domain']) && isset($_GET['token']))
{
    try {
        $success = $db->deleteDomain($_GET['domain'], $_GET['token']);
        echo $success;
    } catch (Exception $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo $e->getMessage();
    }
}
else
{
    header("HTTP/1.1 400 Bad Request");
    echo 'invalidParameters';
}