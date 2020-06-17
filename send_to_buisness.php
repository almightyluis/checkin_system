<?php

//include_once 'updated_php_project/server_connect.php';
//include("server_connect.php");
include_once 'server_connect.php';
date_default_timezone_set("America/Los_Angeles");
$static_var = "1359780799";
$current_time = date("H:i:s");
echo $current_time;
// For the Var $connection

if ( !isset($_POST['client-name']) || !isset($_POST['clicked']) ){
	echo "Error Post fail";
	exit();
} 

$client_name = $_POST['client-name'];
$client_email = $_POST['client-email'];
$client_phone = $_POST['client-phone'];
$client_guest = $_POST['client-guest'];
$check_in = 0;

  if ( empty($client_name) || empty($client_email) || empty($client_phone) || empty($client_guest) ) {
    echo "Error Values Are Empty";
    exit();
  } else {

	  	$sqlStr = "INSERT INTO client_information(`id`,`Time`,`Status`,`Name`, `Email`, `Phone`, `Guest`) VALUES ( NULL,'$current_time','$check_in','$client_name','$client_email','$client_phone','$client_guest'); ";

		if ($sqlResult = mysqli_query($connection, $sqlStr)) {
			session_start();
			echo "Recorded Successfully";
			header("Location: app_made_confirmation.php");
			$_SESSION['client-name'] = $client_name;
			$_SESSION['number-guest'] = mysqli_num_rows($sqlResult);
			mysqli_close($connection);
			exit();
		}else if(!$sqlResult) {
	    // Send user back home display message to try again.
			echo "Error DB inserting ";
			mysqli_error($connection);
			mysqli_close($connection);
			exit();
		}
  }






	
	



	
