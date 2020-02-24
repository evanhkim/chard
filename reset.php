<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require './php/db.php';
session_start();
// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
	$email = $mysqli->escape_string($_GET['email']); 
	$hash = $mysqli->escape_string($_GET['hash']); 
	
	// Make sure user email with matching hash exist
	$result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");
	if ( $result->num_rows == 0 )
	{ 
	     $message = "no";
   	}
	else {
	    $message = "yes";
	}
}
?>

<!Doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv=content-language content="en-us" />
  <title>CHAR | Reset</title>
  <link rel="shortcut icon" type="image/x-icon" href="./img/ChardLogo.png">
  <meta name="author" content="Evan Kim">
  
    <!-- Bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap/bootstrap.css">
    <script src="./js//bootstrap/bootstrap.js"></script>

    <script src="./js/jquery-3.4.1.min.js"></script>

	<link rel="stylesheet" href="./css/style.css">
</head>

<body>
	<noscript>You need to enable JavaScript to run this app.</noscript>
	
	<div class='root'>
		<div class='container'>
			<div class="row header">
				<div class="col">
					<span class="navbar-brand mb-0 h6"><h3>CHAR</h3></span>	
				</div>
			</div>
			<div class="row body">
				<div class="col">
					<form>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password">
	  					</div>
	  				</form>
	  				<form>
						<div class="form-group">
							<label for="password">Confirm Password</label>
							<input type="password" class="form-control" id="passwordConfirm" placeholder="Confirm Password">
	  					</div>
	  				</form>  
	  				<div class="alert border-warning alert-warning warning alert-dismissible error-box" id='reset-error-box'>
						<a class="close" aria-label="close">&times;</a>
						<strong></strong>
						<h6></h6>
					</div>
					<div class="alert border-success alert-success success alert-dismissible error-box" id='reset-success-box'>
						<a class="close" aria-label="close">&times;</a>
						<strong></strong>
						<h6></h6>
					</div>
					<div class='row' style='padding-left:15px;padding-right:15px;'>
	  					<div class='col'>
	  						<div id='resetPwd' class="btn btn-primary btn-block ld-ext-right">
								Reset Password
								<div class="ld ld-ring ld-spin"></div>
							</div>
	  					</div>
	  					<div class='col'>
	  						<div id='cancel' class="btn btn-secondary btn-block ld-ext-right">
								Cancel
								<div class="ld ld-ring ld-spin"></div>
							</div>
	  					</div>
	  				</div>
	  			</div>
  			</div>
		</div>
		<input type="hidden" id='email' value="<?= $email ?>">    
          	<input type="hidden" id='hash' value="<?= $hash ?>">  
	</div>
	
	<script type='text/javascript'>
		var message = "<?php echo $message; ?>";
		if (message == 'no') {
			alert('You have entered invalid URL for password reset!');
			location.replace("./portal.php");
		}
	</script>
  	<script src="./js/reset.js"></script>
</body>
</html>