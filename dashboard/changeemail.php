<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 27/07/2015
 * Time: 16:47
 */

include_once '../connectdatabase.php';

if (!isset($_SESSION)) session_start();


if (isset($_SESSION["changeemailsuccess"]))
{
    echo
        "<div class='alert alert-success' role='alert'>
        <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
        <span class='sr-only'>Success:</span>
        " . $_SESSION["changeemailsuccess"] . "
     </div>";
    unset($_SESSION["changeemailsuccess"]);
}
elseif (isset($_SESSION["changeemailerror"]))
{
    echo
        "<div class='alert alert-danger' role='alert'>
        <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
        <span class='sr-only'>Error:</span>
        " . $_SESSION["changeemailerror"] . "
     </div>";
    unset($_SESSION["changeemailerror"]);
}

?>
<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="action/changeemail.php">

        <div class="form-group">
            <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Current Email</label>
            <div class="col-sm-12">
                <input type="text"
                 value="<?php if (isset ($_SESSION["changeemailerrorcurrent"])) echo $_SESSION["changeemailerrorcurrent"]; unset($_SESSION["changeemailerrorcurrent"]); ?>"
                 class="form-control" id="currentemail" name="currentemail" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="newemail" style="text-align: center; padding-bottom: 10px;">New Email</label>
            <div class="col-sm-12">
                <input type="text"
                 value="<?php if (isset ($_SESSION["changeemailerrornew"])) echo $_SESSION["changeemailerrornew"]; unset($_SESSION["changeemailerrornew"]); ?>"
                 class="form-control" id="newemail" name="newemail" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>