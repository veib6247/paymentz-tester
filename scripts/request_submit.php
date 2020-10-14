<?php

/**
 * call function to execute cURL
 */
echo post($_POST['url'], $_POST['data'], $_POST['token']);

function post($url, $data, $token)
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
