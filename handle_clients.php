<?php

include_once 'server_connect.php';


// Removal based on id.
if(isset($_POST['del_id'])){
	$id = $_POST['del_id'];
	$delete = "DELETE FROM `client_information` WHERE id = '$id'; ";
	if ($result = mysqli_query($connection, $delete) ) {
		echo "YES";
		die();
	}else{
		echo "Error Delete";
		mysqli_error($connection);
		die();
	}

}

// Add client Check in
if(isset($_POST['check_in'])){
	$id = $_POST['check_in'];
	$cc_ee = 1;
	$update = "UPDATE `client_information` SET Status = '$cc_ee' WHERE id = '$id'; ";
	
	if ($result = mysqli_query($connection, $update) ) {
		echo "Success";
		die();
	}else{
		echo "Update Error";
		mysqli_error($connection);
		mysqli_close($connection);
		die();
	}
}

// Checks if Database contains Dates other than the current date.
// DB clean up.
if(isset($_POST['db_check'])){
	date_default_timezone_set("America/Los_Angeles");
  	$current_date = date("o-m-d");
  	$error_val = (array)null; 
  	$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
	if ($result = mysqli_query($connection , $stmt) ){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['id'];
				$date = $row['Date'];
				if( empty($id) || empty($date) ){
					echo 'id or date Null';
					exit();
				}
				if($current_date === $date){
					continue;
				}else{
					array_push($error_val, $id);
					continue;
				} 
			}
		}else{
			echo 'Error: Rows less than 0';
			exit(0);
		}

	}else{
		echo 'Error: DB ';
		exit(0);
	}

	// Check size of array to delete rows.
	if(sizeof($error_val) > 0){
		$delStm = "DELETE FROM `client_information` WHERE id IN (";
		for ($i = 0; $i < sizeof($error_val); $i++){
			$delStm .= $error_val[$i];
			if($i == sizeof($error_val) - 1){
				$delStm .= ");";
			}else{
				$delStm .= ",";
			}
		}
	if($del_result = mysqli_query($connection,$delStm)){
		echo 'Success';
		exit();
	}else{
		echo 'Error: query';
		exit();
	}
	}else{
		echo 'Success: No Changes';
		exit(0);
	}

}

/* 
T-Moblie == 2
Verizon == 3
Metro-PCS == 4
Sprint == 5
Boost-mobile == 6
*/ 
if(isset($_POST['cc_id'])){

	$cc_id = $_POST['cc_id'];
	$find_stm = "SELECT * FROM `client_information` WHERE id = '$cc_id'; ";
	$array_carrier = array(
		2 => '@tmomail.net',
		3 => '@vtext.com',
		4 => '@mymetropcs.com',
		5 => '@messaging.sprintpcs.com',
		6 => '@sms.myboostmobile.com',
		7 => 'number@msg.fi.google.com',
		8 => '@sms.cricketwireless.net',
		9 => '@vmobl.com',
		10 => '',
	);

	if($result = mysqli_query($connection,$find_stm)){
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_assoc($result);
			$email = $row['Email'];
			$name = $row['Name'];
			$phone = $row['Phone'];
			$carrier = $row['Carrier'];
			$send_sms = $phone.$array_carrier[$carrier];
			send_email_phone($email,$name,$send_sms);

		}else {
			echo 'Error: Email is empty';
			exit();
		}
	}else {
		echo 'Not found';
		
		exit();
	}
} 

function send_email_phone($address, $name, $carrier_em) {
	$body = 'Hello! Looks like you are next in line. Please make your way to our shop! Please act fast dont loose your place in line!';
	$subject = "You Are Next In Line!";

	
	$sms_body = 'Hello! Looks like you are next in line. Please make your way to our shop!.Please act fast dont loose your place in line!';
	

	// Keep a different Email per guest
	$headers = 'From: store_name_1@checkinservice.net' . "\r\n" .
    'Reply-To: NOREPLY' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $sms_header = 
    'From: store_name_1@checkinservice.net' . "\r\n" .
    'Reply-To: NOREPLY' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $mail_st = mail($address, $subject, $body, $headers);
    $sms = mail($carrier_em, $subject, $sms_body, $sms_header);

    if($mail_st || $sms){
    	echo 'Success: SMS & Email';
    	exit();
    }else if($mail_st){
    	echo 'Success: Email';
    	exit();
    }
    else if($sms){
    	echo 'Success: SMS';
    	exit();
    }
    else {
    	echo 'Error: Email & SMS';
    	die();
    }

}




header("Location: error_restricted.html");
echo 'Error fatal';
die();
