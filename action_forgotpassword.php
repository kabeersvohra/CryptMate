<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:26
 */

include_once 'header.php';

?>
<title>Forgotten Password</title>
<link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="container mainbody" style="text-align: center;">

<?php

if (isset($_POST["email"]) && isset($_POST["username"]))
{
    if($db->forgottenPassword($_POST["email"], $_POST["username"]))
    {
        $_SESSION['successmsg'] = "Success!  Please check your email for further instructions";
    }
    else
    {
        $_SESSION['failuremsg'] = "The credentials provided were not found.  Please try again";
    }
    header('Location: forgottenpassword.php');
}

?>

</div>
</body>