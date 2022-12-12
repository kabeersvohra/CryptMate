<?php
/**
 * Created by PhpStorm.
 * User: Kabeer.Vohra
 * Date: 9/3/2015
 * Time: 2:40 PM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/headers/header.php';
?>

<title>Reset Password</title>
</head>
<body>

<div class="container mainbody" style="text-align: center;">

<?php

if (isset($_POST["email"]) && isset($_POST["hash"]))
{
    if($db->checkResetPassword($_POST["email"], $_POST["hash"]))
    {
        ?>
        <div class="col-sm-6 col-sm-offset-3">
            <form class="form-horizontal" role="form" id="form" method="post" action="action/resetpassword.php">
                <div class="form-group">
                    <label class="control-label col-sm-12" for="password" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">New Password</label>
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
                <input type="hidden" name="hash" value="<?= $_POST["hash"] ?>" />
                <input type="hidden" name="email" value="<?= $_POST["email"] ?>" />
                <div class="form-group">
                    <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
    else
    {
        echo "Invalid email reset link, please try and request another <a href='forgottenpassword.php'>here</a>";
    }
}
elseif (isset($_POST["email"]) && isset($_POST["cancelreset"]))
{
    if ($_POST["cancelreset"])
    {
        if ($db->cancelResetPassword($_POST["email"]))
        {
            echo "Reset password link successfully cancelled";
        }
        else
        {
            echo "Unable to cancel password reset link, please contact customer service";
        }
    }
    else
    {
        echo "Unable to cancel password reset link, please contact customer service";
    }
}

?>

</div>

</body>
