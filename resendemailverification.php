<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:23
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';

?>

<title>Resend Verification</title>
</head>
<body>

<div class="container mainbody">

    <?php
    if (isset($_SESSION["resendsuccess"]))
    {
        if ($_SESSION["resendsuccess"])
            echo
            "<div class='alert alert-success' role='alert'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Success:</span>
                Email verification has been resent, please check your inbox
             </div>";
        else
            echo
            "<div class='alert alert-danger' role='alert'>
                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                Account not found in database, please check your credentials or make an account if you have not already done so
             </div>";
        unset($_SESSION["resendsuccess"]);
    }
    ?>


    <p style="text-align: center">Please enter your email address or your username:</p>
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action/resend.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="username" name="username" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="email" name="email" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Resend</button>
                </div>
            </div>
        </form>
    </div>

</div>

</body>