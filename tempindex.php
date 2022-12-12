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

        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="css/tempindex.css" rel="stylesheet" type="text/css">

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/tempindex.js"></script>

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

    <body>
        <div class="container" style="padding-top: 20px;">

            <div class="col-md-6 col-xs-12 col-md-offset-1" style="text-align: center;">
                <div class="col-xs-6 col-xs-offset-3 col-md-8 col-md-offset-2">
                    <img src="img/logo.png" style="width: 100%">
                    <p>Regain control of your security</p>
                    <p>youtube</p>
                </div>
            </div>

            <div class="col-md-4 col-xs-12" style="text-align: center;">
                <div class="col-xs-10 col-xs-offset-1 col-md-12">

<!--                    <form class="form-horizontal" role="form" id="form" method="post" action="action/login.php" style="padding-top: 10%">-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-12">-->
<!--                                <input type="text" class="form-control" id="username" name="username" style="text-align: center; border-radius: 0px;"-->
<!--                                       value="--><?php
//                                       if (isset($_SESSION["loginerrorusername"]))
//                                       {
//                                           echo $_SESSION["loginerrorusername"];
//                                           unset($_SESSION["loginerrorusername"]);
//                                       }
//                                       ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-12">-->
<!--                                <input type="password" name="password" class="form-control" id="password" style="text-align: center; border-radius: 0px;">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-12" style="text-align: center;">-->
<!--                                <button type="submit" class="btn btn-default" style="border-radius: 0px">Login</button>-->
<!--                                <button type="submit" class="btn btn-default" style="border-radius: 0px">Register</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
<!---->
<!--                    <div class="col-sm-12" style="text-align: center;padding-top: 20px;line-height: 30px;">-->
<!--                        <p>Haven't got an account yet? Create one <a href="signup.php">here</a></p>-->
<!--                        <p>Forgotten your password? Reset it <a href="forgottenpassword.php">here</a></p>-->
<!--                        <p>Forgotten your username? Request a reminder <a href="forgottenusername.php">here</a></p>-->
<!--                    </div>-->

                    <?php include_once "loginform.php" ?>

                </div>

            </div>

        </div>

    </body>

</html>