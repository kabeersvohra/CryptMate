<?php
$tokenSet = isset($_COOKIE['token']);
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';
?>
<nav class="navbar navbar-fixed-top navbar-light bg-faded topnav" role="navigation" style="padding: 0;">
    <div class="container topnav">
        <a class="navbar-brand" style="padding: 10px;" href="/"><div id="img" style="height: 30px;"></div></a>
        <ul class="nav navbar-nav navbar-right" style="padding: 10px; ">
            <li><a class="nav-item nav-link" style="padding-right: 10px;"
                    <?php if (!$tokenSet) { ?> href="login.php" <?php } ?>>
                    <?php if($tokenSet) echo $db->getLoggedInUser($_COOKIE['token']); else echo "Login"; ?>
                </a></li>
            <?php if($tokenSet) { ?>
                <li class="nav-item btn-group">
                    <a class="dropdown-toggle nav-link" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-gear"></span> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" style="right: 0; left: auto;">
                        <a class="dropdown-item" href="dashboard.php"
                           title="Dashboard">Dashboard</a>
                        <a class="dropdown-item" href="subscription.php"
                           title="Manage subscription">Manage Subscription</a>
                        <a class="dropdown-item" href="password.php"
                           title="Manage account">Change Password</a>
                        <a class="dropdown-item" href="email.php"
                           title="Manage account">Change Email</a>
                        <a class="dropdown-item" href="#deleteAccountModal"
                           data-toggle="modal" title="Delete domain">Delete Account</a>
                        <a class="dropdown-item" href="logout.php"
                           title="Logout">Logout</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>