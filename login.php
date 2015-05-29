<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 15:24
 */

include 'header.php';

?>
    <title>Login</title>
</head>
<body>

<form action="action_login.php" method="POST">
    Username:<br>
    <input type="text" name="username">
    <br>
    Password:<br>
    <input type="password" name="password">
    <br>
    <input type="submit" name="submit">
</form>

<?php

?>
</body>