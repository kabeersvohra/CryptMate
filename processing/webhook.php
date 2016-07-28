<?php

if (!isset($_SESSION)) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/database/connectdatabase.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/processing/config.php';

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

// Do something with $event_json

http_response_code(200);