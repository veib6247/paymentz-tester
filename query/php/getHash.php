<?php
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$raw = json_decode($json);

// hash into md5 and return the string
echo md5($raw->data);