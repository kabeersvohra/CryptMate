<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 10/07/2015
 * Time: 17:54
 */

include_once $_SERVER['DOCUMENT_ROOT'] . 'headers/header.php';

?>
<title>Dashboard</title>

<link href="css/dashboard.css" rel="stylesheet">

</head>

<body>

<div class="container-fluid">

        <?php
            if($db->getSubscriptionEnded($_SESSION["token"]))
            {
                echo "<div class='row' style='padding-top: 20px;'>";
                include_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard/managesubscription.php';
            }
            else
            {
        ?>

        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li id="overviewli" class="active"><a href="#overview" id="overview">Overview</a></li>
                    <li id="createdomainli"><a href="#createdomain" id="createdomain">Create Domain</a></li>
                    <li id="deletedomainli"><a href="#deletedomain" id="deletedomain">Delete Domain</a></li>
                    <li id="genpasswordli"><a href="#generatepassword" id="generatepassword">Generate Password</a></li>
                    <li id="managesubscriptionli"><a href="#managesubscription" id="managesubscription">Manage Subscription</a></li>
                    <li id="changeemailli"><a href="#changeemail" id="changeemail">Change Email</a></li>
                    <li id="changepasswordli"><a href="#changepassword" id="changepassword">Change Password</a></li>
                    <li id="deleteaccountli"><a href="#deleteaccount" id="deleteaccount">Delete Account</a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main">
                     <h1 class="page-header" style="text-align: center">Dashboard</h1>

                <div class="row placeholders">
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <div class="row" style="text-align: center">
                            <img src="img/domain.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Domains">
                        </div>
                        <h4>0</h4>
                        <span class="text-muted">Number of Domains</span>
                    </div>
                    <div class="col-xs-6 col-sm-3 placeholder">
                        <div class="row" style="text-align: center">
                            <img src="img/password.png" class="img-responsive col-xs-8 col-xs-offset-2" alt="Passwords">
                        </div>
                        <h4>0</h4>
                        <span class="text-muted">Number of Passwords</span>
                    </div>
                </div>
            </div>

            <script>

                function overviewClick() {
                    $("#main").load('dashboard/overview.php');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#overviewli").addClass('active');
                }

                function createDomainClick() {
                    $("#main").load('dashboard/createdomain.php');
                    $("#overviewli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#createdomainli").addClass('active');
                }

                function deleteDomainClick() {
                    $("#main").load('dashboard/deletedomain.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#deletedomainli").addClass('active');
                }

                function generatePasswordClick() {
                    $("#main").load('dashboard/generatepassword.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#genpasswordli").addClass('active');
                }

                function changeEmailClick() {
                    $("#main").load('dashboard/changeemail.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#changeemailli").addClass('active');
                }

                function deleteAccountClick() {
                    $("#main").load('dashboard/deleteaccount.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#deleteaccountli").addClass('active');
                }

                function manageSubscriptionClick() {
                    $("#main").load('dashboard/managesubscription.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#changepasswordli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#managesubscriptionli").addClass('active');
                }

                function changePasswordClick() {
                    $("#main").load('dashboard/changepassword.php');
                    $("#overviewli").removeClass('active');
                    $("#createdomainli").removeClass('active');
                    $("#deletedomainli").removeClass('active');
                    $("#genpasswordli").removeClass('active');
                    $("#managesubscriptionli").removeClass('active');
                    $("#changeemailli").removeClass('active');
                    $("#deleteaccountli").removeClass('active');
                    $("#changepasswordli").addClass('active');
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
                            case "changepassword":
                                changePasswordClick();
                                break;
                            case "changeemail":
                                changeEmailClick();
                                break;
                            case "deleteaccount":
                                deleteAccountClick();
                                break;
                            case "managesubscription":
                                manageSubscriptionClick();
                                break;
                            default:
                                break;
                        }
                    }

                    $("#overview").click(overviewClick);
                    $("#createdomain").click(createDomainClick);
                    $("#deletedomain").click(deleteDomainClick);
                    $("#generatepassword").click(generatePasswordClick);
                    $("#managesubscription").click(manageSubscriptionClick);
                    $("#deleteaccount").click(deleteAccountClick);
                    $("#changeemail").click(changeEmailClick);
                    $("#changepassword").click(changePasswordClick);

                });
            </script>
        <?php } ?>
    </div>
</div>

</body>