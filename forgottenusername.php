<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 15:56
 */
include_once 'header.php';

?>
<title>Forgotten Password</title>
</head>
<body>

<div class="container mainbody">
    <p style="text-align: center; font-weight: 100;">Please enter your email address: </p>
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action_forgotusername.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: center; padding-top: 20px;">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>