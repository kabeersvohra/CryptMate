<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 31/05/2015
 * Time: 12:23
 */

include_once 'header.php';

?>
    <title>Forgotten Password</title>
</head>
<body>

<div class="container mainbody">
    <p style="text-align: center; font-weight: 100;">Please enter your email address and username:</p>
    <div class="col-sm-6 col-sm-offset-3">
        <form class="form-horizontal" role="form" id="form" method="post" action="action_forgotten.php">
            <div class="form-group">
                <label class="control-label col-sm-12" for="username" style="text-align: center; padding-bottom: 10px;">Username</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="username" name="username" style="text-align: center;">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-12" for="email" style="text-align: center; padding-top: 30px; padding-bottom: 10px;">Email</label>
                <div class="col-sm-12">
                    <input type="email" name="email" class="form-control" id="email" name="email" style="text-align: center;">
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