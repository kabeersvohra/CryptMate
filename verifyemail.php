<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 22:35
 */

include 'header.php';

switch($db->verifyEmail($_GET["email"], $_GET["hash"]))
{
    case true:
        break;
    case false:
        break;
}