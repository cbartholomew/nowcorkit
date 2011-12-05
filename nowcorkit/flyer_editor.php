<?

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
	

	echo "<form id='text_form' action='' method='' novalidate='novalidate'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
			
			echo "<tr>";
				echo "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
				echo "<td><input type='hidden' id='flyer_id' name='flyer_id' value='". $flyer->id ."' /></td>";
				echo "<td></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td><label id='ltitle' for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "'></td>";
				echo "<td class='status'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='description'>Description</label></td>";
				echo "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'>" . str_replace("\\", "", $flyer->description) . "</textarea></td>";
				echo "<td><label for='description'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='location'>Location</label></td>";
				echo "<td><input id='location' type='text' class='ui-widget-content template_text' name='location' value=" . $flyer->location . "></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='event_date'>Event Date</label></td>";
				echo "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date' value=" . $flyer->event_date . "></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='contact_name'>Name</label></td>";
				echo "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name' value=" . $flyer->contact_name ."></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='contact'>Contact Type</label></td>";
				echo "<td>";
					echo "<select id='contact' onchange='toggleContactType(this.value)' name='contact' class='ui-widget-content'>";
					switch($flyer->contact_id)
					{						
						case "0":
							echo "<option value='0' selected='selected'>None</option>";
				    		echo "<option value='1'>Email</option>";
							echo "<option value='2'>Phone</option>";
							echo "<option value='3'>Social Network Link</option>";
						break;
						case "1":
							echo "<option value='0'>None</option>";
					    	echo "<option value='1' selected='selected'>Email</option>";
							echo "<option value='2'>Phone</option>";
							echo "<option value='3'>Social Network Link</option>";
						break;
						case "2":
							echo "<option value='0'>None</option>";
				    		echo "<option value='1'>Email</option>";
							echo "<option value='2' selected='selected'>Phone</option>";
							echo "<option value='3'>Social Network Link</option>";
						break;
						case "3":
							echo "<option value='0'>None</option>";
				    		echo "<option value='1'>Email</option>";
							echo "<option value='2'>Phone</option>";
							echo "<option value='3' selected='selected' >Social Network Link</option>";
						break;					
					}
					echo "</select>";
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td></td>";
			
			if ($flyer->contact_id != 0)
			{
				echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text' value='". $flyer->contact_info . "' name='contact_info'></td>";
			}
			else
			{
				echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
			}

			echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td><label for='enable_qr'>Generate QR Code?</label></td>";
			if ($flyer->enable_qr == "on") 
			{
				echo "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' checked='checked' value=". $flyer->enable_qr ."></td>";
			} 
			else
			{
				echo "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' value=". $flyer->enable_qr ."></td>";				
			}
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
						
			echo "<tr>";
				echo "<td><i><b>Step 2: Submit</b></i></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
				echo  	"<span class='ui-button-text'>Update</span>";
				echo "</button>";
				echo "</td>";
			echo "</tr>";		
		echo "</tbody>";
	echo "</table>";
	echo "</form>";	
	echo "<br>";
	echo "<script>loadDatePicker();</script>";
	echo "<script src='js/flyer_edit_validation_handler.js' type='text/javascript' charset='utf-8'></script>";

}

/*
 *	editTextForm($users_flyer_id)
 *
 */
function editTextImageForm($users_flyer_id)
{
		// pull the flyer's data
		$flyer = GetFullFlyer($users_flyer_id);
		
		if ($flyer->flyer_error_id !=0) {showerror($flyer->flyer_message);}

		echo "<form id='text_image_form' action='' method='' novalidate='novalidate'>";
		echo "<table class='ui-widget-content ui-corner-all'>";
			echo "<tbody>";

				echo "<tr>";
					echo "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
					echo "<td><input type='hidden' id='flyer_id' name='flyer_id' value='". $flyer->id ."' /></td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label id='ltitle' for='title'>Title</label></td>";
					echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "'></td>";
					echo "<td class='status'></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='description'>Description</label></td>";
					echo "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'>" . str_replace("\\", "", $flyer->description) . "</textarea></td>";
					echo "<td><label for='description'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='location'>Location</label></td>";
					echo "<td><input id='location' type='text' class='ui-widget-content template_text' name='location' value=" . $flyer->location . "></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='event_date'>Event Date</label></td>";
					echo "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date' value=" . $flyer->event_date . "></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact_name'>Name</label></td>";
					echo "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name' value=" . $flyer->contact_name ."></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact'>Contact Type</label></td>";
					echo "<td>";
						echo "<select id='contact' onchange='toggleContactType(this.value)' name='contact' class='ui-widget-content'>";
						switch($flyer->contact_id)
						{						
							case "0":
								echo "<option value='0' selected='selected'>None</option>";
					    		echo "<option value='1'>Email</option>";
								echo "<option value='2'>Phone</option>";
								echo "<option value='3'>Social Network Link</option>";
							break;
							case "1":
								echo "<option value='0'>None</option>";
						    	echo "<option value='1' selected='selected'>Email</option>";
								echo "<option value='2'>Phone</option>";
								echo "<option value='3'>Social Network Link</option>";
							break;
							case "2":
								echo "<option value='0'>None</option>";
					    		echo "<option value='1'>Email</option>";
								echo "<option value='2' selected='selected'>Phone</option>";
								echo "<option value='3'>Social Network Link</option>";
							break;
							case "3":
								echo "<option value='0'>None</option>";
					    		echo "<option value='1'>Email</option>";
								echo "<option value='2'>Phone</option>";
								echo "<option value='3' selected='selected' >Social Network Link</option>";
							break;					
						}
						echo "</select>";
					echo "</td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td></td>";

				if ($flyer->contact_id != 0)
				{
					echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text' value='". $flyer->contact_info . "' name='contact_info'></td>";
				}
				else
				{
					echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
				}

				echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td><label for='enable_qr'>Generate QR Code?</label></td>";
				if ($flyer->enable_qr == "on") 
				{
					echo "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' checked='checked' value=". $flyer->enable_qr ."></td>";
				} 
				else
				{
					echo "<td><input id='enable_qr' type='checkbox' class='ui-widget-content template_text' name='enable_qr' value=". $flyer->enable_qr ."></td>";				
				}
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><i><b>Step 2: Submit</b></i></td>";
					echo "<td></td>";
					echo "<td>";
					echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
					echo  	"<span class='ui-button-text'>Update</span>";
					echo "</button>";
					echo "</td>";
				echo "</tr>";		
			echo "</tbody>";
		echo "</table>";
		echo "</form>";	
		echo "<br>";
		echo "<script>loadDatePicker();</script>";
		echo "<script src='js/flyer_edit_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
	}


/*
 *	editImageOnlyForm($users_flyer_id)
 *
 */
function editImageOnlyForm($users_flyer_id)
{
	// pull the flyer's data
	$flyer = GetFullFlyer($users_flyer_id);	
		
	if ($flyer->flyer_error_id !=0) {showerror($flyer->flyer_message);}
	
	echo "<form id='image_form' action='' method='' novalidate='novalidate'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
			echo "<tr>";
				echo "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
				echo "<td><input type='hidden' id='flyer_id' name='flyer_id' value='" . $flyer->id . "' /></td>";
				echo "<td></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label id='ltitle' for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $flyer->title . "' ></td>";
				echo "<td class='status'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><i><b>Step 2: Submit</b></i></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
				echo  	"<span class='ui-button-text'>Update</span>";
				echo "</button>";
				echo "</td>";
			echo "</tr>";
		echo "</tbody>";
	echo "</table>";
	echo "</form>";
	echo "<script src='js/flyer_edit_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
}


?>