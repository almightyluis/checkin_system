<?php

include_once 'server_connect.php';

if(!isset($_GET['client_view_click'])){
	echo 'No Click Error';
	Header("Location: error_message_login.html");
	die();
}else {

	$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
	$result = mysqli_query($connection , $stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js"></script>             
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
  	<link href="/updated_php_project/static/client_view_style.css" rel="stylesheet">
</head>

<script type="text/javascript">
// 1 min = 60000
// 3 min = 180000
// 5 min = 300000

$(document).ready(function(){
     setInterval(reload_table, 60000);
});

function reload_table() {
    var client_reload = "client_reload"; 
    $.ajax({
    type: 'POST',
    timeout: 5000,
    url: "refresh_client_table.php",
    data:{'client_reload':client_reload},
      success: function(responce){
       $("#table_id").html(responce);
       console.log("Auto Refresh success");
      }, 
      error: function(){
        $("#timeout_error").modal("show");
        console.log("Timeout error");
      }
    }); 
}	
</script>

<div class = "jumbotron">
	<h1 class="display-4" style = "color: #FFFFFF">Welcome, wait here to be checked in.</mark>.</h1>
     <?php date_default_timezone_set('America/Los_Angeles');  $current_date = date("l, M-d-Y"); echo '<h2 class = "display-6" style = "color: #FFFFFF"> '.$current_date.'</h2>';?>
</div>
<div class = main_table id ="table_id">
	<table class="table table-striped">
	  <thead class="thead-light">
	    <tr>
	      <th scope="col">Order</th>
	      <th scope="col">Name</th>
	      <th scope="col">Guest Count</th>
	      <th scope="col">Status</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	$itter = 1;
  		if( mysqli_num_rows($result) > 0){

  			while( $row = mysqli_fetch_assoc($result) ) {
	  			$name = $row['Name'];
	  			$guest = $row['Guest'];
	  			$status = $row['Status'];
	  			if($status == 1){
	  				$current_status = "Checked in.";
	  			}else if($status == 0){
	  				$current_status = "Not Checked in.";
	  			}else {
	  				$error = "Major Error";
	  				break;
	  			}
	  			echo '<tr>
  				<td> <h4>'.$itter++.' </h4></td>
  				<td> <h4>'.$row['Name'].' </h4></td>
  				<td> <h4>'.$row['Guest'].'</h4></td>
  				<td> <h4><p class="text-success">'.$current_status.'</p> </h4> </td>
  			</tr>';
  			}
  		} else {
  			echo '
  			<tr>
  			<td>Empty list</td>
  			</tr>';

  		}
	  	?>
	  </tbody>
</table>
</div>






</html>

