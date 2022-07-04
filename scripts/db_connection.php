<?php
  /**
   * creates connection to the database
   */


  // database variables by order of usage in mysqli_connect
  $databaseServerName = "localhost";  
  $databaseUser = "fukazer0";
  $databasePassword = "Hc&EBCJjMc6z7zfq";
  $databaseName = "TheHolyGrail";


  // create the connection
  $connection = mysqli_connect(
    $databaseServerName,
    $databaseUser, 
    $databasePassword,
    $databaseName 
  );


  


?>