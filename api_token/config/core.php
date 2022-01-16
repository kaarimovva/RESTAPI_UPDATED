<?php

// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set('Europe/Paris');
 
// variables used for jwt
$key = "test";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 h
$issuer = "http://localhost/api_token"



?>