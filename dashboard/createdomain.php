<?php
    if (!isset($_SESSION)) session_start();

    include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';

    if (isset($_SESSION["domainsuccess"]))
    {
        $_SESSION["generatedpassword"] = $_SESSION["domainsuccess"];
        unset($_SESSION["domainsuccess"]);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard/generatedpassword.php';
    }
    else
    {
        if (isset($_SESSION["domainerror"]))
        {
            echo
                "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    " . $_SESSION["domainerror"] . "
                </div>";

            unset($_SESSION["domainerror"]);
        }

        $domains = $db->getKeyedDomains($_SESSION["token"]);
        array_unshift($domains, "")

?>

<div class="col-sm-6 col-sm-offset-3">
    <form class="form-horizontal" role="form" id="form" method="post" action="../action/createdomain.php">
        <div class="form-group">
            <label class="control-label col-sm-12" style="text-align: center; padding-bottom: 10px;">Website</label>
            <div class="col-xs-4" style="margin-right: -2px;">
                <input type="text" name="subdomain"
                <?php
                    if (isset($_SESSION["domainerrorsubdomain"]))
                    {
                        echo "value='" . $_SESSION["domainerrorsubdomain"] . "'";
                        unset($_SESSION["domainerrorsubdomain"]);
                    }
                ?>
                placeholder="www" class="form-control" id="subdomain" style="text-align: center;">
            </div>
            <div style="float: left"> . </div>
            <div class="col-xs-4" style="margin-left: -2px; margin-right: -2px;">
                <input type="text" name="hostname"
                <?php
                if (isset($_SESSION["domainerrorhostname"]))
                {
                    echo "value='" . $_SESSION["domainerrorhostname"] . "'";
                    unset($_SESSION["domainerrorhostname"]);
                }

                ?>
                placeholder="example" class="form-control" id="hostname" style="text-align: center;">
            </div>
            <div style="float: left"> . </div>
            <div class="col-xs-4" style="margin-left: -2px;">
                <input type="text" name="tld"
                <?php
                if (isset($_SESSION["domainerrortld"]))
                {
                    echo "value='" . $_SESSION["domainerrortld"] . "'";
                    unset($_SESSION["domainerrortld"]);
                }

                ?>
                placeholder="com" class="form-control" id="tld" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="linkdomain"
                   style="text-align: center; padding-bottom: 10px;">Link Domain:</label>

            <div class="col-sm-12">
                <select name="linkdomain" class="form-control" id="domain" name="domain"
                        style="text-align: center;">
                    <?php foreach ($domains as $domain): ?>
                        <option value="<?= $domain; ?>"><?= $domain; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
            <div class="col-sm-12">
                <input type="password" name="password" class="form-control" id="password" autocomplete="off" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-12" for="confirmpassword" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Confirm Password</label>
            <div class="col-sm-12">
                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" autocomplete="off" style="text-align: center;">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>

<?php } ?>
