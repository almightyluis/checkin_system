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
  <link href= "/updated_php_project/static/confirmation_style.css" rel="stylesheet">



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
  				<a class="nav-link" href="#">About</a>
  			</li>
  			<li class="nav-item">
  				<a class="nav-link" href="#">Help</a>
  			</li>

  		</ul>
  	</div>
  	</div>
  </nav>

  <div class="jumbotron">
  <h1 class="display-4">Appointment made!</h1>

    <?php   
        echo '<p class="lead"> <mark>'.$_SESSION['client-name'].'</mark> Your appointment has been set, please head over to check into the line.</p>';    
    ?>



  <hr class="my-4">
  <?php echo '<p>Currently '.$_SESSION['number-guest'].' of people ahead of you.</p> ';  ?>
  
  <!-- Shop current Address Locaiton should be added here. -->
  <a class="btn btn-primary btn-lg" href="#" role="button">Directions</a>
  <a class="btn btn-primary btn-lg" href="design.php" role="button">Return Home</a>
</div>



<footer>

  <dir class="container-fluid padding">
    <div class="row text-center">
      <div class="col-md-4">
        <img src="/updated_php_project/static/img/icon2.png">
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
  </dir>
</footer>

</body>

</html>
