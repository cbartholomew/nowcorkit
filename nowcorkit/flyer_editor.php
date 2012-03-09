<script src='js/flyer_edit_validation_handler.js' type='text/javascript' charset='utf-8'></script>
<?
/***********************************************************************
* flyer_editor.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: This code will render each of the forms, which need to be edited
**********************************************************************/
	
require_once("includes/common.php");

$template 			= $_POST["template"];
$users_flyer_id		= $_POST["users_flyer_id"];

switch($template)
{
	case "text":
		editTextForm($users_flyer_id);
	break;
	
	case "text_image":
	  	editTextImageForm($users_flyer_id);
	break;
	
	case "image":
	  	editImageOnlyForm($users_flyer_id);
	break;	
}

/* editTextForm($users_flyer_id)
 * 
 */
function editTextForm($users_flyer_id)
{	
// pull the flyer's data
$flyer = GetFullFlyer($users_flyer_id);
	
if ($flyer->flyer_error_id !=0) {showerror($flyer->flyer_message);}
	
$html = "";
$html .=  "<form id='text_form' action='' method='' novalidate='novalidate'>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
$html .=  "<td><input type='hidden' id='flyer_id' name='flyer_id' value='". $flyer->id ."' /></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label id='ltitle' for='title'>Title</label></td>";
$html .=  "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "'></td>";
$html .=  "<td class='status'></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='description'>Description</label></td>";
$html .=  "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'>" . str_replace("\\", "", $flyer->description) . "</textarea></td>";
$html .=  "<td><label for='description'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='location'>Location</label></td>";
$html .=  "<td><input id='location' type='text' class='ui-widget-content template_text' name='location' value='" . $flyer->location . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='event_date'>Event Date</label></td>";
$html .=  "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date' value=" . $flyer->event_date . "></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact_name'>Name</label></td>";
$html .=  "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name' value='" . $flyer->contact_name ."'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact'>Contact Type</label></td>";
$html .=  "<td>";
	$html .=  "<select id='contact' name='contact' class='ui-widget-content'>";
	switch($flyer->contact_id)
	{						
		case "0":
			$html .=  "<option value='0' selected='selected'>None</option>";
    		$html .=  "<option value='1'>Email</option>";
			$html .=  "<option value='2'>Phone</option>";
			$html .=  "<option value='3'>Social Network Link</option>";
		break;
		case "1":
			$html .=  "<option value='0'>None</option>";
	    	$html .=  "<option value='1' selected='selected'>Email</option>";
			$html .=  "<option value='2'>Phone</option>";
			$html .=  "<option value='3'>Social Network Link</option>";
		break;
		case "2":
			$html .=  "<option value='0'>None</option>";
    		$html .=  "<option value='1'>Email</option>";
			$html .=  "<option value='2' selected='selected'>Phone</option>";
			$html .=  "<option value='3'>Social Network Link</option>";
		break;
		case "3":
			$html .=  "<option value='0'>None</option>";
    		$html .=  "<option value='1'>Email</option>";
			$html .=  "<option value='2'>Phone</option>";
			$html .=  "<option value='3' selected='selected' >Social Network Link</option>";
		break;					
	}
	$html .=  "</select>";
$html .=  "</td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td></td>";

if ($flyer->contact_id != 0)
{
$html .=  "<td><input id='contact_info' type='text' class='ui-widget-content template_text' value='". $flyer->contact_info . "' name='contact_info'></td>";
}
else
{
$html .=  "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
}

$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='enable_qr'>Generate QR Code?</label></td>";
if ($flyer->enable_qr == "on") 
{
$html .=  "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' checked='checked' value=". $flyer->enable_qr ."></td>";
} 
else
{
$html .=  "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' value=". $flyer->enable_qr ."></td>";				
}
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";	
$html .=  "<tr>";
$html .=  "<td><i><b>Step 2: Submit</b></i></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=   	"<span class='ui-button-text'>Update</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";		
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";	
$html .=  "<br>";

echo $html;

}

/*
 *	editTextForm($users_flyer_id)
 *
 */
