<?php


include('server_connect.php');


if(!isset($_POST['client_reload'])){
	header("Location: error_restricted.html");
	exit();
}

$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
$result = mysqli_query($connection , $stmt);

if(!$result){
	echo 'Fatal Error, Refresh current table';
}
$output = '';  
$output .= '<table class="table table-hover">
	  <thead class="thead-light">
	    <tr>
	      <th scope="col">Order</th>
	      <th scope="col">Name</th>
	      <th scope="col">Guest Count</th>
	      <th scope="col">Status</th>
	    </tr>
	  </thead>
	  <tbody>';

	$itter = 1;
	if( mysqli_num_rows($result) > 0){
		while( $row = mysqli_fetch_assoc($result) ) {
			$status = htmlentities($row['Status']);
			if($status == 1){
				$current_status = "Checked in";
			}else if($status == 0){
				$current_status = "Not Checked in";
			}else {
				$error = "Major Error";
				break;
			}
			$output .= ' <tr>
			<td><h4>'.htmlentities($itter++).'</h4></td>
			<td><h4>'.htmlentities($row['Name']).'</h4></td>
			<td><h4>'.htmlentities($row['Guest']).'</h4></td>
			<td><h4><p class="text-success"> <h4>'.$current_status.'</p></h4></td>
			</tr>';

		}
	} else {
		$output .= '
		<tr>
		<td>Empty list</td>
		</tr></tbody></table>
		';

	}
	$output .= '</tbody></table>';
	
	echo $output;



