<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:51
 */


$domains = $db->getKeyedDomains($_SESSION["token"]);
?>

<div class="container mainbody">
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action_generate.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="domain" style="text-align: center; padding-bottom: 10px;">Domain</label>
                <div class="col-sm-12">
                    <select name="domain" class="form-control" id="domain" name="domain" style="text-align: center;">
                        <?php foreach($domains as $domain): ?>
                            <option value="<?php echo $domain; ?>"><?php echo $domain; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control" id="password" name="password" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>