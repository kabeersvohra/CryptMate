<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:51
 */

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

$domains = $db->getKeyedDomains($_SESSION["token"]);

if (isset($_SESSION["deleteaccounterror"]))
{
    echo
        "<div class='alert alert-danger' role='alert'>
                        <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                        <span class='sr-only'>Error:</span>
                        " . $_SESSION["deleteaccounterror"] . "
                    </div>";
    unset($_SESSION["deleteaccounterror"]);
}

?>

<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="../action/deleteaccount.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="domain"
                   style="text-align: center; padding-bottom: 10px;">Are you sure you want to delete? For your security, the moment you press delete ALL of your data will be irrevocably deleted from our servers and the only way to start again would be to create a new account.</label>
        </div>
        <div>
            <div class="col-md-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">DELETE</button>
            </div>
        </div>
    </form>
</div>
