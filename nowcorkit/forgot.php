<?

/***********************************************************************
 * forgot.php
 * Author		 : Christopher Bartholomew
 * Last Updated  : 12/08/2011
 * Purpose		 : The login menu uses server side validation (boooo)
 * to login users into the database. I would have rather used jquery, but 
 * I didn't because of the registration & login used different methods than
 * when I had orginally had designed for the facbeook login.
 **********************************************************************/

	require_once('includes/helpers.php');	   			
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{ 
		$email_correct = LookupEmail($_POST["email"]);
		if ($email_correct == 'false')
		{ 
			session_start();
			$_SESSION["email"] = $_POST["email"];
			redirect("forgot_password.php");
		}		
	} 
	else { $email_correct = 'false'; }		
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
	<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
	<script>
	//Render Submit Button
	$(function() {
			$( "input:submit", "login-form" ).button();
	});
	</script>
</head>
<html>
	<body>		
		<img src="images/pin.png" width="48" height="48" style="position: absolute;left:725px;z-index: 2;" alt="Pin2">
		<img id='logo' class="ui-corner-all" src="images/logo.png" width="480" height="180" style="display:block;z-index:-1;margin-left:auto;margin-right:auto;"alt="Logo">
				<br>
		<div id="login" title="login" class="ui-widget-content ui-corner-all">
			<form id="login_form" method="POST" action="forgot.php">	
			<h1>Password Retrieval, or <a href="login.php" style='color:#2B82AD'>Login</a>.</h1>	
			<fieldset>
				<label for="email">Email</label>
				<?				
				if ($email_correct == 'true') 
				{ 
				echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' value='" . $_POST["email"] . "'/>
					  <label style='color:red'>Your e-mail was not found!</label>";}
				else { echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' required/>";}
				?>
				<button type="submit" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" value="submit">
				<span class="ui-button-text">Email Me</span>
				</button>
			</fieldset>
		  </form>
		</div>
		<br>
		<div id="footer" class="ui-widget-header">
		<p>nowcorkit.com 2012 - the digital corkboard app<br><p>
		</div>
</body>
</html>