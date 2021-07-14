<?php
  /**
   * include the script to connect to the database
   */
  include_once('db_connection.php');

  // get all posted data, probably JSON
  $body = file_get_contents("php://input");

  // Decode the JSON object
  // $object = json_decode($body, true);
  
  // Display the object
  // print_r($body);

  // prepare the statement
  $sqlStatement = $connection->prepare("INSERT INTO notifications (data) VALUES (?)");
  
  // bind, parameter "s" tells the script that the data is a string
  $sqlStatement->bind_param("s", $body);
  
  // execute
  $sqlStatement->execute();
?>