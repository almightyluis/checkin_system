<?php
	include_once 'server_connect.php';
	
	// Using OOP We might be able to fix this
	// We can use strtotime() to be able to compare times
	// This can fix the start time aand end time 
	date_default_timezone_set('America/Los_Angeles');
	// Reqect time out of this time frame
	$start_time = "08:00:00";
	$end_time = "24:00:00";
	$current_time= date("G:i");
	// Days off according to BClient
	$day_off = array(5,6); 	

?>

<!-- Email and phone number should now be able to match to current DB list -->
<!-- If the email or phone match we need to promp the user that that email is already in the system -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Company Name</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js"></script>             
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
	<!-- Here is the link to the Style.css sheet(Note the PATH TO STYLE) -->
	<link href="/updated_php_project/static/style.css" rel="stylesheet">
	<!-- JS Code -->

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
				<a class="nav-link" href="meet_the_team.html">Team</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"id="location">Find Location</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" id="about">About</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"id="help">Help</a>
			</li>

		</ul>
	</div>
	</div>
</nav>

<div class="jumbotron" id ="jumbo_cont">
	<div class="display_text">
		<h1 class= "display-5">Welcome, Store Name</h1>
		<p class="lead">1922 W Maindrive Road, Beverlly Hills, CA.</p>
		<hr class="my-3">
	</div>
</div>

<!--- Image Slider -->

<div id="slides" class="carousel slide" data-ride = "carousel">
	<ul class ="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"> </li>
		<li data-target="#slides" data-slide-to="1"> </li>
		<li data-target="#slides" data-slide-to="2"> </li>
	</ul>

<!-- Reference this class in Style.css-->
<div class="carousel-inner">
	<div class="carousel-item center active">
		<img src="/updated_php_project/static/img/barbershop.jpg"/>
		<div class="carousel-caption">
