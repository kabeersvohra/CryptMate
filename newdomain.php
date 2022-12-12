<?php

    if (isset($_SESSION["domainerror"]))
    {
        echo
        "<div class='alert alert-danger' role='alert'>
            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
            <span class='sr-only'>Error:</span>
            " . $_SESSION["domainerror"] . "
        </div>";
    }

?>

<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="action_domain.php">
        <div class="form-group">
            <label class="control-label col-sm-12" style="text-align: center; padding-bottom: 10px;">Website</label>
            <div class="col-xs-4" style="margin-right: -2px;">
                <input type="text" name="subdomain" placeholder="www" class="form-control" id="subdomain" style="text-align: center;">
            </div>
            <div style="float: left"> . </div>
            <div class="col-xs-4" style="margin-left: -2px; margin-right: -2px;">
                <input type="text" name="hostname" placeholder="example" class="form-control" id="hostname" style="text-align: center;">
            </div>
            <div style="float: left"> . </div>
            <div class="col-xs-4" style="margin-left: -2px;">
                <input type="text" name="tld" placeholder="com" class="form-control" id="tld" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
            <div class="col-sm-12">
                <input type="password" name="password" class="form-control" id="password" name="password" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="confirmpassword" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Confirm Password</label>
            <div class="col-sm-12">
                <input type="password" name="confirmpassword" class="form-control" id="password" name="password" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>

