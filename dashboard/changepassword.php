<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 16:47
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

if (!isset($_SESSION)) session_start();

if (isset($_SESSION["changepasswordsuccess"]))
{
    echo
        "<div class='alert alert-success' role='alert'>
        <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
        <span class='sr-only'>Success:</span>
        " . $_SESSION["changepasswordsuccess"] . "
     </div>";
    unset($_SESSION["changepasswordsuccess"]);
}
elseif (isset($_SESSION["changepassworderror"]))
{
    echo
        "<div class='alert alert-danger' role='alert'>
        <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
        <span class='sr-only'>Error:</span>
        " . $_SESSION["changepassworderror"] . "
     </div>";
    unset($_SESSION["changepassworderror"]);
}

?>
<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="../action/changepassword.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Old Password</label>
            <div class="col-sm-12">
                <input type="password" name="oldpassword" class="form-control" id="oldpassword" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">New Password</label>
            <div class="col-sm-12">
                <input type="password" name="newpassword" class="form-control" id="newpassword" style="text-align: center;">
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
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>