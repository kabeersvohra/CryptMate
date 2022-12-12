<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 19:05
 */

include 'header.php';
?>

    <title>Logged In</title>
</head>
<body>

<?php
if (isset($_POST["username"]) && isset($_POST["password"]))
{
    $token = $db -> verifyUser($_POST["username"], $_POST["password"]);

    switch($token)
    {
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
