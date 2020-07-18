<?php

  session_start();
  if(!isset($_SESSION['client-name'])) {
        echo "Error, trying to access a page without permissions,";
        echo "Page Session has not been meet";
        header("Location: error_restricted.html");
        exit();
  }


if(isset($_GET['home_k'])){
  session_destroy();
  unset($_SESSION);
  header("Location: design.php");
}
if(isset($_GET['team_k'])){
  session_destroy();
  unset($_SESSION);
  header("Location: meet_the_team.html");
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
  				<a class="nav-link" href="app_made_confirmation.php?home_k=true" id="home">Home</a>
  			</li>
  			<li class="nav-item">
  				<a class="nav-link" href="app_made_confirmation.php?team_k=true" id="team">Team</a>
  			</li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="about">About</a>
        </li>
  			<li class="nav-item">
  				<a class="nav-link" href="#" id="help">Help</a>
  			</li>

  		</ul>
  	</div>
  	</div>
  </nav>

  <div class="jumbotron text-center">
  <h1 class="display-4">Appointment made!</h1>

    <?php   
        echo '<p class="lead"> <mark>'.htmlentities($_SESSION['client-name']).'</mark> your appointment has been set, please head over to check into the line.</p>';    
    ?>
  <?php include_once 'server_connect.php';
        $stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
        $result = mysqli_query($connection , $stmt);
        $number_rows = htmlentities(mysqli_num_rows($result) - 1);
  echo '<p>Currently <mark>'.$number_rows.'</mark> customers ahead of you, thanks, and hope to see you soon.</p> ';
  mysqli_close($connection);
   ?>
  <!-- Shop current Address Locaiton should be added here. -->

</div>

<div class="container-fluid padding">
  
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

  $(document).ready(function() {
    $('#help').on('click', function() {
    help();
  });
    $('#about').on('click', function() {
      about();
    });
});


  $(document).ready(function() {
    $('#home','#about','#team').on('click', function(){
      console.log("Clicked");
      //destroy_session();
    });
  });

  function destroy_session(){
    var xhr = $.ajax({
      type: 'GET',
      timeout: 5000,
      url: 'kill_sess.php',
      data: {'kill_sess': 'kill_sess'},
      success: function (responce) {
        if(responce == "Session: Destroyed"){
          console.log("Session-Destroyed");
        }else if(responce == "Session: Not Destroyed"){
          console.log("Session: Not Destroyed");
        }else{
          console.log("Fatal Error");
        }

      },
      error: function() { 
        console.log("Error Func called");
      }
    });
  }

  function about() {
  var title = "About";
  var body = "Small Company founded in 2020, delivering quality service. If for some reason you are not satisfied please feel free to contact the manager or owner using the TEAM tab. ";
  document.getElementById('img_about').src = "/updated_php_project/static/img/barbershop.jpg";
  document.getElementById('title_config').innerHTML = title;
  document.getElementById('body_message').innerHTML = body;
  $('#configure_modal').modal('show');
  }

  function help() {
  var title = "Help";
  var body = "For any questions or concerns about the website please email: l.gonzalez9778@student.sbccd.edu. ";
  document.getElementById('img_about').src = "/updated_php_project/static/img/help.png";
  document.getElementById('title_config').innerHTML = title;
    document.getElementById('body_message').innerHTML = body;
  $('#configure_modal').modal('show');
}


  
</script>



<div class="modal fade" id="configure_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_config">Refresh Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id= "body_config"> 
        <img src="/updated_php_project/static/img/barbershop.jpg" id="img_about" style="height: 300px; margin-right: auto; margin-left: auto; display:block;">
     
        <p class="lead text-center" id="body_message" style="padding-top: 7px;">Looks like we have a timeout error, please check if you are connected to the internet. Or try to refresh the entire page.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
