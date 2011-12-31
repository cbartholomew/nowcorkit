<?
/***********************************************************************
 * forgot_password.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/14/2011
 * Purpose		  : based on users' email, will send temporary link to reset password.
 **********************************************************************/
	
	require_once("includes/Encryption.php");
	require_once("includes/class_objects.php");
	require_once("includes/constants.php");
	require_once("includes/DAL.php");

	session_start();
	// initalize new user
	$u = new User(null);
	// assign email to object
	$u->email = mysql_real_escape_string($_SESSION["email"]);
	$u->email = "cbartholomew@gmail.com";
	
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
	// $saved_session = '3dc5b88934a53794f4740a466c8966e1';
	// 	$is_expired = false;
	// 	// start session
	// 	session_start();
	// 	// obtain my session id
	// 	$my_session = session_id();
	// 	
	// 	// 	check if the user's the session is the same (probably should go into the insert)
	// 	// 	$is_expire = true;
	// 	// incase they need another e-mail sent to them, and if the session expired - then regengerate a new id - kill the old one
	// 	// 1. ask for session expire dttm - if dttm is past, generate new id & update the dttm. 
	// 	if ($my_session == $saved_session)
	// 	{
	// 		// is the flag expired?
	// 		if ($is_expired == true)
	// 		{	
	// 	 		session_regenerate_id();
	// 		}
	// 	}
	// 	
	// 	// 	check if the user's the session is the same based on the GET?
	// 	//  check if it has expired.
	// 	// 	$is_expire = true;
	// 	// is the flag expired? 
	// 	if ($my_session == $saved_session) { if (!$is_expired) { RenderResetPassword() } }
	// 	
	// 	
	// 	// echo out the session
	
	// // call decode to decode the base64 from the database
	// $encryption->base64_decode();
	// 
	// // call decrypt to compare 
	// $encryption->decrypt();
    //echo "base 64 Decode: " . $encryption->base64_decode . "<br>";
    //echo "decrypt: " 		. $encryption->plain_text    . "<br>";
	// print data
	// echo "Same session: " 	    . $u->session_id . "<br>";
	// 		echo "encrypt: " 			. $encryption->cipher_text . "<br>";
	// 		echo "base 64 Encode: " 	. $encryption->base64_encode . "<br>";
	// 		
	// 		echo "fpid : " . $user_session["fpid"];
	
	
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
					<label for="email">A link to reset your password has been sent to your associated e-mail address.</label>
				</fieldset>
			  </form>
			</div>
			<br>
			<div id="footer" class="ui-widget-header">
					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>
			</div>
	
		</body>
	</html>
	
	