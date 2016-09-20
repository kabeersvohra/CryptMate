<?php
$deleted = isset($_POST["deleted"]);

if ($deleted)
    $title = "Account Deleted";
else
    $title = "Delete Account";
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php" ?>
    <title><?= $title ?></title>

</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php' ?>

<div class="container" style="margin-top: 70px; text-align: center; font-weight: normal;">
    <?php
    if ($deleted)
        echo "Account has been fully deleted, all data has been removed from our servers";
    else
        echo "To delete your account please click the settings dropdown and then select 'Delete Account'";
    ?>
</div>


<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>


