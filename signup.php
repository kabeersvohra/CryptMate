<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 15:24
 */

include_once 'header.php';

?>
    <title>Sign Up</title>
</head>
<body>

<form action="action_signup.php" method="POST">
    Username:
    <br>
    <input type="text" name="username">
    <br>
    Email:
    <br>
    <input type="email" name="email">
    <br>
    Password:
    <br>
    <input type="password" name="password">
    <br>
    <input type="submit" name="submit">
</form>

</body>