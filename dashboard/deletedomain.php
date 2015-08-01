<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:51
 */

if (!isset($_SESSION)) session_start();

include_once '../connectdatabase.php';

$domains = $db->getKeyedDomains($_SESSION["token"]);

if (isset($_SESSION["deletedomainsuccess"]))
{
    echo
        "<div class='alert alert-success' role='alert'>
                        <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
                        <span class='sr-only'>Success:</span>
                        " . $_SESSION["deletedomainsuccess"] . "
                    </div>";

    unset($_SESSION["deletedomainsuccess"]);
}
elseif (isset($_SESSION["deletedomainerror"]))
{
    echo
        "<div class='alert alert-danger' role='alert'>
                        <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                        <span class='sr-only'>Error:</span>
                        " . $_SESSION["deletedomainerror"] . "
                    </div>";
    unset($_SESSION["deletedomainerror"]);
}

?>

<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="action/deletedomain.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="domain"
                   style="text-align: center; padding-bottom: 10px;">Domain</label>

            <div class="col-sm-12">
                <select name="domain" class="form-control" id="domain" name="domain"
                        style="text-align: center;">
                    <?php foreach ($domains as $domain): ?>
                        <option value="<?php echo $domain; ?>"><?php echo $domain; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div>
            <div class="col-md-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Delete</button>
            </div>
        </div>
    </form>
</div>
