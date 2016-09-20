<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 19/09/2016
 * Time: 18:29
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_GET['domain']) && isset($_GET['token']) && isset($_GET['password']) && isset($_GET['linkDomain']))
{
    try {
        $hash = $db->createDomain($_GET['token'], $_GET['password'], $_GET['domain'], $_GET['linkDomain']);
        echo $hash;
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