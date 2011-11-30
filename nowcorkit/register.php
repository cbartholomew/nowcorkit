<?
	require_once('#!/common.php');
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{ 
		$validation_values = ValidateNewRegistration($_POST); 
		$is_post = true;
		
		// create a new user and redirect if the validation object is all true
		if ($validation_values['first_name'] 		== 'true' && 
		 	$validation_values['last_name']  		== 'true' &&
			$validation_values['email']  			== 'true' &&
			$validation_values['email_available']  	== 'true' &&
			$validation_values['email_valid']  		== 'true' &&
			$validation_values['password']  		== 'true' &&
			$validation_values['password_length']  	== 'true' &&
			$validation_values['password_match']  	== 'true' &&
			$validation_values['state']  			== 'true')
			{
					// validation checks out, create user
					// pass the form data into the user object constructor
			  		$new_user = new User($_POST);
			  	  	$new_user->hash_password();	
			  	  	// insert the new user into the database;
			  	  	$new_user->insert();

			  	  	// set the session to the newly registered id
			  	  	$_SESSION["users_cork_id"] = $new_user->cork_id;

			  	  	// redirect the user to the menu page
			  	  	redirect("menu.php");
			}
		
	} 
	else { $is_post = false; }

?>
<!DOCTYPE html>
<head>
	<!--Load CSS Libraries-->
	<link rel="stylesheet" href="css/validation.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">	
	<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<!--Load Javascript Libraries-->
	<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>		
	<script>
	//Render Submit Button
		$(function() {
			$( "input:submit", "dialog-form" ).button();
	});
	</script>
	
</head>
<html>
	<body>			
		<div id="header"  class="ui-widget-header">
			<h2>You Made It, Now Cork It!</h2>
		</div>
		<div id="login" title="login" class="ui-widget-content ui-corner-all">
			<form id="signupform" method="POST" action="register.php">	
			<h1>Register</h1>	
			<fieldset>
				<!-- /***********FIRST NAME SERVER SIDE VALIDATION***********/	 -->	
				<? 		
					if ($is_post == true) { if ($validation_values['first_name'] == 'false') {echo "<label id='lfirstname' name='lfirstname' style='color:red'>First Name</label>";}
											else {echo "<label id='lfirstname'  name='lfirstname' style='color:white'>First Name</label>";}}
					else {echo "<label id='lfirstname'  name='lfirstname' style='color:white'>First Name</label>";}
				?>
			    <input type="text" name="firstname" id="firstname" value="<?= $_POST['firstname']; ?>" class="ui-widget-content ui-corner-all" />
			 	
				<!-- /***********LAST NAME SERVER SIDE VALIDATION***********/ -->		
				<? 		
					if ($is_post == true) { if ($validation_values['last_name'] == 'false') {echo "<label id='llastname' name='llastname' style='color:red'>Last Name</label>";}
											else {echo "<label id='llastname'  name='llastname' style='color:white'>Last Name</label>";}}
					else {echo "<label id='llastname'  name='llastname' style='color:white'>Last Name</label>";}
				?>
			    <input type="text" name="lastname" id="lastname" value="<?= $_POST['lastname']; ?>" class="ui-widget-content ui-corner-all" />
				
				<!-- /***********EMAIL SERVER SIDE VALIDATION***********/ -->		
				<? 		
				    $errors = "";
					if ($is_post == true) { 
											if ($validation_values['email_valid'] 	  == 'false') {  $error =  "Is not valid Email (username@domain.xxx) \n"; }
											if ($validation_values['email_available'] == 'false') {  $error .= "Email is already Registered \n"; }
											if ($validation_values['email'] == 'false' || $error != "")
											 {
											 echo "<label id='lemail' name='lemail' style='color:red'>Email</label>";
										 	 echo "<label id='lemailerror' name='lemailerror' style='color:red'>". $error ."</label>";
											 }
											 else{ echo "<label id='lemail'  name='lemail' style='color:white'>Email</label>";}
					}
					else {
							echo "<label id='lemail'  name='lemail' style='color:white'>Email</label>";
					}
				?>
			    <input type="text" name="email" id="email" value="<?= $_POST['email']; ?>" class="ui-widget-content ui-corner-all" />

				<!-- /***********PASSWORD SERVER SIDE VALIDATION***********/ -->
				<? 		
				    $errors_pass = "";
					if ($is_post == true) { 
											if ($validation_values['password'] 	  		  == 'false') {  $errors_pass =  "You have not entered a password \n"; }
											if ($validation_values['password_length']	  == 'false') {  $errors_pass .= "that is greater than 5 characters \n "; }
											if ($validation_values['password'] == 'false' || $errors_pass != "")
											 {
											 	echo "<label id='lpassword' name='lpassword' style='color:red'>Password</label>";
										 	 	echo "<label id='lpassworderror' name='lpassworderror' style='color:red'>". $errors_pass ."</label>";
											 }
											 else{ echo "<label id='lpassword'  name='lpassword' style='color:white'>Password</label>";}
					}
					else {
							echo "<label id='lpassword'  name='lpassword' style='color:white'>Password</label>";
					}
				?>
				<input type="password" name="password" id="password" class="ui-widget-content ui-corner-all" />
						
				<? 		
				    $errors_pass_confirm = "";
					if ($is_post == true) { 
											if ($validation_values['password_match'] == 'false') { $errors_pass_confirm =  "Your passwords do not match \n"; }
											if ($validation_values['password_match'] == 'false')
											 {
											 	echo "<label id='lpasswordconfirm' name='lpasswordconfirm' style='color:red'>Confirm Password</label>";
										 	 	echo "<label id='lpasswordconfirmerror' name='lpasswordconfirmerror' style='color:red'>". $errors_pass_confirm ."</label>";
											 }
											 else{ echo "<label id='lpasswordconfirmerror'  name='lpasswordconfirmerror' style='color:white'>Confirm Password</label>";}
					}
					else {
							echo "<label id='lpasswordconfirm'  name='lpasswordconfirm' style='color:white'>Confirm Password</label>";
					}
				?>
				<input type="password" name="password_confirm" id="password_confirm"  class="ui-widget-content ui-corner-all" />

				<!-- /***********STATE SERVER SIDE VALIDATION***********/ -->
				
				
				<?
				$errors_state = "";
				if ($is_post == true) {
										if ($validation_values['state'] == 'false') { $errors_state =  "You must choose a state \n"; }
										if ($validation_values['state'] == 'false')
										 {
										 	echo "<label id='lstate' name='lstate' style='color:red'>Choose State</label>";
									 	 	echo "<label id='lstateerror' name='lstateerror' style='color:red'>". $errors_state ."</label>";
										 }
										 else{ echo "<label id='lstate'  name='lstate' style='color:white'>Choose State</label>";}
				}
				else {
						echo "<label id='lstate'  name='lstate' style='color:white'>Choose State</label>";
				}

				?>
					<select id="state" name="state" class="ui-widget-content">
					<option value="0" selected="selected">Please Choose...</option>
				<?
					// load the state to id select box
					$state_array = GetStates();
					for ($i=0; $i<50;$i++)
					{
						$state = new State();
						$state = array_pop($state_array);
						echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
					}								
				?>		 
				</select>

				</fieldset>
				<br>
				<button type="submit" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" value="submit">
				   <span class="ui-button-text">Create Account</span>
				</button>
		  </form>
		</div>
		<div id="footer" class="ui-widget-header">
				<p>nowcorkit.com 2011, All Rights Reserved<p>
		</div>


</body>
</html>