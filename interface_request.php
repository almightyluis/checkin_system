<?php


include('server_connect.php');
// Hello added for commit
// Hello added again for commit

date_default_timezone_set("America/Los_Angeles");
$current_time = date("H:i:s");
$current_date = date("o-m-d");

if ( !isset($_POST['client-name']) || !isset($_POST['clicked']) ){
	echo "Error Post fail";
	exit();
} 
$client_name = $_POST['client-name'];
$client_email = $_POST['client-email'];
$client_phone = $_POST['client-phone'];
$client_guest = $_POST['client-guest'];
$client_carrier = $_POST['carrier-id'];

$check_in = 0;

  if ( empty($client_name) || empty($client_email) || empty($client_phone) || empty($current_date) || empty($current_time) ) {
    echo "Error Values Are Empty";
    exit();
  } else {

	  	$sqlStr = "INSERT INTO client_information(`id`,`Carrier`,`Time`,`Date`,`Status`,`Name`,`Email`,`Phone`,`Guest`) VALUES (NULL,'$client_carrier','$current_time','$current_date','$check_in','$client_name','$client_email','$client_phone','$client_guest'); ";
	  	$sqlResult = mysqli_query($connection, $sqlStr);

		if ($sqlResult) {
			session_start();
			header("Location: user_interface_main.php");
			mysqli_close($connection);
		}else{

      if( check_repeating($client_email) ){
        header("Location: user_interface_main.php?email_match=true");  
        exit();
      }
			echo "Error DB inserting Value";
			echo mysqli_error($connection);
			mysqli_close($connection);
			exit();
			}
		}

  // Check if repeating email has occured
  // Returns a Boolean
  // True -> If repeating False otherwise
  function check_repeating($email){
    global $connection;
  	$check_stm = "SELECT * FROM `client_information` WHERE Email = '$email';";
    $result = mysqli_query($connection, $check_stm);
    if($result){
      $row = mysqli_fetch_assoc($result);
      echo $row['Email'];
      return true;
    }else {
      return false;
    }
}


