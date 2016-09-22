<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

if (isset($_POST["currentemail"]) && isset($_POST["newemail"]) && isset($_POST["token"]))
{
    $currentEmail = strtolower($_POST["currentemail"]);
    $newEmail = strtolower($_POST["newemail"]);
    $token = $_POST["token"];

    if ($currentEmail == $newEmail)
    {
        header("HTTP/1.1 401 Unauthorized");
        echo "sameEmail";
        exit;
    }

    try {
        $db->isCurrentEmail($token, $currentEmail);
        $db->isNewEmail($newEmail);
        if (preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $_POST["newemail"]) != 1)
            throw new Exception("newEmailIncorrect");
        $db->changeEmail($token, $currentEmail, $newEmail);
        echo true;
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