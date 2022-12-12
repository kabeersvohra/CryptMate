<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:26
 */

include_once 'connectDb.php';

if (!isset($_SESSION)) session_start();

if (isset($_POST["email"]) && isset($_POST["username"]))
{
    if($db->forgottenPassword($_POST["email"], $_POST["username"]))
    {
        $_SESSION['forgottenpasswordsuccessmsg'] = "Success!  Please check your email for further instructions";
    }
    else
    {
        $_SESSION['forgottenpasswordfailuremsg'] = "The credentials provided were not found.  Please try again";
    }
    header('Location: forgottenpassword.php');
}

?>

</div>
</body>