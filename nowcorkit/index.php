<?
	   			require_once('#!/common.php');
	  	   			
	  	   		if ($_SERVER['REQUEST_METHOD'] == 'POST'){ $login_correct = ValidateNormalLogin($_POST);} 
	  	   		else { $login_correct = true; }		
?>

<!DOCTYPE html>
<head>
	<!--Load CSS Libraries-->	
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">	
	<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<!--Load Javascript Libraries-->
	<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
	<script>
	//Render Submit Button
		$(function() {
			$( "input:submit", "login-form" ).button();
	});
	</script>
</head>
<html>
	<body>			
		<div id="header"  class="ui-widget-header">
			<h2>You Made It, Now Cork It!</h2>
		</div>
		<div id="login" title="login" class="ui-widget-content ui-corner-all">
			<form id="login_form" method="POST" action="index.php">	
			<h1>Please Sign In, or <a href="register.php" style='color:#2B82AD'>Register</a>.</h1>	
			<fieldset>
					<label for="email">Email</label>
					<?				
					if (!$login_correct) { echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' value='" . $_POST["email"] . "'/>";}
					else { echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' />";}
					?>
					
				<label for="password">Password</label>
					<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
					<?
					if (!$login_correct){ echo "<label id='error' style='color:red'>The username and password combination is not correct!</label><br>";}
					?>
				<button type="submit" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" value="submit">
				   <span class="ui-button-text">Sign In</span>
				</button>
				<a class="right small bold" style="line-height: 38px; height: 38px;" id="forgot_password" href="#">Forgot your password?</a>
			</fieldset>
		  </form>
		<hr class="seperator_login">
		<h1>Or Login Using...</h1>
		<div class="fb-login-button">
		<a href="oauth_facebook.php"><img src="images/button_facebook.png" width="132" height="30" alt="Button Facebook"></a>
		</div>
		</div>
		<div id="footer" class="ui-widget-header">
				<p>nowcorkit.com 2011, All Rights Reserved<p>
		</div>
</body>
</html>