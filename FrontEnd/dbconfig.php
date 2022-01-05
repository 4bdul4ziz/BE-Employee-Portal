<?php

  define('DB_SERVER','localhost');
  define('DB_USERNAME','root');
  define('DB_PASSWORD','');
  define('DB_NAME','system');

  $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
  //check connection
  if (mysqli_connect_errno()){
      echo "failed to connect" . mysqli_connect_errno();
  }
  
?>