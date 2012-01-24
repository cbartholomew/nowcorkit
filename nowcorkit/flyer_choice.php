<?
/***********************************************************************
 * flyer_choice.php
 * Author		  : Christopher Bartholomew
 * Last Updated   :  12/08/2011
 * Purpose		  :  This file will render the a dropdown box for a user to choose a form
 **********************************************************************/
?>



<select id='flyer_select' name='flyer_select' class='ui-widget-content'>
	<option value='0' selected='selected'>Select Template</option>
	<option value='1'>Text Flyer</option>
	<option value='2'>Text & Image</option>
	<option value='3'>Upload Image</option>
</select>

<div id='text' name='text' class='ui-helper-hidden ui-widget-content template_div'>
<p>Post a flyer using a template, which includes a title, description, location, and contact information. This is text only.</p>
</div>
<div id='text_image' name='text_image' class='ui-helper-hidden ui-widget-content template_div'>
<p>Post a flyer using a template, which includes the same fields as text, and the ability to upload a smaller image.</p>
</div>
<div id='image' name='image' class='ui-helper-hidden ui-widget-content template_div'>
<p>Have a flyer already made? Use it! Upload a full flyer. No additional text fields are available through this option.</p>
</div>
<script type='text/javascript'>initialize_create_flyer();</script>


