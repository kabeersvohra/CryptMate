<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 10/07/2015
 * Time: 17:54
 */

include_once 'header.php';

?>
<title>Dashboard</title>

<link href="css/dashboard.css" rel="stylesheet">

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li id="overviewli" class="active"><a href="#overview" id="overview">Overview</a></li>
                <li id="newdomainli"><a href="#newdomain" id="newdomain">New Domain</a></li>
                <li id="genpasswordli"><a href="#generatepassword" id="generatepassword">Generate Password</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main">
                 <h1 class="page-header" style="text-align: center">Dashboard</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <div class="row" style="text-align: center">
                        <img src="/safecrypt/img/domain.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Domains">
                    </div>
                    <h4>0</h4>
                    <span class="text-muted">Number of Domains</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <div class="row" style="text-align: center">
                        <img src="/safecrypt/img/password.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Passwords">
                    </div>
                    <h4>0</h4>
                    <span class="text-muted">Number of Passwords</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function overviewClick() {
        $("#main").load('/SafeCrypt/overview.php');
        $("#newdomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#overviewli").addClass('active');
    }

    function newDomainClick() {
        $("#main").load('/SafeCrypt/newdomain.php');
        $("#overviewli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#newdomainli").addClass('active');
    }

    function generatePasswordClick() {
        $("#main").load('/SafeCrypt/generatepassword.php');
        $("#overviewli").removeClass('active');
        $("#newdomainli").removeClass('active');
        $("#genpasswordli").addClass('active');
    }

    $(window).bind("load", function() {
        if(window.location.hash)
        {
            var hash = window.location.hash.substring(1);
            switch (hash) {
                case "overview":
                    overviewClick();
                    break;
                case "newdomain":
                    newDomainClick();
                    break;
                case "generatepassword":
                    generatePasswordClick();
                    break;
                default:
                    break;
            }
        }

        $("#overview").click(overviewClick);
        $("#newdomain").click(newDomainClick);
        $("#generatepassword").click(generatePasswordClick);

    });
</script>

</body>