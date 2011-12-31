<?
/***********************************************************************
 * forgot_password.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/14/2011
 * Purpose		  : based on users' email, will send temporary link to reset password.
 **********************************************************************/
	
	require_once("includes/Encryption.php");
	require_once("includes/helpers.php");
	require_once("includes/class_objects.php");
	require_once("includes/constants.php");
	require_once("includes/DAL.php");
	require_once("includes/PHPMailer/class.phpmailer.php");
	
	session_start();
	// initalize new user
	$u = new User(null);
	// assign email to object
	$u->email = mysql_real_escape_string($_SESSION["email"]);
	
	// create user_session array
	$user_session = array();
	// obtain my session id
	$u->session_id = session_id();
	// check if the session is expired
	$user_session = $u->check_session_expired();
	

	if (!$user_session["found"])
	{
			// encryption constructor takes a object with two keys, plain and cipher.
			$in = array();		
			$in["plain"]  = $u->session_id;
			$in["cipher"] = "";

			// create new encryption object base on the input object
			$encryption = new Encryption($in);

			// call encrypt on plain_text
			$encryption->encrypt();

			// encode it into base64 to store into the db
			$encryption->base64_encode();
			
			// insert the new session
			$u->insert_new_session($encryption->base64_encode);
			
	}
	else
	{
		// user is found, so we'll regenerate a new session id and update that and its expiration
		session_regenerate_id();				
		
		// user is found, so we'll just update the table with a new expire date
		$u->session_id = session_id();
		
		// encryption constructor takes a object with two keys, plain and cipher.
		$in = array();		
		$in["plain"]  = $u->session_id;
		$in["cipher"] = "";
		
		// create new encryption object base on the input object
		$encryption = new Encryption($in);
		
		// call encrypt on plain_text
		$encryption->encrypt();
		
		// encode it into base64 to store into the db
		$encryption->base64_encode();
								
		// update database w/ new session
		$u->update_existing_session($user_session["fpid"], $encryption->base64_encode);	
	}
	
	$generated_link = generate_forgot_password($u->email);
	
	// instantiate mailer
	$mail = new PHPMailer();
	
	// switch to smtp
	$mail->IsSMTP();
	
	// authentication enabled
	$mail->SMTPAuth = true; 
	
	// go daddy servers
	$mail->Host = "smtpout.secureserver.net";
	$mail->Port = 3535; 
	
	// username and password
	$mail->Username = "administrator@nowcorkit.com";  
	$mail->Password = "N0wC0rk1t!";
	
	// set From:
	$mail->SetFrom("noreply@nowcorkit.com");
	
	// set To:
	$mail->AddAddress($u->email);
	
	// set Subject:
	$mail->Subject = "Password Recovery Link";
	
	// set body
	$mail->Body = "<html><body><center><h1>NowCorkIt.com</h1><h2>Password Recovery Link</h2></center><p>
				   You are receiving this email because you have requested that your password be reset.
				   This link will expire in 10 minutes. If this is a mistake, please e-mail administrator@nowcorkit.com.
				   To reset your password, please click: <a href='" . $generated_link . "'>here</a>
				   </p></body></html>";
	
	// set alternative body, in case user's mail client doesn't support HTML
	$mail->AltBody = "NowCorkIt.com Password Recovery Link \n You are receiving this email because you have requested that your password be reset. \n
	   			      This link will expire in 10 minutes. If this is a mistake, please e-mail administrator@nowcorkit.com. \n
	   				  To reset your password, please go here:" . $generated_link;
	
	// send mail
	if ($mail->Send() === false)
	    die($mail->ErrorInfo . "\n");
	 
	
?>	

	<!DOCTYPE html>
	<head>
		
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<!--Load Javascript Libraries-->
		<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
		<title>Password Recovery</title>
	</head>
	<html>
		<body>
			<img src="images/pin.png" width="48" height="48" style="position: absolute;left:50%;z-index: 2;" alt="Pin">
			<center><img src="images/header.png" width="480" height="200" alt="Header" class="ui-corner-all"></center>
			<br>
			<div id="login" title="login" class="ui-widget-content ui-corner-all">
				<form id="login_form" method="" action="">	
				<h1>Recovery Email Sent</h1>	
				<fieldset>
					<label for="email">A link to reset your password has been sent to your associated e-mail address. If an e-mail is not sent, please return to 			the <a href='forgot.php' style='color:#2B82AD'>Forgot Password Page</a> to resubmit your request.</label>
				</fieldset>
			  </form>
			</div>
			<br>
			<div id="footer" class="ui-widget-header">
					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>
			</div>
	
		</body>
	</html>
	
	