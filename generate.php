<?
/***********************************************************************
 * generate.php
 * Author	      : Christopher Bartholomew
 * Last Updated  :  12/08/2011
 * Purpose		 :  Used to generate /render a flyer on the fly based on users_flyers_id 
 * if user adds &type=json at the end, this will create a json object instead of html.
 * this is mostly used by the QR codes
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
/* echo_json($users_flyer_id)
 * return json formatted
 */
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
/* echo_html($users_flyer_id)
 * return html formatted data based on the type
 */
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
/* generate_text_flyer($flyer)
 * create flyer w/ text template
 */
function generate_text_flyer($flyer)
{
// return the object back as a json request
header('Content-Type: text/html');
	
echo "<html><body style='width:300px;height:388px'>";
echo "		<div id='header'>";
echo "			<h1>" . $flyer->title . " </h1>";
echo "		</div>	";
echo "		<div id='flyer_content'>";
echo "			<p style='text-align:justify'>" . $flyer->description . "</p>";
echo "			<table>";
echo "				<tr>";
echo "					<td><b><label>Location<label><b></td>";
echo "					<td><i>" . $flyer->location . "</i></td>";
echo "				</tr>";
echo "				<tr>";
echo "					<td><b><label>Contact Name<label><b></td>";
echo "					<td><i>" . $flyer->contact_name . "</i></td>";
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
echo " <center>";
echo "	<img style='padding: 10px 0 0 0'src='". str_replace("\\","",$flyer->qr_full_location) . "'/>";
echo " <center>";
echo "</body></html>";
}
/* generate_text_image_flyer($flyer)
 * create flyer w/ text & image flyer
 */
function generate_text_image_flyer($flyer)
{
	echo "		<div id='header'>";
	echo "			<h1>" 	. $flyer->title . " </h1>";
	echo "		</div>	";
	echo "		<div id='flyer_content'>";
	echo "			<p style='text-align:justify'>" . $flyer->description . "</p>";
	echo "			<table>";
	echo "				<tr>";
	echo "					<td><b><label>Location<label><b></td>";
	echo "					<td><i>" . $flyer->location . "</i></td>";
	echo "				</tr>";
	echo "				<tr>";
	echo "					<td><b><label>Contact Name<label><b></td>";
	echo "					<td><i>" . $flyer->contact_name . "</i></td>";
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
	echo "	<div id='image' style='padding: 10px 0 0 0'>";
	echo "  <center>";
	echo "	<img src='". str_replace("\\","",$flyer->qr_full_location) . "'/>";
	echo "	<img style='width:100px;height:100px;' src='". str_replace("\\","",$flyer->image_path) . "'/>";
	echo " </center";
	echo "  </div>";
	
}
/* generate_image_flyer($flyer)
 * create template for just image only
 */	
function generate_image_flyer($flyer)
{
	echo "	<div id='image'>";
	echo "	<img style='width:300px;height:388px' src='". str_replace("\\","",$flyer->image_path) . "'/>";
	echo "  </div>";
	
}






?>