<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 16:47
 */

include_once '../database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

$assoc = $db->getAccountDetails($_SESSION["token"]);
$name = $assoc["name"];
$username = $assoc["username"];
$email = $assoc["email"];

?>
<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="../action/editaccount.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="name" style="text-align: center; padding-bottom: 10px;">Name</label>
            <div class="col-sm-12">
                <input type="text"
                 value="<?= $name ?>"
                 class="form-control" id="name" name="name" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
            <div class="col-sm-12">
                <input type="text"
                 value="<?= $username ?>"
                 class="form-control" id="username" name="username" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Email</label>
            <div class="col-sm-12">
                <input type="text"
                 value="<?= $email ?>"
                 class="form-control" id="email" name="email" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
            <div class="col-sm-12">
                <input type="password" name="password" class="form-control" id="password" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="confirmpassword" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Confirm Password</label>
            <div class="col-sm-12">
                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Edit</button>
            </div>
        </div>
    </form>
</div>