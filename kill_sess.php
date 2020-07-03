<?php

if(isset($_SESSION['client-name'])){
	if (session_destroy()){
		$_SESSION=array();
		unset($_SESSION);
		echo 'Session: Destroyed';
		exit();
	}else{
		echo 'Session: Not Destroyed';
		exit();
	}

}
header("Location: error_restricted.html");
exit();

