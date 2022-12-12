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
                <li id="createdomainli"><a href="#createdomain" id="createdomain">Create Domain</a></li>
                <li id="deletedomainli"><a href="#deletedomain" id="deletedomain">Delete Domain</a></li>
                <li id="genpasswordli"><a href="#generatepassword" id="generatepassword">Generate Password</a></li>
                <li id="editaccountli"><a href="#editaccount" id="editaccount">Edit Account</a></li>
                <li id="deleteaccountli"><a href="#deleteaccount" id="deleteaccount">Delete Account</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main">
                 <h1 class="page-header" style="text-align: center">Dashboard</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <div class="row" style="text-align: center">
                        <img src="/SafeCrypt/img/domain.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Domains">
                    </div>
                    <h4>0</h4>
                    <span class="text-muted">Number of Domains</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <div class="row" style="text-align: center">
                        <img src="/SafeCrypt/img/password.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Passwords">
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
        $("#main").load('/SafeCrypt/dashboard/overview.php');
        $("#createdomainli").removeClass('active');
        $("#deletedomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#deleteaccountli").removeClass('active');
        $("#editaccountli").removeClass('active');
        $("#overviewli").addClass('active');
    }

    function createDomainClick() {
        $("#main").load('/SafeCrypt/dashboard/createdomain.php');
        $("#overviewli").removeClass('active');
        $("#deletedomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#deleteaccountli").removeClass('active');
        $("#editaccountli").removeClass('active');
        $("#createdomainli").addClass('active');
    }

    function deleteDomainClick() {
        $("#main").load('/SafeCrypt/dashboard/deletedomain.php');
        $("#overviewli").removeClass('active');
        $("#createdomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#deleteaccountli").removeClass('active');
        $("#editaccountli").removeClass('active');
        $("#deletedomainli").addClass('active');
    }

    function generatePasswordClick() {
        $("#main").load('/SafeCrypt/dashboard/generatepassword.php');
        $("#overviewli").removeClass('active');
        $("#createdomainli").removeClass('active');
        $("#deletedomainli").removeClass('active');
        $("#deleteaccountli").removeClass('active');
        $("#editaccountli").removeClass('active');
        $("#genpasswordli").addClass('active');
    }

    function editAccountClick() {
        $("#main").load('/SafeCrypt/dashboard/editaccount.php');
        $("#overviewli").removeClass('active');
        $("#createdomainli").removeClass('active');
        $("#deletedomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#deleteaccountli").removeClass('active');
        $("#editaccountli").addClass('active');
    }

    function deleteAccountClick() {
        $("#main").load('/SafeCrypt/dashboard/deleteaccount.php');
        $("#overviewli").removeClass('active');
        $("#createdomainli").removeClass('active');
        $("#deletedomainli").removeClass('active');
        $("#genpasswordli").removeClass('active');
        $("#editaccountli").removeClass('active');
        $("#deleteaccountli").addClass('active');
    }

    $(window).bind("load", function() {
        if(window.location.hash)
        {
            var hash = window.location.hash.substring(1);
            switch (hash) {
                case "overview":
                    overviewClick();
                    break;
                case "createdomain":
                    createDomainClick();
                    break;
                case "deletedomain":
                    deleteDomainClick();
                    break;
                case "generatepassword":
                    generatePasswordClick();
                    break;
                case "editaccount":
                    editAccountClick();
                    break;
                case "deleteaccount":
                    deleteAccountClick();
                    break;
                default:
                    break;
            }
        }

        $("#overview").click(overviewClick);
        $("#createdomain").click(createDomainClick);
        $("#deletedomain").click(deleteDomainClick);
        $("#generatepassword").click(generatePasswordClick);
        $("#deleteaccount").click(deleteAccountClick);
        $("#editaccount").click(editAccountClick);

    });
</script>

</body>