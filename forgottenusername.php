<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 15:56
 */

include_once 'header.php';

?>
<title>Forgotten Username</title>
<link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="container mainbody">

    <?php

    if (isset($_SESSION['forgottenusernamesuccessmsg']))
    {
        echo
            "<div class='alert alert-success' role='alert'>
                <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
                <span class='sr-only'>Success:</span>
                " . $_SESSION["forgottenusernamesuccessmsg"] . "
             </div>";
    }
    elseif (isset($_SESSION['forgottenusernamesuccessmsg']))
    {
        echo
            "<div class='alert alert-danger' role='alert'>
                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                " . $_SESSION["forgottenusernamefailuremsg"] . "
             </div>";
    }

    unset($_SESSION['forgottenusernamesuccessmsg']);
    unset($_SESSION['forgottenusernamefailuremsg']);

    ?>

    <p style="text-align: center">Please enter your email address:</p>
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action/action_forgotusername.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="email" name="email" style="text-align: center;">
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
