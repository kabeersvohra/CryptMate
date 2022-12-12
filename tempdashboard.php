<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="js/jquery.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicon/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <link rel="shortcut icon" href="/img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-144x144.png">
    <meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

</head>

<link href="css/navbar.css" rel="stylesheet">

<nav class="navbar navbar-fixed-top navbar-light bg-faded topnav" role="navigation" style="padding: 0px;">
    <div class="container topnav">
        <a class="navbar-brand" style="padding: 10px;" href="/"><div id="img" style="height: 30px;"></div></a>
        <ul class="nav navbar-nav navbar-right" style="padding: 10px;">
            <a class="nav-item nav-link" href="#" >Login</a>
            <span class="fa fa-gear"></span>
<!--            --><?php
//            if (isset($_SESSION["token"]))
//                $user = $db->getLoggedinUser($_SESSION["token"]);
//            else
//                $user = false;
//
//            if($user == false) :
//                ?>
<!--                <li>-->
<!--                    <a href="login.php">Login</a>-->
<!--                </li>-->
<!--            --><?php //else : ?>
<!--                <li>-->
<!--                    <a style="color: #777">Logged in as --><?//= $user; ?><!-- </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="dashboard.php">Dashboard</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="logout.php">Logout</a>-->
<!--                </li>-->
<!--            --><?php //endif; ?>
        </ul>
    </div>
    <!-- /.container -->
</nav>

<head>
<title>Dashboard</title>

</head>

<body>

<div class="container" style="margin-top: 70px;">

    <div class="col-xs-6">
        <h1>Dashboard</h1>
    </div>
    <div class="col-xs-6" style="text-align: right; font-size: 30px;">
        <p>
            <a href="#">
                <span class="fa fa-plus" style="color: black;"></span>
            </a>
        </p>
    </div>

    <div class="col-xs-12">
        <table style="width: 100%;">
            <tr style="text-align: center">
                <td><img src="img/favicon/favicon-16x16.png"/> </td>
                <td>facebook.com</td>
                <td><input type="text"/></td>
                <td><span class="fa fa-minus" style="color: black;"></span></td>
            </tr>
        </table>
    </div>


</div>

</body>