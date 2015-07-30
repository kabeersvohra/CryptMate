<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 16:47
 */

include_once '../connectdatabase.php';

if (!isset($_SESSION)) session_start();



?>
<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="action/action_edit.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">New Password</label>
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
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>