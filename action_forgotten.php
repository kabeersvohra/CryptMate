<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:26
 */

include_once "header.php";

if (isset($_POST["email"]) && isset($_POST["username"]))
{
    if($db->forgottenPassword($_POST["email"], $_POST["username"]))
    {
        echo "To reset your password please check your email for further instructions";
    }
    else
    {
        echo "The credentials provided were not in the database. Please try again or create an account if you do not have one";
    }
}