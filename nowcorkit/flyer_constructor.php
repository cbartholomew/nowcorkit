<?
/***********************************************************************
 * flyer_constructor.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/08/2011
 * Purpose		  : Based on the template sent form the post request, we will
 * render the specific text form.
 **********************************************************************/
	
$template = $_POST["template"];

/*
 * use case statement to determine the form type
 */
switch($template)
{
	case "text":
	buildTextForm();
	break;
	
	case "text_image":
    buildTextImageForm();
	break;
	
	case "image":
	buildImageOnlyForm();
	break;	
}
/* buildTextForm()
 * Renders an html form used for text flyers only
 */
function buildTextForm()
{	
	
	echo "<form id='text_form' action='' method='' novalidate='novalidate'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
		
			echo "<tr>";
				echo "<td><label for='general'><i><b>Step 1: General Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td><label id='ltitle' for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
				echo "<td class='status'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='description'>Description</label></td>";
				echo "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'></textarea></td>";
				echo "<td><label for='description'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='location'>Location</label></td>";
				echo "<td><input id='location' type='text' class='ui-widget-content template_text' name='location'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='event_date'>Event Date</label></td>";
				echo "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='contact_name'>Name</label></td>";
				echo "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='contact'>Contact Type</label></td>";
				echo "<td>";
					echo "<select id='contact' onchange='toggleContactType(this.value)' name='contact' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
					echo "<option value='0' selected='selected'>None</option>";
				    echo "<option value='1'>Email</option>";
					echo "<option value='2'>Phone</option>";
					echo "<option value='3'>Social Network Link</option>";
					echo "</select>";
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td></td>";
			echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
			echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='enable_qr'>Generate QR Code?</label></td>";
				echo "<td><input id='enable_qr' type='checkbox' value='off' onclick='toggleCheckBox();' class='ui-widget-content template_text' name='enable_qr'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
						
			echo "<tr>";
				echo "<td><i><b>Step 2: Submit</b></i></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
				echo  	"<span class='ui-button-text'>Create Flyer</span>";
				echo "</button>";
				echo "</td>";
			echo "</tr>";
			
		echo "</tbody>";
	echo "</table>";
	echo "</form>";	
	echo "<br>";
	
	echo "<script>function toggleCheckBox(){ if ($('#enable_qr').val() == 'off'){ $('#enable_qr').val('on');} else { $('#enable_qr').val('off'); } }</script>";
	echo "<script src='js/flyer_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
	//echo "<script src='js/flyer_validation_handler.min.js' type='text/javascript' charset='utf-8'></script>";
	echo "<script src='js/filedrag.js' type='text/javascript' charset='utf-8'></script>";
	//echo "<script src='js/filedrag.min.js' type='text/javascript' charset='utf-8'></script>";
	echo "<script>loadDatePicker();</script>";
}
/* buildTextImageForm()
 * Renders a form used for Images and Text, size of 300,000 kb
 */
