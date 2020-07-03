<?php 

include_once 'server_connect.php';
$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
$result = mysqli_query($connection , $stmt);


if(!isset($_POST['value'])){
	header("Location: error_restricted.html");
	exit();
}

if(!$result){
	echo "Fatal Error, Refresh current table";
}


function return_list(){
global $stmt;
global $result;
$output = '';  
$output .= '<table class="table table-hover">
	  <thead class="thead-light">
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Name</th>
	      <th scope="col">Phone Number</th>
	      <th scope="col">Guest Count</th>
	      <th scope="col">Email</th>
	      <th scope="col">Status</th>
	      <th scope="col">*</th>
	    </tr>
	  </thead>
	  <tbody>';
	$itter = 1;
	if( mysqli_num_rows($result) > 0){
		while( $row = mysqli_fetch_assoc($result) ) {
			$name = $row['Name'];
			$phone = $row['Phone'];
			$guest = $row['Guest'];
			$status = $row['Status'];
			if($status == 1){
				$current_status = "Checked in";
			}else if($status == 0){
				$current_status = "Not Checked in";
			}else {
				$error = "Major Error";
				break;
			}
			$output .= ' <tr>
			<td>'.htmlentities($itter++).'</td>
			<td>'.htmlentities($row['Name']).'</td>
			<td>'.htmlentities($row['Phone']).'</td>
			<td>'.htmlentities($row['Guest']).'</td>
			<td>'.htmlentities($row['Email']).'</td>
			<td><p class="text-success"> '.htmlentities($current_status).' </p> </td>
			<td>
			<input type = "submit" class = "check btn btn-success btn-sm" id ='.$row['id'].' name = "check" value = "Check-in">
			<input type = "submit" value ="Send Email" name = "email_send" id = '.$row['id'].' class = "email_send btn btn-info btn-sm">
			<input type="submit" value="Remove" name ="remove" id ='.$row['id'].' class ="remove btn btn-danger btn-sm">
			</td>
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
	return $output;
}



echo return_list();
