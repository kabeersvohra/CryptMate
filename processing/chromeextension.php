<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 12/08/2015
 * Time: 12:27
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (isset($_POST['username']) && isset($_POST['password']))
{
    $token = $db->verifyUser($_POST['username'], $_POST['password']);
    switch ($token)
    {
        case "username":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Username not found'
            ));
            break;
        case "unverified":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Email unverified'
            ));
            break;
        case "password":
            $result = json_encode(array
            (
                'returntype' => 'error',
                'error' => 'Password is not correct'
            ));
            break;
        default:
            $result = json_encode(array
            (
                'returntype' => 'token',
                'token' => $token
            ));
            break;
    }
}

echo $result;

