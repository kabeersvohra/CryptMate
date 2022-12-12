<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 16:20
 */

include 'header.php';
?>

    <title>Signed Up</title>
</head>
<body>

<?php

$db->createUser($_POST["username"], $_POST["password"]);