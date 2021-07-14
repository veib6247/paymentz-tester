<?php
  /**
   * creates connection to the database
   */


  // database variables by order of usage in mysqli_connect
  


  // create the connection
  $connection = mysqli_connect(
    $databaseServerName,
    $databaseUser, 
    $databasePassword,
    $databaseName 
  );


  


?>