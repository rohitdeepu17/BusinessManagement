<?php
//connect to database : required for non-Admin login
$username = "root";
$password = "abc";
$hostname = "localhost"; 

//connection to the database
$conn = mysqli_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";

//selecting database
$dbname = "Business";    
$selected = mysqli_select_db($conn, $dbname) 
 or die("Could not select database");
//echo "Selected database";
?>