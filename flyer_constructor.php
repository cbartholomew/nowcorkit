<script src='js/flyer_validation_handler.js' type='text/javascript' charset='utf-8'></script>
<script src="js/image.js" type="text/javascript" charset="utf-8"></script>
<script src='js/filedrag.js'></script> 

<script> 
$(function() {	
	var mydivs = ["form_content"];
	var fx = new Effects({divs: mydivs});
});	
</script> 

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
	$html = buildTextForm();
	break;
	
	case "text_image":
    $html = buildTextImageForm();
	break;
	
	case "image":
	$html = buildImageOnlyForm();
	break;	
}    

/* buildTextForm()
 * Renders an html form used for text flyers only
 */
function buildTextForm()
{	
$html  = "";
$html .= "<form id='text_form' action='' method='POST' novalidate='novalidate'>";
$html .= "<table class='ui-widget-content ui-corner-all'>";
$html .= "<tbody>";
$html .= "<tr>";
$html .= "<td><label for='general'><i><b>General Information</b></i></label></td>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label id='ltitle' for='title'>Title</label></td>";
$html .= "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
$html .= "<td class='status'></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='description'>Description</label></td>";
$html .= "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='5' cols='250'></textarea></td>";
$html .= "<td><label for='description'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='location'>Location</label></td>";
$html .= "<td><input id='location' type='text' class='ui-widget-content template_text' name='location'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='event_date'>Event Date</label></td>";
$html .= "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact_name'>Name</label></td>";
$html .= "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact'>Contact Type</label></td>";
$html .= "<td>";
$html .= "<select id='contact' name='contact' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
$html .= "<option value='0' selected='selected'>None</option>";
$html .= "<option value='1'>Email</option>";
$html .= "<option value='2'>Phone</option>";
$html .= "<option value='3'>Social Network Link</option>";
$html .= "</select>";
$html .= "</td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td></td>";
$html .= "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='enable_qr'>Generate QR Code?</label></td>";
$html .= "<td><input id='enable_qr' type='checkbox' value='off' class='ui-widget-content template_text' name='enable_qr'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "<td>";
$html .= "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all template_button' value='submit'>";
$html .= "<span class='ui-button-text'>Create Flyer</span>";
$html .= "</button>";
$html .= "</td>";
$html .= "</tr>";
$html .= "</tbody>";
$html .= "</table>";
$html .= "</form>";	
$html .= "<br>";

return $html;
}
/* buildTextImageForm()
 * Renders a form used for Images and Text, size of 300,000 kb
 */
