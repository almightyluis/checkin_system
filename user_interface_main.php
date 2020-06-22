<?php 

	session_start();
	if(!isset($_SESSION['user-login-success'])){
		header('Location: design.php');
    die();
	}
	include('server_connect.php');

  	$stmt = "SELECT * FROM `client_information` ORDER BY `Time` ASC; ";
  	$result = mysqli_query($connection , $stmt);
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
  <link href="/updated_php_project/static/user_main_interface_style.css" rel="stylesheet">

</head>

<?php
	function exit_user() {
		session_destroy();
		header('Location: user_login_page.html');
	}
	if(isset($_GET['logout_click'] )){
		exit_user();
		exit();
	}
  if(isset($_GET['email_match'])){
    echo'<script type="text/javascript">
        $(function() {
        $("#err_mail").modal("show");
         }); </script>';
  }
?>


<div class="modal fade" id="err_mail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Email Conflict</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <mark>Email entered is already in the list.</mark> Please either remove the client from the list or use a different email.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<body>
  <nav class = "navbar navbar-expand-md navbar-light bg-light sticky-top">
  	<div class="container-fluid">
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
  		<span class="navbar-toggler-icon"> </span>
  	</button>
  	<div class="collapse navbar-collapse" id ="navbarResponsive">
  		<ul class="navbar-nav ml-auto">
  			<li class="nav-item">
  				<a class="nav-link" href= "user_interface_main.php?logout_click=true" style = "color: #787B7C">Log out</a>
  			</li>
  			<li class = "nav-item">
  				<a class = "nav-link" href= "client_view.php?client_view_click=true" target="_newtab" style = "color: #787B7C">Launch Client View</a>
  			</li>
  			<li class="nav-item">
  				<a class="nav-link" href="#" style = "color: #787B7C">Help</a>
  			</li>
  		</ul>
  	</div>
  	</div>
  </nav>

  <div class="jumbotron"> <?php 
    date_default_timezone_set('America/Los_Angeles');
    $today = date("N"); 
    $date = date("l");
    $current_date = date("l, M-d-Y");

  if($today == $_SESSION['day_off']){
    echo '<h1 class="display-4" style = "color: #FFFFFF">Not accepting clients today, day off '.$date.'.</h1>
          <h2 class = "display-6" style = "color: #FFFFFF"> '.$current_date.'</h2>
    ';
    die();
  }else{
      echo '<h1 class="display-4" style = "color: #FFFFFF">Hello, current list.</h1>

      <h2 class = "display-6" style = "color: #FFFFFF"> '.$current_date.'</h2>
      ';
  }
  ?>
</div>

<!-- Handle client side removals and Check -->
<!-- Also attemt to reload the service -->
<script type="text/javascript">
function reload_table() {
    var value = "value"; 
    $.ajax({
    type: 'POST',
    timeout: 5000,
    url: "refresh_current_table_ctd.php",
    data:{'value':value},
      success: function(responce){
       $("#table_id").html(responce);
       console.log("Reload pages Successfull");
      }, 
      error: function(){
        $("#timeout_error").modal("show");
        console.log("Timeout error");
      }
    }); 
}

// 1 min = 60000
// 3 min = 180000
// 5 min = 300000
$(function() {
  $("#holder :input").change(function() {
    switch(this.id){
      case "option1":
        var increment = 60000;
        setTimeout(reload_table, increment);
      break;
      case "option2":
        var increment = 180000;
        setTimeout(reload_table, increment);
      break;
        case "option3":
        var increment = 300000;
        setTimeout(reload_table, increment);
      break;
    }

  });
});


$(function(){
    $(document).on('click','.remove',function(){
      var del_id= $(this).attr('id');
      var $ele = $(this).parent().parent();
      $.ajax({
        type:'POST',
        url:'handle_clients.php',
        timeout: 5000,
        data:{'del_id':del_id},
        success: function(responce){
          	if(responce == "YES"){
          		//$ele.closest("tr").remove();
          		$ele.closest('tr').css('background','#ff2b2b');
          		$ele.closest('tr').find('td').fadeOut(1000,function(){ 
              $ele.remove();
              reload_table();        
            }); 
          	}else{
          		console.log("Error, PHP not able to add to remove or recived something other than YES");
          	}
         },
         error: function(){
          $("#timeout_error").modal("show");
        }
      });
    });
});

