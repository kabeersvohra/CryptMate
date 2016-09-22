<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

$currentPassword = $_POST["currentpassword"];
$newPassword = $_POST["newpassword"];
$token = $_POST["token"];

if(isset($currentPassword) && isset($newPassword) && isset($token))
{
    try {
        $db->changePassword($currentPassword, $newPassword, $token);
    }
    catch (Exception $e) {
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