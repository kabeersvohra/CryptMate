<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:23
 */

include_once 'header.php';

?>
<title>Forgotten Password</title>
</head>
<body>

<div class="container mainbody">

    <?php

    if (isset($_SESSION['forgottenpasswordsuccessmsg']))
    {
        echo
            "<div class='alert alert-success' role='alert'>
                <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
                <span class='sr-only'>Success:</span>
                " . $_SESSION["forgottenpasswordsuccessmsg"] . "
             </div>";
    }
    elseif (isset($_SESSION['forgottenpasswordfailuremsg']))
    {
        echo
            "<div class='alert alert-danger' role='alert'>
                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                " . $_SESSION["forgottenpasswordfailuremsg"] . "
             </div>";
    }

    unset($_SESSION['forgottenpasswordsuccessmsg']);
    unset($_SESSION['forgottenpasswordfailuremsg']);

    ?>

    <p style="text-align: center">Please enter your email address and username:</p>
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action/action_forgotpassword.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="email" name="email" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text" name="username" class="form-control" id="username" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Forgot</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>