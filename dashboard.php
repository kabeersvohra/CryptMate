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
                <li id="overviewli" class="active"><a id="overview">Overview</a></li>
                <li id="newdomainli"><a id="newdomain">New Domain</a></li>
                <li id="newpasswordli"><a id="newpassword">New Password</a></li>
                <li id="genpasswordli"><a id="genpassword">Generate Password</a></li>
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

</body>

<script>
    $(document).ready(function(){
        $("#overview").click(function () {
            $("#newdomainli").removeClass('active');
            $("#newpasswordli").removeClass('active');
            $("#genpasswordli").removeClass('active');
            $("#overviewli").addClass('active');
        })
        $("#newdomain").click(function(){
            $("#main").load('/safecrypt/newdomain.php');
            $("#overviewli").removeClass('active');
            $("#newpasswordli").removeClass('active');
            $("#genpasswordli").removeClass('active');
            $("#newdomainli").addClass('active');
        });
        $("#newpassword").click(function(){
            $("#main").load('/safecrypt/newdomain.php');
            $("#overviewli").removeClass('active');
            $("#newdomainli").removeClass('active');
            $("#genpasswordli").removeClass('active');
            $("#newpasswordli").addClass('active');
        });
        $("#genpassword").click(function(){
            $("#main").load('/safecrypt/generatepassword.php');
            $("#overviewli").removeClass('active');
            $("#newpasswordli").removeClass('active');
            $("#newdomainli").removeClass('active');
            $("#genpasswordli").addClass('active');
        });
    });
</script>