<?php

//include_once 'updated_php_project/server_connect.php';
//include("server_connect.php");
include_once 'server_connect.php';
date_default_timezone_set("America/Los_Angeles");
$static_var = "1359780799";
$current_time = date("H:i:s");
$current_date = date("o-m-d");


// For the Var $connection

if ( isset($_POST['client-name']) || isset($_POST['clicked']) ){

	$client_name = $_POST['client-name'];
	$client_email = $_POST['client-email'];
	$client_phone = $_POST['client-phone'];
	$client_guest = $_POST['client-guest'];
	$client_carrier = $_POST['carrier-id'];

	$check_in = 0;

  if ( empty($client_name) || empty($client_email) || empty($client_phone) || empty($client_carrier) || empty($current_date) || empty($current_time) ){
    echo "Error Values Are Empty";
    exit();
  } else {
  	$sqlStr = "INSERT INTO client_information(`id`,`Carrier`,`Time`,`Date`,`Status`,`Name`,`Email`,`Phone`,`Guest`) VALUES (NULL,'$client_carrier','$current_time','$current_date','$check_in','$client_name','$client_email','$client_phone','$client_guest'); ";

	if ($sqlResult = mysqli_query($connection, $sqlStr)) {
		session_start();
		header("Location: app_made_confirmation.php");
		$_SESSION['client-name'] = $client_name;
		$_SESSION['number-guest'] = mysqli_num_rows($sqlResult);
		mysqli_close($connection);
		exit();
	}else if(!$sqlResult) {
    // Send user back home display message to try again.
		header("Location: existing_client_error.html");
		mysqli_error($connection);
		mysqli_close($connection);
		exit();
	}
  }
}


if(isset($_POST['ee_mm_mail'])){
	$ee_mm = $_POST['ee_mm_mail'];
	$found_id = 0;
	$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
	if ($result = mysqli_query($connection , $stmt) ){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['id'];
				$email = $row['Email'];
				if($ee_mm === $email){
				 	$found_id = $id;
				 	break;
				}else{
					continue;
				} 
			}
		}
	}

	
	$rem = "DELETE FROM `client_information` WHERE id = '$found_id'; ";
	if($res = mysqli_query($connection, $rem)){
		echo 'Success';
		exit();
	}else{
		echo 'Error: DNE';
		exit();
	}
	
	
}



header("Location: error_restricted.html");
exit();








	
	



	
