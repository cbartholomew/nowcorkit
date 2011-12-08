<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

	require_once("includes/constants.php");
	require_once("includes/DAL.php");
	require_once("includes/class_objects.php");
	require_once("includes/helpers.php");


// populate types from get request
$users_flyer_id = mysql_real_escape_string($_GET["flyerid"]);
$type 			= $_GET["type"]; 

// switch to figure out what kind of return type. Raw HTML or JSON.
switch ($type)
{
	case "json":
		echo_json($users_flyer_id);
	break;
	
	default:
		echo_html($users_flyer_id);
	break;
	
}

function echo_json($users_flyer_id)
{
	// create new null object
	$flyer = new Flyer(null);
	
	// populate the object with the flyer contents
	$flyer = GetFullFlyer($users_flyer_id);

	// associate the correct flyer id	
	$flyer->users_flyer_id = $users_flyer_id;
	
	// return the object back as a json request
	header('Content-Type: application/json');
	echo json_encode($flyer);
}

function echo_html($users_flyer_id)
{
	// create new null object
	$flyer = new Flyer(null);
	
	// populate the object with the flyer contents
	$flyer = GetFullFlyer($users_flyer_id);

	// associate the correct flyer id	
	$flyer->users_flyer_id = $users_flyer_id;
	
	switch($flyer->type)
	{
		case "text":
		generate_text_flyer($flyer);
		break;
		
		case "text_image":
		generate_text_image_flyer($flyer);
		break;
		
		case "image":
		generate_image_flyer($flyer);
		break;
		
	}

	
}

function generate_text_flyer($flyer)
{
// return the object back as a json request
header('Content-Type: text/html');
	
echo "<html><body>";
echo "		<div id='header' style='background-color: white'>";
echo "			<h1>" . $flyer->title . " </h1>";
echo "		</div>	";
echo "		<div id='content' style='background-color: white'>";
echo "			<p style='text-align:justify'>" . $flyer->description . "</p>";
echo "			<table>";
echo "				<tr>";
echo "					<td><b><label>Location<label><b></td>";
echo "					<td><i>" . $flyer->location . "</i></td>";
echo "				</tr>";
echo "				<tr>";
echo "					<td><b><label>Contact Name<label><b></td>";
echo "					<td><i>" . $flyer->contact_table . "</i></td>";
echo "				</tr>";
echo "				<tr>";
echo "					<td><b><label>Contact Information<label><b></td>";
echo "					<td><i>" . $flyer->contact_info . "</i></td>";
echo "				</tr>";
echo "				<tr>";
echo "					<td><b><label>Event Date<label><b></td>";
echo "					<td><i>" . $flyer->event_date . "</i></td>";
echo "				</tr>";
echo "			</table>";
echo "		</div>";
echo "	<div id='qrcode' style='float:left' style='background-color: white'>";
echo "	<img src='". str_replace("\\","",$flyer->qr_full_location) . "'/>";
echo "	</div>";
echo "</body></html>";
}

function generate_text_image_flyer($flyer)
{
	echo "<html><body>";
	echo "		<div id='header'>";
	echo "			<h1>" 	. $flyer->title . " </h1>";
	echo "		</div>	";
	echo "		<div id='content'>";
	echo "			<p style='text-align:justify'>" . $flyer->description . "</p>";
	echo "			<table>";
	echo "				<tr>";
	echo "					<td><b><label>Location<label><b></td>";
	echo "					<td><i>" . $flyer->location . "</i></td>";
	echo "				</tr>";
	echo "				<tr>";
	echo "					<td><b><label>Contact Name<label><b></td>";
	echo "					<td><i>" . $flyer->contact_table . "</i></td>";
	echo "				</tr>";
	echo "				<tr>";
	echo "					<td><b><label>Contact Information<label><b></td>";
	echo "					<td><i>" . $flyer->contact_info . "</i></td>";
	echo "				</tr>";
	echo "				<tr>";
	echo "					<td><b><label>Event Date<label><b></td>";
	echo "					<td><i>" . $flyer->event_date . "</i></td>";
	echo "				</tr>";
	echo "			</table>";
	echo "		</div>";
	echo "	<div id='image'>";
	echo "	<img src='". str_replace("\\","",$flyer->image_path) . "'/>";
	echo "  </div>";
	echo "	<div id='qrcode' style='float:left'>";
	echo "	<img src='". str_replace("\\","",$flyer->qr_full_location) . "'/>";
	echo "	</div>";
	echo "	<div id='footer'></div>";
	echo "</body></html>";
	
}
	
function generate_image_flyer($flyer)
{
	echo "<html><body>";
	echo "	<div id='image'>";
	echo "	<img style='width:300;height:388' src='". str_replace("\\","",$flyer->image_path) . "'/>";
	echo "  </div>";
	echo "	<div id='footer'></div>";
	echo "</body></html>";
	
	
	
}






?>