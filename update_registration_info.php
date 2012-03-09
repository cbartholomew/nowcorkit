<?	
	require_once("includes/common.php");
	$didchange = update_user_info($_POST);
	
?>	
	<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<!--Load Javascript Libraries-->
		<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		
			function redirect()
			{
				setTimeout(function(){window.location = "index.php";},5000);
			}
		
		</script>
		<title>Preference Update Completed</title>
	</head>
	<html>
		<body onload="redirect();">
			<img src="images/pin.png" width="48" height="48" style="position: absolute;left:50%;z-index: 2;" alt="Pin">
			<center><img src="images/header.png" width="480" height="200" alt="Header" class="ui-corner-all"></center>
			<br>
			<div id="login" title="login"class="ui-widget-content ui-corner-all">
				<form id="login_form" method="" action="">	
				<h1>User Update Completed</h1>	
				<fieldset>
					<p>You will now be redirected to the board screen, or please click<a href="login.php" style='color:#2B82AD'>Login</a>.</p>
				</fieldset>
			  </form>
			</div>
			<br>
			<div id="footer" class="ui-widget-header">
					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>
			</div>

		</body>
	</html>