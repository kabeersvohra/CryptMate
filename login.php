<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 15:24
 */

include_once 'header.php';

?>
    <title>Login</title>
</head>
<body>

<div class="container mainbody">
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action_login.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="username" name="username" style="text-align: center;">
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