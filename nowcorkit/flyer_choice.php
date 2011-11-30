<?
echo "<select id='flyer_select' onchange='toggleDescriptionOn(this.value);' name='flyer_select' class='ui-widget-content'>";
echo "<option value='0' selected='selected'>Select Template</option>";
echo "<option value='text'>Text Flyer</option>";
echo "<option value='text_image'>Text & Image</option>";
echo "<option value='image'>Upload Image</option>";
echo "</select>";

echo "<div id='text' name='text' class='ui-helper-hidden ui-widget-content template_div'>";
echo "<p>Post a flyer using a template, which includes a title, description, location, and contact information. This is text only.</p>";
echo "</div>";
echo "<div id='text_image' name='text_image' class='ui-helper-hidden ui-widget-content template_div'>";
echo "<p>Post a flyer using a template, which includes the same fields as text, and the ability to upload a smaller image.</p>";
echo "</div>";
echo "<div id='image' name='image' class='ui-helper-hidden ui-widget-content template_div'>";
echo "<p>Have a flyer already made? Use it! Upload a full flyer. No additional text fields are available through this option.</p>";
echo "</div>";
?>


