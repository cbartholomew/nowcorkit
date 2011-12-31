<?
/***********************************************************************
* User.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Recover
**********************************************************************/

require_once("includes/Encryption.php");
require_once("includes/class_objects.php");
require_once("includes/constants.php");
require_once("includes/DAL.php");
//UPDATE forgot_password SET  `forgot_password_session_expire` = DATE_ADD(  `forgot_password_session_expire` , INTERVAL -10 MINUTE )
if ($_SERVER['REQUEST_METHOD'] == 'POST') { ChangeUserPassword($_POST); } 
else { $is_post = false; }
session_start();
// initalize new user
$u = new User(null);

// assign email to object
$url_hash = mysql_real_escape_string($_GET["id"]);
//$url_hash = mysql_real_escape_string($_GET["id"]);

// create user_session array
$user_session = array();

//left off here buggy still
// create input contrusctor object
$in = array();		
$in["plain"]  = "";
$in["cipher"] = $url_hash;

// create new encryption object base on the input object
$encryption = new Encryption($in);
$encryption->base64_decode();
$encryption->cipher_text = $encryption->base64_decode;

// decrypt the url
$encryption->decrypt();

// obtain my session id
$u->session_id = $encryption->plain_text;

// check if the session is expired
$user_session = $u->check_session_expired_by_url();

// decide if it's expired or found
if ($user_session["found"] == true)
{	
	switch ($user_session["expired"])
	{
		case true:
			 build_error_page();
		break;
				
		case false:
			 build_password_reset();
		break;
	}
}
else 
{	
		// build error page
		build_error_page();
}


/*
 * function build_error_page()
 *
 */
function build_error_page()
{
	
echo "<!DOCTYPE html>";
echo "	<head>";		
echo "		<link rel='stylesheet' href='css/main.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
echo "		<link rel='stylesheet' href='css/login.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
echo "		<link rel='stylesheet' href='css/theme/jquery-ui-1.8.16.custom.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
echo "		<!--Load Javascript Libraries-->";
echo "		<script src='lib/src/jquery-1.7.min.js' type='text/javascript' charset='utf-8'></script>";
echo "		<script src='lib/src/jquery-ui-1.8.16.js' type='text/javascript' charset='utf-8'></script>";
echo "		<title>Password Recovery</title>";
echo "	</head>";
echo "	<html>";
echo "		<body>";
echo "			<img src='images/pin.png' width='48' height='48' style='position: absolute;left:50%;z-index: 2;' alt='Pin'>";
echo "			<center><img src='images/header.png' width='480' height='200' alt='Header' class='ui-corner-all'></center>";
echo "			<br>";
echo "			<div id='login' title='login' class='ui-widget-content ui-corner-all'>";
echo "				<form id='login_form' method='' action=''>";
echo "				<h1>Token Expired or Not Found</h1>";
echo "				<fieldset>";
echo "					<label>The token that has led you here is either expired or not found. Please return to the <a href='forgot.php' style='color:#2B82AD'>Forgot Password</a> page and request a new email be sent.</label>";
echo "				</fieldset>";
echo "			  </form>";
echo "			</div>";
echo "			<br>";
echo "			<div id='footer' class='ui-widget-header'>";
echo "					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>";
echo "			</div>";
echo "		</body>";
echo "	</html>";

}

/*
 * function build_password_reset()
 *
 */
function build_password_reset()
{
	echo "<!DOCTYPE html>";
	echo "	<head>";		
	echo "		<link rel='stylesheet' href='css/main.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	echo "		<link rel='stylesheet' href='css/login.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	echo "		<link rel='stylesheet' href='css/theme/jquery-ui-1.8.16.custom.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	echo "		<!--Load Javascript Libraries-->";
	echo "		<script src='lib/src/jquery-1.7.min.js' type='text/javascript' charset='utf-8'></script>";
	echo "		<script src='lib/src/jquery-ui-1.8.16.js' type='text/javascript' charset='utf-8'></script>";
	echo "		<title>Password Recovery</title>";
	echo "	</head>";
	echo "	<html>";
	echo "		<body>";
	echo "			<img src='images/pin.png' width='48' height='48' style='position: absolute;left:50%;z-index: 2;' alt='Pin'>";
	echo "			<center><img src='images/header.png' width='480' height='200' alt='Header' class='ui-corner-all'></center>";
	echo "			<br>";
	echo "			<div id='login' title='login' class='ui-widget-content ui-corner-all'>";
	echo "				<form id='login_form' method='POST' action='recover.php'>";
	echo "				<h1>Reset Password</h1>";
	echo "				<fieldset>";
	echo "				<label id='lpassword'  name='lpassword' style='color:white'>Password</label>";
	echo "				<input type='password' name='password' id='password' class='ui-widget-content ui-corner-all' />";
	echo "				<label id='lpasswordconfirm'  name='lpasswordconfirm' style='color:white'>Confirm Password</label>";
	echo "				<input type='password' name='password_confirm' id='password_confirm' class='ui-widget-content ui-corner-all' required='required'/>";
	echo "				</fieldset>";
	echo "			<br>";
	echo "			<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo "   			<span class='ui-button-text'>Reset Password</span>";
	echo "			</button>";
	echo "			  </form>";
	echo "			</div>";
	echo "			<br>";
	echo "			<div id='footer' class='ui-widget-header'>";
	echo "					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>";
	echo "			</div>";
	echo "		</body>";
	echo "	</html>";
}

?>