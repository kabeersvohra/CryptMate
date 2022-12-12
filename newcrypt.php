<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 21:51
 */
include 'header.php';

?>

    <title>New Encryption</title>
</head>
<body>

<form action="action_crypt.php" method="POST">
    Website:
    <br>
    <input type="text" name="subdomain" placeholder="www"> .
    <input type="text" name="hostname" placeholder="example"> .
    <input type="text" name="tld" placeholder="com">
    <br>
    Password:
    <br>
    <input type="password" name="password">
    <br>
    <input type="submit" name="submit">
</form>

</body>