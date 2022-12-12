<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:19
 */

if (!isset($_SESSION)) session_start();
$loggedin = isset($_SESSION["token"]);
if ($loggedin)
    unset($_SESSION["token"]);

include_once $_SERVER['DOCUMENT_ROOT'] . '/headers/header.php';
?>
<head>
    <?php
        if ($loggedin)
            echo "<title>Logged Out</title>";
        else
            echo "<title>Log Out</title>";
    ?>
</head>
<body>
<div class="container mainbody" style="text-align: center; font-weight: normal;">
    <?php
        if ($loggedin)
            echo "You have logged out successfully";
        else
            echo "You are not logged in, please log in";
    ?>
</div>
</body>


