<?php
 error_reporting(0);
 define('DBHOST', "localhost");
 define('DBUSER', "idfuucom_admin");
 define('DBPASS', "fid123!!");
 define('DBNAME', "idfuucom_wr");
 
 $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME); 
 if ( !$conn ) {
  die("Database failed to connecting");
 }
?>