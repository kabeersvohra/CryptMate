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

    if (isset($_GET["email"]) && isset($_GET["hash"]) && isset($_GET["newemail"]))
        if ($_GET["newemail"] == 1)
            switch ($db->verifyNewEmail($_GET["email"], $_GET["hash"]))
            {
                case "1":
                    echo "Your current email has been successfully verified. Please verify your new email for the change to be processed";
                    break;
                case "2":
                    echo "Your new email has been successfully verified. Please verify your current email for the change to be processed";
                    break;
                case "3":
                    echo "Both emails have been successfully verified. Your new email address has been processed";
                    break;
                case "4":
                    echo "Email not verified due to an unknown error, please try again or request another email verification";
                    break;
            }
        else
            if ($db->verifyEmail($_GET["email"], $_GET["hash"]))
                echo "Email verified successfully";
            else
                echo "Email not verified due to an unknown error, please try again or request another email verification";
    else
        echo "To verify your email account please click the verification link in the email";

?>

</div>

</body>
