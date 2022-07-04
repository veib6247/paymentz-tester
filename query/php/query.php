<?php

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$raw = json_decode($json);

// build the array
$data = [
  "authentication.memberId" => $raw->memberId,
  "pagination.fromdate" => $raw->fromDate,
  "pagination.todate" => $raw->toDate,
  "status" => $raw->status,
  "authentication.checksum" => $raw->checksum
];
// call function to execure curl
echo post_query($raw->endpoint, $raw->token, http_build_query($data));


function post_query($url, $token, $data)
{
  # initialize cURL
  $ch = curl_init();
  # setup cURL parameters
  curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_SSL_VERIFYPEER => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array('AuthToken: ' . $token)
  ));

  $responseData = curl_exec($ch);
  # error handling
  if (curl_errno($ch)) {
    return curl_error($ch);
  }

  curl_close($ch);

  return $responseData;
}