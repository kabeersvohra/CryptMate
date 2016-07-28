<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$stripe = array(
    "secret_key"      => "sk_test_EkPprfLAO4bpSQI7KH2cAZqe",
    "publishable_key" => "pk_test_iMSLKp40qU6IPtvS1mLtQEli"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>