<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 17/09/2016
 * Time: 16:21
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_GET['username']) && isset($_GET['password']))
{
    try {
        $token = $db->verifyUser($_GET['username'], $_GET['password']);

        if ($db->getSubscriptionEnded($token)) {
            header("HTTP/1.1 401 Unauthorized");
            echo 'subscriptionEnded';
        }

        echo $token;

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