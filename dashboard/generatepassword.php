<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:51
 */

    if (!isset($_SESSION)) session_start();

    include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';

    $domains = $db->getKeyedDomains($_SESSION["token"]);

    if (isset($_SESSION["generatesuccess"]))
    {
        $_SESSION["generatedpassword"] = $_SESSION["generatesuccess"];
        unset($_SESSION["generatesuccess"]);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard/generatedpassword.php';
    }
    else
    {
        if (isset($_SESSION["generateerror"])) {
            echo
                "<div class='alert alert-danger' role='alert'>
                            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                            <span class='sr-only'>Error:</span>
                            " . $_SESSION["generateerror"] . "
                        </div>";

            unset($_SESSION["generateerror"]);
        }

?>

<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="../action/generate.php">
        <div class="form-group">
            <label class="control-label col-sm-12" for="domain"
                   style="text-align: center; padding-bottom: 10px;">Domain</label>

            <div class="col-sm-12">
                <select name="domain" class="form-control" id="domain" name="domain"
                        style="text-align: center;">
                    <?php foreach ($domains as $domain): ?>
                        <option value="<?= $domain; ?>"><?= $domain; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-12" for="password"
                   style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>

            <div>
                <input type="password" name="password" class="form-control" id="password"
                       style="text-align: center;">
            </div>
        </div>
        <div>
            <div class="col-md-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Generate</button>
            </div>
        </div>
    </form>
</div>

<?php } ?>