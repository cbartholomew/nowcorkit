<?
/***********************************************************************
* User.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Recover
**********************************************************************/

require_once("includes/Encryption.php");
require_once("includes/class_objects.php");
require_once("includes/helpers.php");
require_once("includes/constants.php");
require_once("includes/DAL.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') { change_password($_POST); } 
else { $is_post = false; }
session_start();
// initalize new user
$u = new User(null);

// assign email to object
$url_hash = mysql_real_escape_string($_GET["id"]);

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

// expire the token
update_email_sent($user_session["fpid"]);

// decide if it's expired or found
if ($user_session["found"] == true)
{	
	if($user_session["is_done"] == false)
	{
		switch ($user_session["expired"])
		{
			case true:
				 build_error_page();
			break;
				
			case false:
				 build_password_reset($user_session);
			break;
		}
	} 
	else
	{
		//already expired because it was sent out
		build_error_page();
		
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

$html = "";

$html .=  "<!DOCTYPE html>";
$html .=  "	<head>";		
$html .=  "		<link rel='stylesheet' href='css/main.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
$html .=  "		<link rel='stylesheet' href='css/login.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
$html .=  "		<link rel='stylesheet' href='css/theme/jquery-ui-1.8.16.custom.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
$html .=  "		<!--Load Javascript Libraries-->";
$html .=  "		<script src='lib/src/jquery-1.7.min.js' type='text/javascript' charset='utf-8'></script>";
$html .=  "		<script src='lib/src/jquery-ui-1.8.16.js' type='text/javascript' charset='utf-8'></script>";
$html .=  "		<title>Password Recovery</title>";
$html .=  "	</head>";
$html .=  "	<html>";
$html .=  "		<body>";
$html .=  "			<img src='images/pin.png' width='48' height='48' style='position: absolute;left:50%;z-index: 2;' alt='Pin'>";
$html .=  "			<center><img src='images/header.png' width='480' height='200' alt='Header' class='ui-corner-all'></center>";
$html .=  "			<br>";
$html .=  "			<div id='login' title='login' class='ui-widget-content ui-corner-all'>";
$html .=  "				<form id='login_form' method='' action=''>";
$html .=  "				<h1>Token Expired or Not Found</h1>";
$html .=  "				<fieldset>";
$html .=  "				<label>The token that has led you here is either expired or not found. Please return to the <a href='forgot.php' style='color:#2B82AD'>Forgot Password</a> page and request a new email be sent.</label>";
$html .=  "				</fieldset>";
$html .=  "			  </form>";
$html .=  "			</div>";
$html .=  "			<br>";
$html .=  "			<div id='footer' class='ui-widget-header'>";
$html .=  "					<p>Created By Christopher Bartholomew<br>Cute pictures by Hannah Solhee<br>nowcorkit.com - the digital corkboard app<br><p>";
$html .=  "			</div>";
$html .=  "		</body>";
$html .=  "	</html>";

echo $html;

}

/*
 * function build_password_reset()
 *
 */
function build_password_reset($user_session)
{
	$html = "";
	
	$html .=  "<!DOCTYPE html>";
	$html .=  "	<head>";		
	$html .=  "		<link rel='stylesheet' href='css/main.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	$html .=  "		<link rel='stylesheet' href='css/login.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	$html .=  "		<link rel='stylesheet' href='css/theme/jquery-ui-1.8.16.custom.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	$html .=  "		<!--Load Javascript Libraries-->";
	$html .=  "		<script src='lib/src/jquery-1.7.min.js' type='text/javascript' charset='utf-8'></script>";
	$html .=  "		<script src='lib/src/jquery-ui-1.8.16.js' type='text/javascript' charset='utf-8'></script>";
	$html .=  "		<title>Password Recovery</title>";
	$html .=  "	</head>";
	$html .=  "	<html>";
	$html .=  "		<body>";
	$html .=  "			<img src='images/pin.png' width='48' height='48' style='position: absolute;left:50%;z-index: 2;' alt='Pin'>";
	$html .=  "			<center><img src='images/header.png' width='480' height='200' alt='Header' class='ui-corner-all'></center>";
	$html .=  "			<br>";
	$html .=  "			<div id='login' title='login' class='ui-widget-content ui-corner-all'>";
	$html .=  "				<form id='login_form' method='POST' action='recover.php'>";
	$html .=  "				<h1>Reset Password</h1>";
	$html .=  "				<fieldset>";
	$html .=  "				<input type='hidden' name='email' value='" . $user_session["email"] . "'/>";
	$html .=  "				<label id='lpassword'  name='lpassword' style='color:white'>Password</label>";
	$html .=  "				<input type='password' name='password' id='password' class='ui-widget-content ui-corner-all' />";
	$html .=  "				<label id='lpasswordconfirm'  name='lpasswordconfirm' style='color:white'>Confirm Password</label>";
	$html .=  "				<input type='password' name='password_confirm' id='password_confirm' class='ui-widget-content ui-corner-all' required='required'/>";
	$html .=  "				</fieldset>";
	$html .=  "			<br>";
	$html .=  "			<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	$html .=  "   			<span class='ui-button-text'>Reset Password</span>";
	$html .=  "			</button>";
	$html .=  "			  </form>";
	$html .=  "			</div>";
	$html .=  "			<br>";
	$html .=  "			<div id='footer' class='ui-widget-header'>";
	$html .=  "					<p>nowcorkit.com 2012 - the digital corkboard app<br><p>";
	$html .=  "			</div>";
	$html .=  "		</body>";
	$html .=  "	</html>";
}

?>