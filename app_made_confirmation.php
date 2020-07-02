<?php

  session_start();
  if(!isset($_SESSION['client-name'])) {
        echo "Error, trying to access a page without permissions,";
        echo "Page Session has not been meet";
        exit();
  } 
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <link href= "/updated_php_project/static/confirmation_style.css" rel="stylesheet" type="text/css">

</head>

<body>
  <nav class = "navbar navbar-expand-md navbar-light bg-light sticky-top">
  	<div class="container-fluid">
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
  		<span class="navbar-toggler-icon"> </span>
  	</button>
  	<div class="collapse navbar-collapse" id ="navbarResponsive">
  		<ul class="navbar-nav ml-auto">
  			<li class="nav-item">
  				<a class="nav-link" href="design.php">Return Home</a>
  			</li>
  			<li class="nav-item">
  				<a class="nav-link" href="#">Find Location</a>
  			</li>
  			<li class="nav-item">
  				<a class="nav-link" href="#">Help</a>
  			</li>

  		</ul>
  	</div>
  	</div>
  </nav>

  <div class="jumbotron text-center">
  <h1 class="display-4">Appointment made!</h1>

    <?php   
        echo '<p class="lead"> <mark>'.$_SESSION['client-name'].'</mark> your appointment has been set, please head over to check into the line.</p>';    
    ?>
  <?php include_once 'server_connect.php';
        $stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
        $result = mysqli_query($connection , $stmt);
        $number_rows = mysqli_num_rows($result) - 1;
  echo '<p>Currently <mark>'.$number_rows.'</mark> customers ahead of you, thanks, and hope to see you soon.</p> '; ?>
  <!-- Shop current Address Locaiton should be added here. -->
  <a class="btn btn-primary btn-lg" href="#" role="button">Directions</a>
  <a class="btn btn-primary btn-lg" href="design.php" role="button">Return Home</a>
</div>

<div class="container-fluid padding">
  <h1 class="display-4 text-center">Directions</h1>
  <hr class="my-4">

  <div class=" container-fluid text-center">

    <p class="lead" id="hover_click">Address: 900 University Ave, Riverside, CA 92521.</p>
  </div>
  <div id="map-container-google-1" class="container-fluid">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3308.7326733675372!2d-117.33025308441519!3d33.97370992931135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dcae4687aa9fb3%3A0x10050bdf47721d31!2sUniversity%20of%20California%2C%20Riverside!5e0!3m2!1sen!2sus!4v1593648387948!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  </div>
  <hr class="my-4">
</div>


<script type="text/javascript">
  
</script>

<footer>
  <div class="container-fluid padding">
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
        <p>Monday: 9am-10pm</p>
        <p>Tuesday: 9am-10pm</p>
        <p>Wednesday: 9am-10pm</p>
        <p>Thursday: 9am-10pm</p>
        <p>Friday: 9am-10pm</p>
        <p>Saturday: 9am-10pm</p>
        <p>Sunday: OFF</p>

      </div>


      <div class="col-md-4">

        <hr class="light">
        <h5>Software Opportunities</h5>
        <hr class="light">
        <p>otfgonzalez@gmail.com</p>
        <p>909-572-5474</p>

      </div>
    </div>
  </div>
</footer>

</body>

</html>
