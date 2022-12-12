<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 15:24
 */

include_once 'header.php';

?>
    <title>Sign Up</title>
</head>
<body>

<div class="container mainbody">

    <?php
        if (isset($_SESSION["signupsuccess"]))
        {
            echo
                "<div class='alert alert-success' role='alert'>
                <span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span>
                <span class='sr-only'>Success:</span>
                " . $_SESSION["signupsuccess"] . "
             </div>";
            unset($_SESSION["signupsuccess"]);
        }
        elseif (isset($_SESSION["signuperror"]))
        {
            echo
                "<div class='alert alert-danger' role='alert'>
                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                " . $_SESSION["signuperror"] . "
             </div>";
            unset($_SESSION["signuperror"]);
        }
    ?>

    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action/action_signup.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="name" style="text-align: center; padding-bottom: 10px;">Name</label>
                <div class="col-sm-12">
                    <input type="text"
                     value="<?php if (isset($_SESSION["signuperrorname"])) {echo $_SESSION["signuperrorname"]; unset($_SESSION["signuperrorname"]);} ?>"
                     class="form-control" id="name" name="name" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text"
                     value="<?php if (isset($_SESSION["signuperrorusername"])) {echo $_SESSION["signuperrorusername"]; unset($_SESSION["signuperrorusername"]);} ?>"
                     class="form-control" id="username" name="username" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="text"
                     value="<?php if (isset($_SESSION["signuperroremail"])) {echo $_SESSION["signuperroremail"]; unset($_SESSION["signuperroremail"]);} ?>"
                     class="form-control" id="email" name="email" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control" id="password" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="confirmpassword" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Confirm Password</label>
                <div class="col-sm-12">
                    <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Signup</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-sm-12" style="text-align: center;padding-top: 20px;line-height: 30px;">
        <p>Already signed up? Log in <a href="login.php">here</a></p>
    </div>

</div>

</body>