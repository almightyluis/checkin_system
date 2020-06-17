<?php


include_once 'server_connect.php';

$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
$result = mysqli_query($connection , $stmt);

if(!$result){
	echo "Fatal Error, Refresh current table";
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
				<td>'.$itter++.'</td>
				<td>'.$row['Name'].'</td>
				<td>'.$row['Guest'].'</td>
				<td><p class="text-success"> '.$current_status.' </p> </td>
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


