<?php
$loggedin = isset($_COOKIE["token"]);

if ($loggedin) {
    unset($_COOKIE["token"]);
    setcookie('token', '', time() - 3600, '/');
}

if ($loggedin)
    $title = "Logged Out";
else
    $title = "Log Out";
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <?php include("includes/header.php") ?>
    <title><?= $title ?></title>

</head>
<body>

<?php include_once 'includes/navbar.php' ?>

<div class="container" style="margin-top: 70px; text-align: center; font-weight: normal;">
    <?php
    if ($loggedin)
        echo "You have logged out successfully";
    else
        echo "You are not logged in, please log in";
    ?>
</div>


<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>


