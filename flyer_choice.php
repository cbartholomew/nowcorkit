<?
/***********************************************************************
 * flyer_choice.php
 * Author		  : Christopher Bartholomew
 * Last Updated   :  05/2/2011
 * Purpose		  :  This file will render the new flyer choice screen
 **********************************************************************/
?>

<script> 
$(function() {
	// run the currently selected effect
	var mydivs = ["text","text_image","image","container", "bottomLeftContainer"];
	var fx = new Effects({divs: mydivs});	
});	
</script>


<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Step 1: Select a Flyer Type</h3>
	<div id='text' id2="1" class="ui-widget-content ui-corner-all  flyerSelectImage">
	<img src="images/text_only.jpeg"  width="80px" height="100px" alt="Text">Text
	</div>
	<div id='text_image' id2="2" class="ui-widget-content ui-corner-all  flyerSelectImage">
	<img src="images/text_image.jpeg"  width="80px" height="100px" alt="Text_Image">Text & Image   	
	</div>
	<div id='image' id2="3" class=" ui-widget-content  ui-corner-all  flyerSelectImage">
	<img src="images/image_only.jpeg"  width="80px" height="100px" alt="Image">Image   	
	</div>
	<br>
	<div id="flyer_info" class='ui-widget-content ui-corner-all flyerDescription'>You can choose one of the three different flyer types: text, text & image, and image only.</div>           
</div>           
<br>

<script type='text/javascript'>initialize_create_flyer();</script>   



                                                