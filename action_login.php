<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 19:05
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["username"]) && isset($_POST["password"]))
{
    $token = $db -> verifyUser($_POST["username"], $_POST["password"]);

    switch($token)
    {
        case "unverified":
            echo "Sorry the account has not been verified, please check your email or request another verification";
            break;
        case "username":
            echo "Sorry username was incorrect";
            break;
        case "password":
            echo "Sorry password was incorrect";
            break;
        default:
            echo "Login successful";
            $_SESSION["token"] = $token;
            break;
    }
}

include_once 'header.php';
?>

    <title>Logged In</title>
</head>
<body>

