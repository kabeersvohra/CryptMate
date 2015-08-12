<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 01/06/2015
 * Time: 16:24
 */

include_once 'database.php';

$status = true;
$db = new Database("localhost",
    "XAbGnfREj3YGbl9U",
    "jxki3u6ugPlyoS1YhqRQk6UNQwBVXfcIc1A6H6w16NpHYf8rIgZP0nkPr8FvDAiL",
    "cryptmate");

$status = $db->connect();
