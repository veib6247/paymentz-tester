<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$raw = json_decode($json);

// $raw->selectedEndpoint will be the endpoint

$data = [
  "authentication.partnerId" => $raw->partnerId, 
  "merchant.username" => $raw->username, 
  "authentication.sKey"=> $raw->sKey
];

// call function to execure curl
echo post_auth($raw->selectedEndpoint, http_build_query($data));

function post_auth($url, $data)
{

  # initialize cURL
  $ch = curl_init();

  # setup cURL parameters
  curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_SSL_VERIFYPEER => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE
  ));

  $responseData = curl_exec($ch);


  # error handling
  if (curl_errno($ch)) {
    return curl_error($ch);
  }

  curl_close($ch);

  return $responseData;
}