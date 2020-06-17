<?php

$db_servername = "localhost";
$db_username = "root"; // because using XAMPP
$db_password = "";
$db_name = "client_database_2020";


$connection = mysqli_connect($db_servername, $db_username, $db_password, $db_name);

 if(!$connection) {
 	// Hanlde Errors via User Interface
 	die("Connection failed: " . mysqli_connect_error());
 }







    // Error was most likely tthe  closing "php >"
