<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 19/09/2016
 * Time: 18:29
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST['domain']) && isset($_POST['token']) && isset($_POST['password']) && isset($_POST['linkDomain']))
{
    try {
        $hash = $db->createDomain($_POST['token'], $_POST['password'], $_POST['domain'], $_POST['linkDomain']);
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