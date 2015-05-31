<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 30/05/2015
 * Time: 16:51
 */

include_once 'header.php';

$domains = $db->getKeyedDomains($_SESSION["token"]);
?>


<title>Generate Password</title>
</head>
<body>

<form action="action_generate.php" method="post">
    <select name="domain">
        <?php foreach($domains as $domain): ?>
            <option value="<?php echo $domain; ?>"><?php echo $domain; ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Password:
    <input type="password" name="password" autocomplete="off">
    <br>
    <input type="submit" name="submit">
</form>


