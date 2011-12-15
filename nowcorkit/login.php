<?

/***********************************************************************
 * login.php
 * Author		 : Christopher Bartholomew
 * Last Updated  : 12/08/2011
 * Purpose		 : The login menu uses server side validation (boooo)
 * to login users into the database. I would have rather used jquery, but 
 * I didn't because of the registration & login used different methods than
 * when I had orginally had designed for the facbeook login.
 **********************************************************************/

	require_once('includes/common.php');
	  	   			
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
	<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
	<script>
	//Render Submit Button
		$(function() {
			$( "input:submit", "login-form" ).button();
	});
	</script>
	
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-27673016-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>
<html>
	<body>		
		<img src="images/pin.png" width="48" height="48" style="position: absolute;left:725px;z-index: 2;" alt="Pin2">
		<img src="images/pin.png" width="48" height="48" style="position: absolute;left:250px;z-index: 2;" alt="Pin">
		<img id='logo' class="ui-corner-all" src="images/logo.png" width="480" height="250" style="display:block;position: absolute;top:20px;z-index: -1;margin-left:auto;margin-right:auto;-webkit-transform: rotate(-25deg);-moz-transform:rotate(-25deg);" alt="Logo">
		<br>
		<div id="login" title="login" class="ui-widget-content ui-corner-all">
			<form id="login_form" method="POST" action="login.php">	
			<h1>Please Sign In, or <a href="register.php" style='color:#2B82AD'>Register</a>.</h1>	
			<fieldset>
					<label for="email">Email</label>
					<?				
					if (!$login_correct) { echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' value='" . $_POST["email"] . "'/>";}
					else { echo "<input type='text' name='email' id='email' class='text ui-widget-content ui-corner-all' required/>";}
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
		</div>
		<br>
		<div id="footer" class="ui-widget-header">
				<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>
		</div>
</body>
</html>