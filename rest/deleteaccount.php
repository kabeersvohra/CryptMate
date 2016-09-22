<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 20/09/2016
 * Time: 17:30
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST['token']))
{
    try {
        $db->deleteAccount($_POST['token']);
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