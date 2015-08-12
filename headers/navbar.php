<link href="css/navbar.css" rel="stylesheet">

<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <a class="navbar-brand" style="padding: 10px;" href="/"><img src="img/logo-small.png" style="height: 30px;"></a>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (isset($_SESSION["token"]))
                        $user = $db->getLoggedinUser($_SESSION["token"]);
                    else
                        $user = false;

                    if($user == false) :
                    ?>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a style="color: #777">Logged in as <?= $user; ?> </a>
                    </li>
                    <li>
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.container -->
    </nav>