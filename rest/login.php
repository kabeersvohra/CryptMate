<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST['username']) && isset($_POST['password']))
{
    try {
        $token = $db->verifyUser($_POST['username'], $_POST['password']);

        if ($db->getSubscriptionEnded($token)) {
            header("HTTP/1.1 401 Unauthorized");
            echo 'subscriptionEnded';
            exit;
        }

        echo $token;
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