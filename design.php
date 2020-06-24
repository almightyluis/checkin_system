<?php

	include_once 'server_connect.php';
	$stmt = "SELECT * FROM `client_information` WHERE 1; ";

	// Reqect time out of this time frame
	$start_time = "08:00:00";
	$end_time = "21:00:00";
	// Days off according to BClient
	$day_off = array(6,7); 


	date_default_timezone_set('America/Los_Angeles');
	$current_date_client = date("N");
	$current_time_client = date("H:i");
	$hour = date("H");
	$min = date("i");

	$start_time_format = explode(":", $start_time);
	$end_time_format = explode(":", $end_time);
?>

<!-- Email and phone number should now be able to match to current DB list -->
<!-- If the email or phone match we need to promp the user that that email is already in the system -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Complete Bootstrap 4 Website Layout</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

	<!-- Here is the link to the Style.css sheet(Note the PATH TO STYLE) -->
	<link href="/updated_php_project/static/style.css" rel="stylesheet">

		<!-- The core Firebase JS SDK is always required and must be listed first -->

</head>
<body>

<!-- Navigation -->
<nav class = "navbar navbar-expand-md navbar-light bg-light sticky-top">

	<div class="container-fluid">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"> </span>
	</button>
	<div class="collapse navbar-collapse" id ="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="#">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Find Location</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">About</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Software</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Help</a>
			</li>

		</ul>
	</div>
	</div>
</nav>

<!--- Image Slider -->

<div id="slides" class="carousel slide" data-ride = "carousel">
	<ul class ="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"> </li>
		<li data-target="#slides" data-slide-to="1"> </li>
		<li data-target="#slides" data-slide-to="2"> </li>
	</ul>

