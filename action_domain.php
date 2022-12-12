<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 21:54
 */

include 'header.php';
?>

    <title>Encrypted</title>
</head>
<body>

<?php
if (isset($_POST["password"]) && isset($_POST["subdomain"]) && isset($_POST["hostname"]) && isset($_POST["tld"]))
{
    //best course of action if website is already in db

    $hash = $db->newWebsite($_SESSION["token"], $_POST["password"], $_POST["subdomain"], $_POST["hostname"], $_POST["tld"]);

    switch($hash)
    {
        case "tokenerror":
            echo "Token is invalid, please sign in again or if you are having further issues please contact us";
            break;
        default:
            echo "Generated hash is $hash";
            break;
    }
}
