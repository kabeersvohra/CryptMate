<head>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
    <title>Login</title>
</head>
<body>

<?php include "includes/navbar.php"; ?>

<div class="container" style="margin-top: 70px;">

    <?php include "forms/login.php"; ?>

    <div class="col-sm-12" style="text-align: center;padding-top: 20px;line-height: 30px;">
        <p>Haven't got an account yet? Create one <a href="signup.php">here</a></p>
        <p>Forgotten your password? Reset it <a href="forgottenpassword.php">here</a></p>
        <p>Forgotten your username? Request a reminder <a href="forgottenusername.php">here</a></p>
    </div>

</div>

<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/login.js"></script>
<script src="js/global.js"></script>

</body>