<?php
		// Important Allow client to be able to make appointments 10 min before store opening.
	function check_date() {
		global $day_off, $current_date_client;
		if(in_array($current_date_client, $day_off)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function within_time(){
		global $current_time;
		global $start_time;
		global $end_time;
		$upper_time = date('G:i', strtotime('-25 minutes', strtotime($end_time)));
		if(strtotime($current_time) > strtotime($start_time) && strtotime($current_time) < strtotime($upper_time)){
			return TRUE;
		}else{
		    return FALSE;
		}
	}

	function check_frame(){
	    // check both start and finish
	    global $start_time;
	    global $end_time;
	    global $current_time;
	    $lower_time = date('G:i', strtotime('-10 minutes', strtotime($start_time)));
	    $upper_time = date('G:i', strtotime('-20 minutes', strtotime($end_time)));

	    if(strtotime($current_time) > strtotime($lower_time) && strtotime($current_time) < strtotime($start_time) ){
	        // You are within 10 minutues of opening
	        return 0;
	    }
	    if(strtotime($current_time) > strtotime($upper_time) && strtotime($current_time) < strtotime($end_time)){
	        // We are within the the last 25 minutes
	        return 1;
		}
		
		// Otherwise return 2;
		return 2;
	}

	if( within_time() == TRUE && check_date() == FALSE|| check_frame() == 0){
	 		echo '<h1 class= "display-2" style="font-size: 5.2vw;">Reserve your place in line</h1>';
			echo '<button class="btn btn-outline-light btn-lg" data-toggle="modal" data-target="#exampleModal1" data-whatever="@getbootstrap">Make Appointment</button>';
	}else if( check_frame() == 1 && check_date() == FALSE && within_time() == FALSE ){
		echo '<h2 class= "display-2" id= "closed_txt" style ="color: #d1000a; font-size: 6.2vw;">Closing soon.</h2>';
		echo '<p class="lead" style="color: red; font-size: 2.2vw;"> Please try a walk in appoinment since we cannot ensure you will be seen today!<p>';
	}else {
			echo '
			<h2 class= "display-2" id= "closed_txt" style ="color: #d1000a; font-size: 6.2vw;">Location is closed</h2>
			<button type="button" class ="btn btn-outline-light btn-lg" data-toggle="modal" data-target="#error_modal" data-whatever="@getbootstrap">Currently not open</button>
			';
	}	 
		?>
		</div>
	</div>
	<div class="carousel-item center">
		<img src="/updated_php_project/static/img/storefront2.jpg"/>
	</div>
	<div class="carousel-item center">
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
        <p class="lead">Appointments are opened up 15 minutes before opening time. Please make appointment at that time!</p>
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
		$stmt = "SELECT * FROM `client_information` WHERE 1; ";
		// Allow or Disallow appoinments based on Los Angeles times.
		// VAR: Multiplier: average time for a haircut.
		$multiplier = 10;
		$final = NULL;
		if ( $result = mysqli_query($connection, $stmt) ){
		$row_count = mysqli_num_rows($result);
		if($row_count <= 2){
			$final = "less than 10";
		} else {
			$final = $row_count * $multiplier;	
			}
		}
		mysqli_close($connection);
		if( within_time() == TRUE && check_date() == FALSE|| check_frame() == 0 ){
			echo'<h2 style = "color: #d41350;"> Save Time. Check In Online.</h2>'; // Change this color
			echo '<h2>Current wait time is <mark>'.$final.'</mark> mins.</h2>';
			echo '<p class="lead">We have a number of hair stylist working for us. Come on by and get a haircut!</p>';
			echo '<p class = "lead">Accepting online appointments now.</p>';
		} 
		else if(check_frame() == 1 && check_date() == FALSE && within_time() == FALSE){
			echo'<h2> Current wait time is <mark>0</mark> mins.</h2>';
			echo '<p class="lead">We have a number of hair stylist working for us. Come on by and get a haircut!</p>';
			echo '<p class ="lead"><mark>Current location is closing soon</mark>, keep in mind we open up online appointments 15 minutes before open time! So come back and sign up 15 minutes before to be first.</p> ';
			echo '<p class="lead" style="color: red;"> Please try a walk in appoinment since we cannot ensure you will be seen today!<p>';
		} else {
			echo'<h2> Current wait time is <mark>0</mark> mins.</h2>';
			echo '<p class="lead">We have a number of hair stylist working for us. Come on by and get a haircut!</p>';
			echo '<p class ="lead"><mark>Current location is closed</mark>, keep in mind we open up online appointments 15 minutes before open time! So come back and sign up 15 minutes before to be first.</p> ';
		} 
		?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
		<a href="#">
		<?php 
		if( within_time() == TRUE && check_date() == FALSE|| check_frame() == 0 ){
			echo '<button type="button" class ="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal1" data-whatever="@getbootstrap">Make Appointment</button>';
		} else if(check_frame() == 1 && check_date() == FALSE && within_time() == FALSE) {
			echo '<button type="button" class ="btn btn-outline-danger" data-toggle="modal" data-target="#error_modal" data-whatever="@getbootstrap">Closing Soon</button>';
		} else {
			echo '<button type="button" class ="btn btn-outline-danger" data-toggle="modal" data-target="#error_modal" data-whatever="@getbootstrap">Currently not open</button>';
		}
		 ?>
		</a>
	</div>

</div>
</div>

<!---Modal Handle Appointments-->


<div class="modal fade" id="exampleModal1" tabindex="-1" role= "dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Making Appointment</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
			</div>
			<form action ="send_to_buisness.php" method="post">
				<div class="modal-body">
					<div class="form-group">
            			<label for="client-name" class="control-label">Name</label>
            			<input type="text" class="form-control" id="client-name" name="client-name" required>
          			</div>
          			<div class="form-group">
            			<label for="client-email" class="control-label">Email:</label>
            			<input type="text" class="form-control" id="client-email" name="client-email" required>
          			</div>
          			<div class="form-group">
            			<label for="client-phone" class="control-label">Phone Number (10 digits no spaces)</label>
            			<input type="phone-number" class="form-control" id="client-phone" name = "client-phone" required>
          			</div>

          			<div class="form-group">
            			<label for="client-guest" class="control-label"> Number of guest (0 for yourself) </label>
            			<input class ="form-control" id="client-guest" type="number" min="0" max="7" name="client-guest">
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
					        <option value="7">Google-Fi</option>
					        <option value="8">Cricket-Moblile</option>
					        <option value="9">Virgin-Mobile</option>
	            		</select>
        			</div>
        		</div>
        		<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="submit" value= "Confirm Appointment" name = "clicked" class = "btn btn-primary">
        		</div>
        	</form>

				</div>
			</form>
		</div>
	</div>
</div>  


<div class="container-fluid padding">
<div class="row Welcome text-center">
	<div class="col-12">
		<h1 class="display-4">Services Offered</h1>
	</div>
	<hr>
</div>
<hr class="my-4">
</div>


<!---   Need to handle if values are empty  --->

<!--- This can be three items show off -->
<!-- Might need to figure out how to change the icons, they are labeled as i class "fas fa-code" etc -->
<div class="container-fluid padding">
<div class= "row text-center padding">
	<div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
		<i class="fas fa-cut fa-5x"></i>
		<h3>Haircut</h3>
		<p>Low Fade, High Fade, any style!</p>
		<p>Price: 15$</p>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
		<i class="fas fa-tint fa-5x"></i>
		<h3>Beard, Waxing</h3>
		<p>Eyebrows, Beard hot shave etc.</p>
		<p>Beard: 5$-10$, Waxing: 5$ - 20$ </p>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
		<i class="fas fa-anchor fa-5x"></i>
		<h3>The Works</h3>
		<p>Haircut, Beard and Shampoo.</p>
		<p>Price: 30$ Flat</p>
	</div>
</div>
</div>

<div class="container-fluid padding">
	<div class="row padding justify-content-center text-center">

	<div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
		<i class="fas fa-chess-queen fa-5x"></i>
		<h3>Salon Services</h3>
		<p>Perming Services, Hair Extension Services</p>
		<p>Price: 50$-70$</p>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
		<i class="fas fa-paint-brush fa-5x"></i>
		<h3>Salon Services</h3>
		<p>Coloring Services</p>
		<p>Price: 80$ Long hair avgerage</p>
	</div>
	</div>
</div>


<!--- This can be the types of cuts to offer -->


<!--- Containers Cards -->
<div class="container-fluid padding" id="cards">

<div class="container-fluid padding">
<div class="row Welcome text-center">
	<div class="col-12">
		<h1 class="display-4">Take a look</h1>
	</div>
	<hr>
</div>
</div>

<div class="row padding">
	<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src="/updated_php_project/static/img/col_haircut/men_fade_0.jpg">
			<div class="card-body">
				<h4 class="card-title">Men Haircuts</h4>
				<p class="card-text" id="color">Fades, Shaving Etc.</p>
				<a href="#" class="btn btn-outline-light" id="men_1">Show Work</a>
			</div>
		</div>
	</div>

<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src= "/updated_php_project/static/img/col_shave/shave_0.jpg">
			<div class="card-body">
				<h4 class="card-title">Shave, Beard Trim</h4>
				<p class="card-text">Hot Wax or Razor</p>
				<a href="#" class="btn btn-outline-light" id="men_2">Show Work</a>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="card">
			<img class="card-img-top" src= "/updated_php_project/static/img/col_color/color_woman_0.jpg">
			<div class="card-body">
				<h4 class="card-title">Women Color</h4>
				<p class="card-text">We also include women hair stylist to assist</p>
				<a href="#" class="btn btn-outline-light" id="woman_1">Show Work</a>
			</div>
		</div>
	</div>

<div class="col-md-3">
	<div class="card">
		<img class="card-img-top" src= "/updated_php_project/static/img/col_woman_style/woman.jpg">
		<div class="card-body">
			<h4 class="card-title">Women Styling</h4>
			<p class="card-text">From colors, wax, highlights, simple styling etc.</p>
			<a href="#"class= "btn btn-outline-light" id="woman_2" >Show Work</a>
		</div>
	</div>
    </div>
</div>

</div>
<!--- Connect to social media icons -->

<div class="container-fluid">
	<h2 class= "display-5" style="text-align: center; padding-top: 10px;">Follow us @</h2>
	<hr class="hr-4">
</div>

<div class="container-fluid padding">
	<div class="row text-center padding">
		<div class="col-xs-12 col-md-4">
		<img src="/updated_php_project/static/img/icons/instagram_icon.png" style= "height: 50px; width: 50px; "/>
		<a href="https://www.instagram.com">Instagram</a>
		</div>
		<div class="col-xs-12 col-md-4">
		<img src="/updated_php_project/static/img/icons/facebook_icon.png" style= "height: 50px; width: 50px; "/>
		<a href="https://www.facebook.com">Facebook</a>
		</div>
		<div class="col-xs-12 col-md-4">
		<img src="/updated_php_project/static/img/icons/twitter_icon.png" style= "height: 50px; width: 50px; "/>
		<a href="https://www.twitter.com">Twitter</a>
		</div>
	</div>
</div>


<!-- Instagram API -->

<!-- https://api.instagram.com/oauth/authorize?client_id=2935584593335299&redirect_uri=http://192.168.64.2/updated_php_project/design.php/auth/&scope=user_profile,user_media&response_type=code -->


<!-- API Setup, getting Error 400  -->

<!-- Popup modal Pictures -->

<div class="modal fade bd-example-modal-lg" id= "picture_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">

	<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pictures</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "close()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class= "modal-body co-inner">
      	<div id="show_work" class="carousel slide" data-ride = "carousel">
		<ul class ="carousel-indicators">
			<li data-target="#show_work" data-slide-to="0" class = "active"></li>
			<li data-target="#show_work" data-slide-to="1"> </li>
			<li data-target="#show_work" data-slide-to="2"> </li>
			<li data-target="#show_work" data-slide-to="3"> </li>
		</ul>
      	<div class="carousel-inner show">
			<div class="carousel-item active">
				<img src="/updated_php_project/static/img/barbershop.jpg" id="1" class="img-responsive"/>
			</div>

      		<div class="carousel-item">
				<img src="/updated_php_project/static/img/storefront2.jpg"id="2" class="img-responsive"/>
			</div>

			<div class="carousel-item">
				<img src="/updated_php_project/static/img/storefront.jpg" id="3" class="img-responsive"/>
			</div>

			<div class="carousel-item">
				<img src="/updated_php_project/static/img/storefront.jpg" id="4" class="img-responsive"/>
			</div>

      	</div>
      </div>
      </div>
  </div>
  </div>
</div>

<script type="text/javascript">

// We assume all pictures are end in .jpg 
// We do a check to see if url is valid
// We assume to only have 4 photos 
// 
$(document).ready(function (){
	$('#men_1').on('click', function(){
		var path = "col_haircut";
		var extention = "men_fade_";
		load_images(path, extention);
	});
	$('#men_2').on('click', function(){
		var path = "col_shave";
		var extention = "shave_";
		load_images(path, extention);
	});

	$('#woman_1').on('click', function() {
		var path = "col_color";
		var extention = "color_woman_";
		load_images(path, extention);
	});

	$('#woman_2').on('click', function() {
		var path = "col_woman_style";
		var extention = "woman_style_";
		load_images(path, extention);
	});
});

// Load images based on max of 4
// Given, Path & extention assume : jpg
function load_images(path, ext){
	var SIZE = 4;
	var iter = 1;
	for(i =0 ; i < SIZE;  i++){
		var id = (i + 1).toString();
		var pathToCheck = "/updated_php_project/static/img/"+path+"/"+ext+i+".jpg";
		if(!UrlExists(pathToCheck)){
			document.getElementById(id).src = "/updated_php_project/static/img/not_found.jpg";
		}else{
			document.getElementById(id).src = "/updated_php_project/static/img/"+path+"/"+ext+i+".jpg";
		}
	}
	$("#picture_modal").modal('show');
}

// Retuns Boolean: True-> 200 
// Code cleanup : Switch case!
function UrlExists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    if(http.status == 404){
    	return false;
    }else if(http.status == 200){
    	return true;
    }else{
    	return false;
    }
    return false;
}


$(document).ready(function() {
	$('#about').on('click', function() {
	about();
	});
	$('#help').on('click', function() {
	help();
	});
	$('#location').on('click', function(){
		location_func();
	});
});
function location_func(){
	$('#location_modal').modal('show');
}


function clearField() {
	$('#show_data').collapse('hide');
	$('check_app_cancell').val('');
}

$(document).ready(function(){
	$('#submitButton').on('click', function() {
		// get input box on click
		// make request
		var em = $('#check_app_cancell').val();
		console.log(em);
		make_request(em);
	});

	$('#remove_me').on('click', function (){
		var rem_emm = $("#i-email").text();
		var final_string = rem_emm.replace('Email: ','');
		console.log(final_string);
		remove_based_email(final_string);
	});
});



function remove_based_email(email){
	var xhr = $.ajax({
	type:'POST',
	url:'handle_clients.php',
	timeout: 5000,
	data:{'email': email},
	success: function(rdata) {
		console.log(rdata);
		if(rdata == "YES"){
			$('#show_data').collapse('toggle');
			$('#check_existing').modal('toggle');
			show_modal("Removal Success", "You have successfully removed yourself from the appointment line. Thanks have a good day!");
		}else {
			console.log("Err");
			$('#show_data').collapse('toggle');
			$('#check_existing').modal('toggle');
			show_modal("Fatal Error", "We where not able to remove you from the line, please try later");
		}
	}, 
	error: function(err, code) {
		console.log(err);
		console.log(code);
		$('#time_out').modal('toggle');
		
		
	}
});	
}


function make_request(user_email){
	var xhr = $.ajax({
	type:'POST',
	url:'handle_clients.php',
	timeout: 5000,
	dataType: 'json',
	data:{'user_email':user_email },
	success: function(rdata) {
		if(rdata["responseText"] == "Not Found"){
			$('#check_existing').modal('toggle');
			show_modal("Cannot Be found", "The email used cannot be found in our system. Tip: this field is case sensitive so be exact!");
			xhr.abort();
		}else if(rdata["responseText"] == "SQL:Error"){
			console.log('Fatal');
			$('#check_existing').modal('toggle');
			show_modal("Cannot Be found", "SQL Error was found. Please reload the page or call the buisness number to check your appointment manualy.");
			xhr.abort();
		}else if(rdata["responseText"] == "Error Fatal"){
			console.log('Rows');
			$('#check_existing').modal('toggle');
			show_modal("Cannot Be found", "Error Fatal");	
			xhr.abort();
		}else {
			load_data(rdata);
		}
	}, 
	error: function(err, code, dd) {
		console.log(err);
		console.log(code);
		console.log(dd);
		
	}
});	
}

function load_data(rdata){
	document.getElementById('i-name').innerHTML = 'Name: ' + rdata['Name'];
	document.getElementById('i-time').innerHTML = 'Time: ' + rdata['Time'];
	document.getElementById('i-date').innerHTML = 'Date: ' +rdata['Date'];
	document.getElementById('i-stylist').innerHTML = 'Stylist: ' +rdata['Per_stylist'];
	document.getElementById('i-email').innerHTML = 'Email: ' +rdata['Email'];
	$('#show_data').collapse('toggle');
}

function cancell_click(){
	$(document).ready(function(){
		$('#check_existing').modal('toggle');
	});
}

function help() {
	$('#help_modal').modal('show');
}
function cancell_click(){
	$(document).ready(function(){
		$('#check_existing').modal('toggle');
	});
}

function show_modal(title,body){
	document.getElementById('title_config').innerHTML = title;
	document.getElementById('body_message').innerHTML = body;
	$("#configure_modal").modal("toggle");
}  

function about() {
	$('#about_modal').modal('toggle');
}

</script>


<div class="modal fade" id="check_existing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Check Or Remove Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearField();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group" id="remove_group">
                  <label for="client-email" class="control-label">Enter Email (case sensitive)</label>
                  <input type="text" class="form-control" name="client-email" required = "" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" id="check_app_cancell" autocomplete="off">
			</div>

			<div class="collapse" id="show_data">
  				<div class="card card-body">
					<div class="card card-title" id="time_title_message">
						<h2 class="header" id="av_title">Appointment Details</h2>
					</div>
					<div class="row btn-group d-flex" id="inner_row">	
						<div class="btn-group-vertical" role="group" id="inner_data" aria-label="Basic example">
							<p id="i-name"></p>
							<p id="i-date"></p>
							<p id="i-time"></p>
							<p id="i-stylist"></p>
							<p id="i-email"></p>
							<input type="submit" value="Remove Me" id="remove_me" class="btn btn-danger">
						</div>	
					</div>
 			 	</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="clearField();">Close</button>
        <input type="submit" value= "View/Remove" name="remove_client" class = "btn btn-warning" id="submitButton">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="help_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body" id = "body_err">
            <p class="header text-center">Salon Help</p>
            <p class="sub_header text-center">If you need help with salon services please feel free to call the establishment via: 909-XXX-XXXX.</p>
            <hr class="hr">
            <p class="header text-center">Website Help</p>
            <p class="sub_header text-center">If you need help with anything related to this website, please feel free to email use at: lag.webservices@gmail.com</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="configure_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_config">Refresh Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>
	  <img class="img_about" src ="/updated_php_project/static/img/barbershop.jpg">
      <div class="modal-body" id= "body_config">      
        <p class="lead text-center" id="body_message">Looks like we have a timeout error, please check if you are connected to the internet. Or try to refresh the entire page.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="location_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="error_modal">Find Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
        Address: 1234 W mark st Hollywood Ca, 92000;
      </div>
      <div class="modal-body text-center">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.2613412453115!2d-117.88911478478953!3d33.88292258065241!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dcd5ce8cc61391%3A0x2b9810bbb94af355!2sCalifornia%20State%20University%2C%20Fullerton!5e0!3m2!1sen!2sus!4v1593842850490!5m2!1sen!2sus" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="about_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="static/img/storefront.jpg" class="img-responsive" style="max-width: 100%;">
        </div>
        <div class="modal-body" id = "body_err">
            <p class="header text-center">About Us</p>
            <p class="sub_header text-center">We are a small company located on 988 W something Drive, Beverly hills Ca, 90000. Our promise to our clients is to ensure every service is to the highest standard.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>



<!--- Footer, With Client information and Job Opp -->

   <footer>
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-3">
			<h5 class="footer_title">Have Questions?</h5>
			<hr class="small_hr">
			<p>909-572-5474</p>
			<p>someemail@gmail.com</p>
			<p>1988 W something Drive</p>
			<p>Beverly Hills Ca, 92400</p>
			<hr class="small_hr">
		</div>

		<div class="col-md-3">
			<h5 class="footer_title">Our Hours</h5>
			<hr class="small_hr">
			<p>Monday: 9am-6pm</p>
			<p>Tuesday: 9am-6pm</p>
			<p>Wednesday: 9am-6pm</p>
			<p>Thursday: 9am-6pm</p>
			<p>Friday: 9am-6pm</p>
			<p>Saturday: 9am-6pm</p>
			<p>Sunday: Closed</p>
			<hr class="small_hr">

		</div>
		<div class="col-md-3">
			<h5 class="footer_title">Help With Website?</h5>
			<hr class="small_hr">
			<p>example@gmail.com</p>
			<p>909-572-5474</p>
			<hr class="small_hr">
		</div>

		<div class="col-md-3">
            <div class="container text-center">
              <h2 class="footer_title">About Us</h2>
              <hr class="small_hr">
			  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			  <p style="color: #4ed9f7;"> View OR Cancell Appoinment <a onclick="cancell_click();">Click Me</p>
            	<hr class="small_hr">
                <a href="#"><img src="static/img/icons/twitter_icon.png" style="height: 50px; width: 50px;"></a>
                <a href="#"><img src="static/img/icons/facebook_icon.png" style="height: 50px; width: 50px;"></a>
                <a href="#"><img src="static/img/icons/instagram_icon.png" style="height: 50px; width: 50px;"></a>
            
            </div>
            <hr class="small_hr">
          </div>


		</div>
	</div>
</footer>


</body>
</html>