function buildTextImageForm()
{

	echo "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
	echo "<fieldset class='ui-widget-content ui-corner-all'>";
	echo "<label id='lupload'><i><b>Step 1: Upload Image (jpeg/jpg/png/gif)</b></i></label>";
	echo "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
	echo "<div>";
		echo "<label for='fileselect'>Choose image to upload:</label>";
		echo "<input type='file' id='fileselect' name='fileselect'/>";
		echo "<div id='filedrag'>or drop image here</div>";
	echo "</div>";
	echo "<div id='submitbutton'>";
		echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
	echo "</div>";
	echo "</fieldset>";
	echo "</form>";

	
	echo "<div id='progress' class='ui-corner-all'></div>";
	echo "<br>";
		echo "<form id='text_image_form' action='' method='' novalidate='novalidate'>";
		echo "<table class='ui-widget-content ui-corner-all'>";
			echo "<tbody>";

				echo "<tr>";
					echo "<td><label for='general'><i><b>Step 2: General Information</b></i></label></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label id='ltitle' for='title'>Title</label></td>";
					echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
					echo "<td class='status'></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='description'>Description</label></td>";
					echo "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='10' cols='30'></textarea></td>";
					echo "<td><label for='description'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='location'>Location</label></td>";
					echo "<td><input id='location' type='text' class='ui-widget-content template_text' name='location'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='event_date'>Event Date</label></td>";
					echo "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
					echo "<td></td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact_name'>Name</label></td>";
					echo "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='contact'>Contact Type</label></td>";
					echo "<td>";
						echo "<select id='contact' onchange='toggleContactType(this.value)' name='contact' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
						echo "<option value='0' selected='selected'>None</option>";
					    echo "<option value='1'>Email</option>";
						echo "<option value='2'>Phone</option>";
						echo "<option value='3'>Social Network Link</option>";
						echo "</select>";
					echo "</td>";
					echo "<td></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td></td>";
				echo "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label for='enable_qr'>Generate QR Code?</label></td>";
					echo "<td><input id='enable_qr' type='checkbox' value='off' onclick='toggleCheckBox();' class='ui-widget-content template_text' name='enable_qr'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><i><b>Step 3: Submit</b></i></td>";
					echo "<td></td>";
					echo "<td>";
					echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
					echo  	"<span class='ui-button-text'>Create Flyer</span>";
					echo "</button>";
					echo "</td>";
				echo "</tr>";

			echo "</tbody>";
		echo "</table>";
		echo "</form>";
		echo "<div id='messages' class='ui-widget-content ui-corner-all'>";
		echo "<script>function toggleCheckBox(){ if ($('#enable_qr').val() == 'off'){ $('#enable_qr').val('on');} else { $('#enable_qr').val('off'); }}</script>";
		//echo "<script src='js/flyer_validation_handler.min.js' type='text/javascript' charset='utf-8'></script>";
		//echo "<script src='js/filedrag.min.js' type='text/javascript' charset='utf-8'></script>";
		echo "<script src='js/flyer_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
		echo "<script src='js/filedrag.js' type='text/javascript' charset='utf-8'></script>";
		
		echo "<script>loadDatePicker();</script>";
}
	
/* buildImageOnlyForm()
 * Allows the uploading of images only, size of 300,000 kb
 */
function buildImageOnlyForm()
{
	echo "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
	echo "<fieldset class='ui-widget-content ui-corner-all'>";
	echo "<label id='lupload'><i><b>Step 1: Upload Image (jpeg/jpg/png/gif)</b></i></label>";
	echo "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
	echo "<div>";
		echo "<label for='fileselect'>Choose image to upload:</label>";
		echo "<input type='file' id='fileselect' name='fileselect'/>";
		echo "<div id='filedrag'>or drop image here</div>";
	echo "</div>";
	echo "<div id='submitbutton'>";
		echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
	echo "</div>";
	echo "</fieldset>";
	echo "</form>";

	echo "<div id='progress' class='ui-corner-all'></div>";
	echo "<br>";
	echo "<form id='image_form' action='' method='' novalidate='novalidate'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
			echo "<tr>";
				echo "<td><label id='ltitle' for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
				echo "<td class='status'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><i><b>Step 2: Submit</b></i></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
				echo  	"<span class='ui-button-text'>Create Flyer</span>";
				echo "</button>";
				echo "</td>";
			echo "</tr>";
		echo "</tbody>";
	echo "</table>";
	echo "</form>";
	echo "<div id='messages' class='ui-widget-content ui-corner-all'>";
	echo "<p>Status Messages</p>";
	echo "</div>";
	echo "<script src='js/flyer_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
	echo "<script src='js/filedrag.js'></script>";
	//echo "<script src='js/flyer_validation_handler.min.js' type='text/javascript' charset='utf-8'></script>";
	//echo "<script src='js/filedrag.min.js'></script>";
}	

?>