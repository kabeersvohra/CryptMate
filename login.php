<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 15:24
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/headers/header.php';

?>
    <title>Login</title>
</head>
<body>

<div class="container mainbody">

    <?php
    if (isset($_SESSION["loginerror"]))
    {
        switch ($_SESSION["loginerror"])
        {
            case "unverified":
                echo
                "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    Account is unverifed, please verify and try again. If you need to request a new email verification, please click <a href='resendemailverification.php'>here</a>.
                 </div>";
                break;
            case "password":
                echo
                "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    Password is incorrect. Forgotten your password? Please click <a href='forgottenpassword.php'>here</a>.
                 </div>";
                break;
            case "username":
                echo
                "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    Account is not created yet. If you need to create an account, please click <a href='signup.php'>here</a>.
                 </div>";
                break;
            default:
                echo
                "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    Unexpected error, please try again.
                 </div>";
                break;
        }

        unset($_SESSION["loginerror"]);
    }
    elseif (isset($_SESSION["success"]))
    {
        if ($_SESSION["success"])
            echo
            "<div class='alert alert-success' role='alert'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Success:</span>
                Login success!
             </div>";
        unset($_SESSION["success"]);
    }
    ?>

    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action/login.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="username" name="username" style="text-align: center;"
                        value="<?php
                            if (isset($_SESSION["loginerrorusername"]))
                            {
                                echo $_SESSION["loginerrorusername"];
                                unset($_SESSION["loginerrorusername"]);
                            }
                        ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control" id="password" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Login</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-sm-12" style="text-align: center;padding-top: 20px;line-height: 30px;">
        <p>Haven't got an account yet? Create one <a href="signup.php">here</a></p>
        <p>Forgotten your password? Reset it <a href="forgottenpassword.php">here</a></p>
        <p>Forgotten your username? Request a reminder <a href="forgottenusername.php">here</a></p>
    </div>

</div>

</body>