$(function () {
  $(document).on('click', '.email_send', function() {
    var cc_id = $(this).attr('id');
    console.log(cc_id);
    $.ajax({
      type: 'POST',
      timeout: 5000,
      url: 'handle_clients.php',
      data: {'cc_id': cc_id },
      success: function (responce) {
        if(responce){
          if(responce == "Error: Email is empty"){
            $("#email_error_modal").modal("show");
            console.log("if");
          }else if (responce == "Success") {
            console.log("else if");
            $("#email_send_modal").modal("show");
          }else {
            console.log(responce);
          }
        }
      }
    });
  });

});

$(function(){
    $(document).on('click','.check',function(){
      var check_in = $(this).attr('id');
      var $ele = $(this).parent().parent();

      console.log(check_in);
      $.ajax({
        type:'POST',
        url:'handle_clients.php',
        timeout: 5000,
        data:{'check_in':check_in},
        success: function(responce){
          	if(responce == "YES"){
          		//$ele.closest("tr").remove();
          		$ele.closest('tr').find('td').fadeIn(1000, function(){
          		});
              reload_table();
          	}else{
          		console.log("Error, PHP not able to add to remove or recived something other than YES");
          	}
         },
         error: function(){
          $("#timeout_error").modal("show");
      }
        });
    });
});


$(function() {
    var value = 'value';
    $(document).on('click', '.reload', function(){
      var xhr = $.ajax({
      type: 'POST',
      timeout: 5000,
      url: "refresh_current_table_ctd.php",
      data:{'value':value},
      success: function(responce){
         $("#table_id").html(responce);
         console.log("Reload success");
      },
      error: function(){
        $("#timeout_error").modal("show");
        console.log("Reload success");
      }
      });  
    });
});
</script>

<div class="modal fade" id="timeout_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refresh Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Looks like we have a timeout error, please check if you are connected to the internet. Or try to refresh the entire page.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="email_error_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Email Cannot be sent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Client did not specify a valid email, try calling the phone number given.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="email_send_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Email Sent!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Email succesfull sent to client.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="add_new_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Making Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action ="interface_request.php" method= "post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="client-name" name ="client-name" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="client-email" name="client-email" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Phone Number:</label>
            <input type="phone-number" class="form-control" id="client-phone" name ="client-phone" required>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label"> Number of guest: </label>
            <input type="number" class = "form-control" id="client-guest" min="0" name="client-guest" required>
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
        <input type="button" class="btn btn-secondary" data-dismiss="modal" value = "Close">
        <input type="submit" value= "Confirm Appointment" name ="clicked" class = "btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>


<div class = "button-holder" id = "holder">
<button class = "reload btn btn-info" id = "reload" name = "refresh">Refresh Table</button>
<button class = "add_new btn btn-info" id = "add_new" data-target="#add_new_modal" data-toggle="modal">Add New Client</button>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option1" autocomplete="off"> 1 Min
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option2" autocomplete="off"> 3 Min
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="options" id="option3" autocomplete="off"> 5 Min
  </label>
</div>
</div>

<div class = main_table id = "table_id">
	<table class="table table-hover">
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
	  <tbody>
	  	<?php
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
		  			echo '<tr>
	  				<td>'.$itter++.'</td>
	  				<td>'.$row['Name'].'</td>
	  				<td>'.$row['Phone'].'</td>
	  				<td>'.$row['Guest'].'</td>
            <td>'.$row['Email'].'</td>
	  				<td><p class="text-success"> '.$current_status.' </p> </td>
	  				<td>
	  					<input type = "submit" class = "check btn btn-success btn-sm" id ='.$row['id'].' name = "check" value = "Check-in">
              <input type = "submit" value ="Send Email" name = "email_send" id = '.$row['id'].' class = "email_send btn btn-info btn-sm">
						  <input type="submit" value="Remove" name ="remove" id ='.$row['id'].' class ="remove btn btn-danger btn-sm">
              
					</td>
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


</body>


</html>
