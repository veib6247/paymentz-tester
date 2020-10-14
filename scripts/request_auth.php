<?php
#
echo post_auth($_POST['url'], $_POST['data']);

/**
 * call cURL function
 */
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
