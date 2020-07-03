<?php

// or require
include_once 'server_connect.php';

// SELECT * FROM `user_login_permissions`
// Table : user_login_permissions
// col : 1. id 2. user_email 3.user_password

if( isset($_POST['click']) ) {
	$username = $_POST['login'];
	$password = $_POST['password'];
	if(empty($username) || empty($password) ){
		header("Location: error_message_login.html");
		exit();
	} else {
		$sql = "SELECT * FROM user_login_permissions WHERE user_email=?;";
		$stmt = mysqli_stmt_init($connection);
		if( !mysqli_stmt_prepare($stmt, $sql) )
		{
			header("Location: error_message_login.html");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_assoc($result);
			if( mysqli_num_rows($result) > 0) {
				if( $row['user_email'] == $username && $row['user_password'] == $password ) {
					session_start();
					header("Location: user_interface_main.php");
					$_SESSION['time_frame'] =$row['time_frame'];
					$_SESSION['day_off'] = $row['day_off'];
					$_SESSION['user-login-success'] = $username;
					exit();
				
				} else {
				header("Location: error_message_login.html");
				exit();
				}

			} else {
				header("Location: error_message_login.html");
				exit();
			}
			// placing into Assosiative array
		}
	}

} else {
	header("Location: error_restricted.html");
	exit();
}















