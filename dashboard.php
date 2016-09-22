<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

    <?php include("includes/header.php") ?>
    <link href="css/dashboard.css" rel="stylesheet">

    <title>Dashboard</title>

</head>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connect.php';
    $loggedIn = false;
    $domains = array("www.facebook.com", "google.com", "how-to-geek.com");

    if (isset($_COOKIE['token']))
    {
        $loggedIn = true;
        $domains = $db->getKeyedDomains($_COOKIE['token']);
    }
?>

<body>
<div id="main">

    <?php include_once 'includes/navbar.php' ?>

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
                for($i=0; $i < count($domains); $i++) {
                    $domain = $domains[$i];
                    $passwordId = "password" . $i;
                    ?>

                    <table style="width: 100%; text-align: center;">
                        <td style="padding: 10px;">
                            <img src="https://www.google.com/s2/favicons?domain=<?php echo $domain; ?>"/>
                        </td>
                        <td style="padding: 10px; text-align: left; width: 100%"><?php echo $domain; ?></td>
                        <td style="padding-right: 10px">
                            <span title="Regenerate salt" class="fa fa-cogs" style="color: black; "></span>
                        </td>
                        <td style="padding-right: 10px">
                            <span title="Edit domain" class="fa fa-pencil" style="color: black; "></span>
                        </td>
                        <td style="padding-right: 10px;">
                            <span title="Delete domain" class="fa fa-trash" style="color: black;"
                                  onclick="deleteDomain('<?= $domain ?>');"></span>
                        </td>
                    </table>
                    <table style="width: 100%; text-align: center;">
                        <td style="width: 100%; padding-left: 10px;"><input type="password" id="<?= $passwordId ?>" style="width: 100%;
                                  padding-left: 10px;"
                                                                            placeholder="Enter password"/></td>
                        <td style="padding: 10px" id="hel">
                            <span class="fa fa-arrow-right" style="color: black;"
                                  onclick="generatePassword($('#<?= $passwordId ?>'), '<?= $domain ?>',
                                      <?php if (isset($_COOKIE['token'])) echo $_COOKIE['token'] ?>');"></span>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Add domain</h4>
            </div>
            <form onsubmit="addDomain(<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token'] ?>)">
                <div class="modal-body">
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
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="linkdomain"
                                   class="control-label">Link Domain:</label>

                            <select name="linkdomain" class="form-control" id="domain" name="domain"
                                    style="text-align: center;">
                                <?php array_unshift($domains, ""); foreach ($domains as $domain):?>
                                    <option value="<?= $domain; ?>"><?= $domain; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteDomainModal" tabindex="-1" role="dialog" aria-labelledby="deleteDomainModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="deleteDomainModalLabel">Delete domain</h4>
            </div>
            <div class="modal-body">
                Are you sure you wish to delete the domain <span id="deleteDomainText"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=
                "confirmDeleteDomain('<?php if (isset($_COOKIE['token'])) echo $_COOKIE['token'] ?>');">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php include("includes/modals.php") ?>

<?php if (!$loggedIn) { ?>

    <div class="modal" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="logInModalLabel">Login</h4>
                </div>
                <div class="modal-body">
                    <?php include_once "forms/login.php" ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script src="js/jquery.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/login.js"></script>
<script src="js/global.js"></script>
<script src="js/dashboard.js"></script>

</body>