function editTextImageForm($users_flyer_id)
{
$html = "";
// pull the flyer's data
$flyer = GetFullFlyer($users_flyer_id);

if ($flyer->flyer_error_id !=0) {showerror($flyer->flyer_message);}

$html .=  "<form id='text_image_form' action='' method='' novalidate='novalidate'>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
$html .=  "<td><input type='hidden' id='flyer_id' name='flyer_id' value='". $flyer->id ."' /></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label id='ltitle' for='title'>Title</label></td>";
$html .=  "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "'></td>";
$html .=  "<td class='status'></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='description'>Description</label></td>";
$html .=  "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'>" . str_replace("\\", "", $flyer->description) . "</textarea></td>";
$html .=  "<td><label for='description'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='location'>Location</label></td>";
$html .=  "<td><input id='location' type='text' class='ui-widget-content template_text' name='location' value='" . $flyer->location . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='event_date'>Event Date</label></td>";
$html .=  "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date' value=" . $flyer->event_date . "></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact_name'>Name</label></td>";
$html .=  "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name' value='" . $flyer->contact_name ."'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='contact'>Contact Type</label></td>";
$html .=  "<td>";
$html .=  "<select id='contact' name='contact' class='ui-widget-content'>";
switch($flyer->contact_id)
{						
	case "0":
		$html .=  "<option value='0' selected='selected'>None</option>";
   		$html .=  "<option value='1'>Email</option>";
		$html .=  "<option value='2'>Phone</option>";
		$html .=  "<option value='3'>Social Network Link</option>";
	break;
	case "1":
		$html .=  "<option value='0'>None</option>";
    	$html .=  "<option value='1' selected='selected'>Email</option>";
		$html .=  "<option value='2'>Phone</option>";
		$html .=  "<option value='3'>Social Network Link</option>";
	break;
	case "2":
		$html .=  "<option value='0'>None</option>";
   		$html .=  "<option value='1'>Email</option>";
		$html .=  "<option value='2' selected='selected'>Phone</option>";
		$html .=  "<option value='3'>Social Network Link</option>";
	break;
	case "3":
		$html .=  "<option value='0'>None</option>";
   		$html .=  "<option value='1'>Email</option>";
		$html .=  "<option value='2'>Phone</option>";
		$html .=  "<option value='3' selected='selected' >Social Network Link</option>";
	break;					
}
$html .=  "</select>";
$html .=  "</td>";
$html .=  "<td></td>";
$html .=  "</tr>";

$html .=  "<tr>";
$html .=  "<td></td>";

if ($flyer->contact_id != 0)
{
$html .=  "<td><input id='contact_info' type='text' class='ui-widget-content template_text' value='". $flyer->contact_info . "' name='contact_info'></td>";
}
else
{
$html .=  "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
}

$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";

$html .=  "<tr>";
$html .=  "<td><label for='enable_qr'>Generate QR Code?</label></td>";
if ($flyer->enable_qr == "on") 
{
$html .=  "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' checked='checked' value='". $flyer->enable_qr ."'></td>";
} 
else
{
$html .=  "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' value='". $flyer->enable_qr ."></td>";				
}
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><i><b>Step 2: Submit</b></i></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=   "<span class='ui-button-text'>Update</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";		
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";	
$html .=  "<br>";

echo $html;
}


/*
 *	editImageOnlyForm($users_flyer_id)
 *
 */
function editImageOnlyForm($users_flyer_id)
{
$html = "";
// pull the flyer's data
$flyer = GetFullFlyer($users_flyer_id);	

if ($flyer->flyer_error_id !=0) {showerror($flyer->flyer_message);}

$html .=  "<form id='image_form' action='' method='' novalidate='novalidate'>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
$html .=  "<td><input type='hidden' id='flyer_id' name='flyer_id' value='" . $flyer->id . "' /></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label id='ltitle' for='title'>Title</label></td>";
$html .=  "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "' ></td>";
$html .=  "<td class='status'></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><i><b>Step 2: Submit</b></i></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=   "<span class='ui-button-text'>Update</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";

echo $html;
}


?>