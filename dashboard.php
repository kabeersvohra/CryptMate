<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <?php include("headers/header.php") ?>

    <title>Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<?php
    session_start();
    $loggedin = true;
    $username = "Login";
    $domains = array("facebook.com", "google.com", "how-to-geek.com", "facebook.com", "google.com", "how-to-geek.com", "facebook.com", "google.com", "how-to-geek.com");

    if (isset($_SESSION['token']))
    {
        $username = "KVohra95";
        //$domains = getDomains;
    }
?>

<body>
<div id="main">
    <nav class="navbar navbar-fixed-top navbar-light bg-faded topnav" role="navigation" style="padding: 0;">
        <div class="container topnav">
            <a class="navbar-brand" style="padding: 10px;" href="/"><div id="img" style="height: 30px;"></div></a>
            <ul class="nav navbar-nav navbar-right" style="padding: 10px; ">
                <li><a class="nav-item nav-link" style="padding-right: 10px;">Login</a></li>
                <li class="nav-item btn-group">
                    <a class="dropdown-toggle nav-link" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-gear"></span> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" style="right: 0; left: auto;">
                        <a class="dropdown-item" href="#">Manage Subscription</a>
                        <a class="dropdown-item" href="#">Manage Account</a>
                        <a class="dropdown-item" href="#">Delete Account</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 70px;">

        <div class="col-xs-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-xs-6" style="text-align: right; font-size: 30px;">
            <p>
                <a href="#createDomainModal" data-toggle="modal" title="Add domain">
                    <span class="fa fa-plus" style="color: black;"></span>
                </a>
            </p>
        </div>

        <div class="col-xs-12">

                <?php
                foreach($domains as $domain){ ?>
                    <table style="width: 100%; text-align: center;">
                        <td style="padding: 10px;"><img src="https://www.google.com/s2/favicons?domain=<?php echo $domain; ?>"/> </td>
                        <td style="padding: 10px; text-align: left; width: 100%"><?php echo $domain; ?></td>
                        <td style="padding-right: 10px">
                            <span title="Regenerate salt" class="fa fa-cogs" style="color: black; "></span>
                        </td>
                        <td style="padding-right: 10px">
                            <span title="Edit domain" class="fa fa-pencil" style="color: black; "></span>
                        </td>
                        <td style="padding-right: 10px;">
                            <span title="Delete domain" class="fa fa-trash" style="color: black;"></span>
                        </td>
                    </table>
                    <table style="width: 100%; text-align: center;">
                        <td style="width: 100%; padding-left: 10px;"><input type="password" style="width: 100%; padding-left: 10px;" placeholder="Enter password"/></td>
                        <td style="padding: 10px">
                            <span class="fa fa-arrow-right" style="color: black;"></span>
                        </td>
                    </table>
                <?php } ?>
        </div>

    </div>
</div>


<div class="modal fade" id="createDomainModal" tabindex="-1" role="dialog" aria-labelledby="createDomainModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Add domain</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="domain" class="control-label">Domain</label>
                        <input type="url" class="form-control" id="domain">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword" class="control-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmpassword">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php if (!$loggedin) { ?>

    <div class="modal" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="logInModalLabel">Login</h4>
                </div>
                <div class="modal-body">
                    <?php include_once "loginform.php" ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dashboard.js"></script>

</body>