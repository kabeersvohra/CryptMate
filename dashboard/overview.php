<?php
    include_once '../connectdatabase.php';
    if (!isset($_SESSION)) session_start();
?>

<h1 class="page-header" style="text-align: center">Dashboard</h1>

<div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
        <div class="row" style="text-align: center">
            <img src="/SafeCrypt/img/domain.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Domains">
        </div>
        <h4><?php echo $db->getNumberDomains($_SESSION["token"]); ?></h4>
        <span class="text-muted">Number of Domains</span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
        <div class="row" style="text-align: center">
            <img src="/SafeCrypt/img/password.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Passwords">
        </div>
        <h4>0</h4>
        <span class="text-muted">Number of Passwords</span>
    </div>
</div>