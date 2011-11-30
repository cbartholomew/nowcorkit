<?

$template = $_POST["template"];

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
				echo "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='name'>Name</label></td>";
				echo "<td><input id='name' type='text' class='ui-widget-content template_text' name='name'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='contact'>Contact Type</label></td>";
				echo "<td>";
					echo "<select id='contact' onchange='toggleContactType(this.value)' class='ui-widget-content'>";
					echo "<option value='none' selected='selected'>None</option>";
				    echo "<option value='email'>Email</option>";
					echo "<option value='phone'>Phone</option>";
					echo "</select>";
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td></td>";
			echo "<td><input id='type' type='text' class='ui-widget-content template_text ui-helper-hidden' name='type'></td>";
			echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label for='qrcode'>Generate QR Code?</label></td>";
				echo "<td><input id='qrcode' type='checkbox' class='ui-widget-content template_text' name='qrcode'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			
			echo "<tr>";
					echo "<td></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' 'value='submit'>";
				echo  	"<span class='ui-button-text'>Create Flyer</span>";
				echo "</button>";
				echo "</td>";
			echo "</tr>";
			
		echo "</tbody>";
	echo "</table>";
	echo "</form>";
	echo "<script src='js/validation.flyer.js' type='text/javascript' charset='utf-8'></script>";

}

function buildTextImageForm()
{
	echo "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
	echo "<fieldset class='ui-widget-content ui-corner-all'>";
	echo "<label id='lupload'><i><b>Step 1: Upload Image</b></i></label>";
	echo "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
	echo "<div>";
		echo "<label for='fileselect'>Files to upload:</label>";
		echo "<input type='file' id='fileselect' name='fileselect[]' multiple='multiple'/>";
		echo "<div id='filedrag'>or drop files here</div>";
	echo "</div>";
	echo "<div id='submitbutton'>";
		echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
	echo "</div>";
	echo "</fieldset>";
	echo "</form>";
	echo "</div>";
	echo "<br>";
	echo "<form id='text_form' action='create_text_flyer.php' method='pointer'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
		
			echo "<tr>";
				echo "<td><label id='general'><i><b>Step 2: General Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td>Title</td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>Description</td>";
				echo "<td><textarea id='description'  	class='ui-widget-content template_text' name='description' rows='5' cols='30'></textarea></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>Location</td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td><label id='contact'><i><b>Contact Information</b></i></label></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>Name</td>";
				echo "<td><input id='name' type='text' class='ui-widget-content template_text' name='name'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>Contact Type</td>";
				echo "<td>";
					echo "<select id='contact' onchange='toggleContactType(this.value)' class='ui-widget-content'>";
					echo "<option value='none' selected='selected'>None</option>";
				    echo "<option value='email'>Email</option>";
					echo "<option value='phone'>Phone</option>";
					echo "</select>";
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td></td>";
			echo "<td><input id='type' type='text' class='ui-widget-content template_text ui-helper-hidden' name='type'></td>";
			echo "<td></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>Generate QR Code?</td>";
				echo "<td><input id='qrcode' type='checkbox' class='ui-widget-content template_text' name='qrcode'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
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
	echo "<div>";
	echo "<div id='progress' class='ui-corner-all'></div>";
	echo "<div id='messages' class='ui-widget-content ui-corner-all'>";
	echo "<p>Status Messages</p>";
	echo "</div>";
	echo "<script src='js/filedrag.js'></script>";
	echo "<script src='js/validation.flyer.js' type='text/javascript' charset='utf-8'></script>";
}	


function buildImageOnlyForm()
{
	echo "<div>";
	echo "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
	echo "<fieldset class='ui-widget-content ui-corner-all'>";
	echo "<label id='lupload'><i><b>Step 1: Upload Image</b></i></label>";
	echo "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
	echo "<div>";
		echo "<label for='fileselect'>Files to upload:</label>";
		echo "<input type='file' id='fileselect' name='fileselect[]' multiple='multiple'/>";
		echo "<div id='filedrag'>or drop files here</div>";
	echo "</div>";
	echo "<div id='submitbutton'>";
		echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
	echo "</div>";
	echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' style='float:right;' value='submit'>";
	echo  	"<span class='ui-button-text'>Create Flyer</span>";
	echo "</button>";
	echo "</fieldset>";
	echo "</form>";
	echo "</div>";
	echo "<div id='progress' class='ui-corner-all'></div>";
	echo "<div id='messages' class='ui-widget-content ui-corner-all'>";
	echo "<p>Status Messages</p>";
	echo "</div>";
	echo "<script src='js/filedrag.js'></script>";
	
}	

?>