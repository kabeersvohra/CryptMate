<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 22:35
 */

include_once 'header.php';
?>

<title>Verify Email</title>
</head>
<body>

<div class="container mainbody" style="text-align: center;">

<?php

    if (isset($_GET["email"]) && isset($_GET["hash"]))
        switch($db->verifyEmail($_GET["email"], $_GET["hash"]))
        {
            case true:
                echo "Email verified successfully";
                break;
            case false:
                echo "Email not verified, please try again or request another email verification";
                break;
        }
    else
        echo "To verify your email account please click the verification link in the email";

?>

</div>

</body>