<!-- Reference this class in Style.css-->
<div class="carousel-inner">
	<div class="carousel-item active">
		<img src="/updated_php_project/static/img/barbershop.jpg"/>
		<div class="carousel-caption">
		<?php
		
		function check_date() {
			global $day_off, $current_date_client;
			if(in_array($current_date_client, $day_off)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		 if( (float)$hour > (float)$start_time_format[0] && (float)$hour < (float)$end_time_format[0] && check_date() == FALSE){
		 		echo '<h1 class= "display-2">Reserve your place in line</h1>';
				echo '<button class="btn btn-outline-light btn-lg" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Make Appointment</button>';

		 }else {
				echo '
				<h2 class= "display-1" id= "closed_txt" style ="color: #d1000a;">Appointments are currently closed till open hours</h2>
				<button type="button" class ="btn btn-outline-light btn-lg" data-toggle="modal" data-target="#error_modal" data-whatever="@getbootstrap">Currently not open</button>
				';
		}

	 
		?>
		</div>
	</div>
	<div class="carousel-item">
		<img src="/updated_php_project/static/img/storefront2.jpg"/>
	</div>
	<div class="carousel-item">
		<img src="/updated_php_project/static/img/storefront.jpg"/>
	</div>
</div>
</div>

<!-- Error Modal --->
<div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Location closed</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="lead">We are currently closed </p>
        <p class="lead">Appointments are opened up 5 minutes before opening time. Please make appointment at that time!</p>
		<p>Thanks for understading.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>


<!--- Jumbotron -->

<div class="container-fluid">
<div class="row jumbotron">
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<?php 

			$multiplier = 10;
			$final = NULL;
			if ( $result = mysqli_query($connection, $stmt) ){
			$row_count = mysqli_num_rows($result);
			if($row_count <= 2){
				$final = "<10";
			} else {
				$final = $row_count * $multiplier;	
				}
			}
			mysqli_close($connection);
		
		if( (float)$hour > (float)$start_time_format[0] && (float)$hour < (float)$end_time_format[0] && check_date() == FALSE){

			echo'<h2> Current wait time is <mark>'.$final.'</mark> mins.</h2>';
			echo '<p class="lead">We have a number of hair stylist working for us. Come on by and get a haircut!</p>';
			echo '<p class = "lead">Accepting online appointments now.</p>';
		} else {

			echo'<h2> Current wait time is <mark>0</mark> mins.</h2>';
			echo '<p class="lead">We have a number of hair stylist working for us. Come on by and get a haircut!</p>';
			echo '<p class = "lead"><mark>Current location is closed</mark>, you can make appointments during open hours.</p> ';
		} 

		?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
		<a href="#">
		<?php 

			if( (float)$hour > (float)$start_time_format[0] && (float)$hour < (float)$end_time_format[0] && check_date() == FALSE){
				echo '<button type="button" class ="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Make Appointment</button>';
			} else {
				echo '<button type="button" class ="btn btn-outline-danger" data-toggle="modal" data-target="#error_modal" data-whatever="@getbootstrap">Currently not open</button>';
			}
		 ?>
		</a>
	</div>

</div>
</div>

<!---Modal Handle Appointments-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Making Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action ="send_to_buisness.php" method= "post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="client-name" name = "client-name" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="client-email" name="client-email" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Phone Number:</label>
            <input type="phone-number" class="form-control" id="client-phone" name = "client-phone" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"> Number of guest (0 if it's just yourself :) </label>
            <input type="number" class ="form-control" id="client-guest" min="0"name= "client-guest">
          </div>
          <div class="form-group">
		    <label for="carrier_id">Mobile Phone Carrier</label>
		    <select class="form-control" id="carrier-id" name="carrier-id" required="">
		      <option value="">Please select</option>
		      <option value="1">AT&T</option>
		      <option value="2">T-Mobile</option>
		      <option value="3">Verizon</option>
		      <option value="4">Metro-PCS</option>
		      <option value="5">Sprint</option>
		      <option value="6">Boost-Mobile</option>
		    </select>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<input type="submit" value= "Confirm Appointment" name = "clicked" class = "btn btn-primary">
      </div>
  </form>
    </div>
  </div>
</div>


<!---   Need to handle if values are empty  --->

<!--- This can be three items show off -->
<!-- Might need to figure out how to change the icons, they are labeled as i class "fas fa-code" etc -->
<div class="container-fluid padding">
<div class= "row text-center padding">
	<div class="col-xs-12 col-sm-6 col-md-4">
		<i class="fas fa-code"></i>
		<h3>Normal Cut</h3>
		<p>Simple hair cut no fade Etc..</p>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4">
		<i class="fas fa-code"></i>
		<h3>Salon</h3>
		<p>Hair cut with styling</p>
	</div>

	<div class="col-sm-12 col-md-4">
		<i class="fas fa-code"></i>
		<h3>Super Cut</h3>
		<p>Haircut, Shave, etc</p>
	</div>
</div>
<hr class="my-4">
</div>


<!--- This can be the types of cuts to offer -->
<div class="container-fluid padding">
<div class="row Welcome text-center">
	<div class="col-12">
		<h1 class="display-4">What we offer</h1>
	</div>
	<hr>
</div>
</div>

<!--- Containers Cards -->
<div class="container-fluid padding">
<div class="row padding">
	<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src= "/updated_php_project/static/img/woman.jpg">
			<div class="card-body">
				<h4 class="card-title">Women Hair style</h4>
				<p class="card-text">We also include women hair stylist to assist</p>
				<a href="#" class="btn btn-outline-secondary">See profile</a>
			</div>
		</div>
	</div>

<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src= "/updated_php_project/static/img/woman.jpg">
			<div class="card-body">
				<h4 class="card-title">Women Hair style</h4>
				<p class="card-text">We also include women hair stylist to assist</p>
				<a href="#" class="btn btn-outline-secondary">See profile</a>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src= "/updated_php_project/static/img/woman.jpg">
			<div class="card-body">
				<h4 class="card-title">Women Hair style</h4>
				<p class="card-text">We also include women hair stylist to assist</p>
				<a href="#" class="btn btn-outline-secondary">See profile</a>
			</div>
		</div>
	</div>

<div class="col-md-3">
	<div class="card">
		<img class="card-img-top" src= "/updated_php_project/static/img/woman.jpg">
		<div class="card-body">
			<h4 class="card-title">Women Hair style</h4>
			<p class="card-text">We also include women hair stylist to assist</p>
			<a href="#" class="btn btn-outline-secondary">See profile</a>
		</div>
	</div>
    </div>
</div>
</div>
<!--- Connect to social media icons -->


<!--- Footer, With Client information and Job Opp -->
<footer>

	<dir class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-4">
			<hr class="light">
			<h5>Store name here</h5>
			<hr class="light">
			<p>909-572-5474</p>
			<p>someemail@gmail.com</p>
			<p>1988 W something Drive</p>
			<p>Beverly Hills Ca, 92400</p>
		</div>

		<div class="col-md-4">
			<hr class="light">
			<h5>Our Hours</h5>
			<hr class="light">
			<p>Monday: 9am-6pm</p>
			<p>Tuesday: 9am-6pm</p>
			<p>Wednesday: 9am-6pm</p>
			<p>Thursday: 9am-6pm</p>
			<p>Friday: 9am-6pm</p>
			<p>Saturday: 9am-6pm</p>
			<p>Sunday: Closed</p>

		</div>


		<div class="col-md-4">

			<hr class="light">
			<h5>Software Opportunities</h5>
			<hr class="light">
			<p>otfgonzalez@gmail.com</p>
			<p>909-572-5474</p>
			</div>
		</div>
	</dir>
</footer>
</body>
</html>




