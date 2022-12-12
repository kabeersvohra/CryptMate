<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 21:51
 */
include 'header.php';

?>

    <title>New Domain</title>
</head>
<body>

<form action="action_domain.php" method="POST" autocomplete="off">
    Website:
    <br>

    <input type="text" style="display:none;">
    <input type="text" name="subdomain" placeholder="www" autocomplete="off"> .

    <input type="text" style="display:none;">
    <input type="text" name="hostname" placeholder="example" autocomplete="off"> .

    <input type="text" style="display:none;">
    <input type="text" name="tld" placeholder="com" autocomplete="off">

    <br>
    Password:
    <br>

    <input type="text" style="display:none;">
    <input type="password" name="password" autocomplete="off">

    <br>

    <input type="submit" name="submit">

</form>

</body>