function buildTextImageForm()
{
$html = "";

$html .= "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
$html .= "<fieldset class='ui-widget-content ui-corner-all'>";
$html .= "<label id='lupload'><i><b>Upload Image (jpeg/jpg/png/gif)</b></i></label>";
$html .= "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
$html .= "<div>";
$html .= "<label for='fileselect'>Choose image to upload:</label>";
$html .= "<input type='file' id='fileselect' name='fileselect' uploaded=''/>";
$html .= "<div id='filedrag'>or drop image here</div>";
$html .= "</div>";
$html .= "<div id='submitbutton'>";
$html .= "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
$html .= "</div>";
$html .= "</fieldset>";
$html .= "</form>";
$html .= "<div id='progress' class='ui-corner-all'></div>";
$html .= "<br>";
$html .= "<form id='text_image_form' action='' class='ui-widget-content ui-corner-all' method='' novalidate='novalidate'>";
$html .= "<table>";
$html .= "<tbody>";
$html .= "<tr>";
$html .= "<td><label for='general'><i><b>General Information</b></i></label></td>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label id='ltitle' for='title'>Title</label></td>";
$html .= "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
$html .= "<td class='status'></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='description'>Description</label></td>";
$html .= "<td><textarea id='description' class='ui-widget-content template_text' name='description' rows='5' cols='250'></textarea></td>";
$html .= "<td><label for='description'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='location'>Location</label></td>";
$html .= "<td><input id='location' type='text' class='ui-widget-content template_text' name='location'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='event_date'>Event Date</label></td>";
$html .= "<td><input id='event_date' type='text' class='ui-widget-content template_text' name='event_date'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact'><i><b>Contact Information</b></i></label></td>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact_name'>Name</label></td>";
$html .= "<td><input id='contact_name' type='text' class='ui-widget-content template_text' name='contact_name'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='contact'>Contact Type</label></td>";
$html .= "<td>";
$html .= "<select id='contact' name='contact' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
$html .= "<option value='0' selected='selected'>None</option>";
$html .= "<option value='1'>Email</option>";
$html .= "<option value='2'>Phone</option>";
$html .= "<option value='3'>Social Network Link</option>";
$html .= "</select>";
$html .= "</td>";
$html .= "<td></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td></td>";
$html .= "<td><input id='contact_info' type='text' class='ui-widget-content template_text ui-helper-hidden' name='contact_info'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><label for='enable_qr'>Generate QR Code?</label></td>";
$html .= "<td><input id='enable_qr' type='checkbox' value='off' class='ui-widget-content template_text' name='enable_qr'></td>";
$html .= "<td><label id='status'></label></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td></td>";
$html .= "<td></td>";
$html .= "<td>";
$html .= "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all template_button' value='submit'>";
$html .= "<span class='ui-button-text'>Create Flyer</span>";
$html .= "</button>";
$html .= "</td>";
$html .= "</tr>";
$html .= "</tbody>";
$html .= "</table>";
$html .= "</form>";
$html .= "<div id='messages' class='ui-widget-content ui-corner-all' style='width:510px'>";
$html .= "<p>Status Messages</p>";
$html .= "</div>";

return $html;
}
	
/* buildImageOnlyForm()
 * Allows the uploading of images only, size of 300,000 kb
 */
function buildImageOnlyForm()
{
$html = "";

$html .= "<form id='upload' action='upload.php' method='POST' enctype='multipart/form-data'>";
$html .= "<fieldset class='ui-widget-content ui-corner-all'>";
$html .= "<label id='lupload'><i><b>Step 1: Upload Image (jpeg/jpg/png/gif)</b></i></label>";
$html .= "<input type='hidden' id='MAX_FILE_SIZE' name='MAX_FILE_SIZE' value='300000' />";
$html .= "<div>";
$html .= "<label for='fileselect'>Choose image to upload:</label>";
$html .= "<input type='file' id='fileselect' name='fileselect' uploaded=''/>";
$html .= "<div id='filedrag'>or drop image here</div>";
$html .= "</div>";
$html .= "<div id='submitbutton'>";
$html .= "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'>Upload Files</button>";
$html .= "</div>";
$html .= "</fieldset>";
$html .= "</form>";
$html .= "<div id='progress' class='ui-corner-all'></div>";
$html .= "<br>";
$html .= "<form id='image_form' action='' method='' novalidate='novalidate'>";
$html .= "<table class='ui-widget-content ui-corner-all' style='width:532px'>";
$html .= "<tbody>";
$html .= "<tr>";
$html .= "<td><label id='ltitle' for='title'>Title</label></td>";
$html .= "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
$html .= "<td class='status'></td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td><i><b>Step 2: Submit</b></i></td>";
$html .= "<td></td>";
$html .= "<td>";
$html .= "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all template_button' value='submit'>";
$html .= "<span class='ui-button-text'>Create Flyer</span>";
$html .= "</button>";
$html .= "</td>";
$html .= "</tr>";
$html .= "</tbody>";
$html .= "</table>";
$html .= "</form>";
$html .= "<div id='messages' class='ui-widget-content ui-corner-all' style='width:510px'>";
$html .= "<p>Status Messages</p>";
$html .= "</div>";

return $html;
}
?>

<div id='middleContainer' class='ui-widget-content ui-corner-all middleContainer'>
	<h3 class="ui-widget-header ui-corner-all middleContainerHead">Step 2: Fill In Information</h3>
	<? print $html; ?>    
</div>                
