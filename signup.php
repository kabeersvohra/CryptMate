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
    <link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="container mainbody">
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action_signup.png">
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
                <label class="control-label col-sm-12" for="password1" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control" id="password1" name="password" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="password2" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Confirm Password</label>
                <div class="col-sm-12">
                    <input type="password" name="password" class="form-control" id="password2" name="password" style="text-align: center;">
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