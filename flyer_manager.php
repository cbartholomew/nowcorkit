<?

/***********************************************************************
 * flyer_manager.php
 * Author		  : Christopher Bartholomew
 * Last Updated  :  12/08/2011
 * Purpose		 :  This script will render the menu for people to view 
 * and modify flyers of each type
 **********************************************************************/
/*
 * Loads the user's flyers from the database
 */
require_once("includes/common.php");

/* 
 * load()
 * initalizer all the flyers inside arrays.
 */
function load()
{

	$html = "";
	$text_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "1");
	$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
	$image_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "3");
	
	$html = recurse_write_list($text_flyer_array, $text_image_flyer_array, $image_flyer_array, $html);
	
	return $html;
}

/* 
 * recurse_write_list($text_flyer_array, $text_image_flyer_array, $image_flyer_array, $html)
 * recurses through each of the different arrays building a set of li elements to write back to the page
 */
function recurse_write_list($text_flyer_array, $text_image_flyer_array, $image_flyer_array, $html)
{
	
	// base case, return html
	if(count($text_flyer_array) == 0 && count($text_image_flyer_array) == 0 && count($image_flyer_array) == 0)
	{
		return $html;
	}
	
	// text flyers
	if(count($text_flyer_array) > 0)
	{	
		$flyer = new Flyer(null);
		$flyer = array_pop($text_flyer_array);
		$html .= "<li class='ui-state-default ui-corner-all' id='t_flyer_" . $flyer->users_flyer_id . "' value='" . $flyer->users_flyer_id . "'>";
		$html .= "<span class='ui-icon ui-icon-pencil' title='Text Only' style='float:right;'></span>";
		$html .= $flyer->title . "</li>";
		$html .= "<script>$('#t_flyer_" . $flyer->users_flyer_id . "').hover(function(){ $.get('generate.php?flyerid=" . $flyer->users_flyer_id 
																		. "',function(data){ $( '#flyer_drop' ).html(data); }); }).click(function(){ $.get('generate.php?flyerid=" 
																		. $flyer->users_flyer_id . "',function(data){ $( '#flyer_drop' ).html(data); }); });</script>";
	}
	else if(count($text_image_flyer_array) > 0)
	{
		$flyer = new Flyer(null);
		$flyer = array_pop($text_image_flyer_array);	
		$html .= "<li class='ui-state-default ui-corner-all' id='ti_flyer_" . $flyer->users_flyer_id . "'  value='" . $flyer->users_flyer_id . "'>";
		$html .= "<span class='ui-icon ui-icon-image'  title='Text and Image' style='float:right;'></span>";
		$html .= "<span class='ui-icon ui-icon-pencil' title='Text Only' style='float:right;'></span>";
		$html .= $flyer->title . "</li>";
		$html .= "<script>$('#ti_flyer_" . $flyer->users_flyer_id . "').hover(function(){ $.get('generate.php?flyerid=" . $flyer->users_flyer_id 
																		. "',function(data){ $( '#flyer_drop' ).html(data); }); }).click(function(){ $.get('generate.php?flyerid=" 
																		. $flyer->users_flyer_id . "',function(data){ $( '#flyer_drop' ).html(data); }); })</script>";
	}
	else if(count($image_flyer_array) > 0)
	{
		$flyer = new Flyer(null);
		$flyer = array_pop($image_flyer_array);
		$html .= "<li class='ui-state-default ui-corner-all' id='i_flyer_" . $flyer->users_flyer_id . "'  value='" . $flyer->users_flyer_id . "'>";
		$html .= "<span class='ui-icon ui-icon-image' style='float:right;'  title='Image Only'></span>";
		$html .=  $flyer->title . "</li>";
		$html .= "<script>$('#i_flyer_" . $flyer->users_flyer_id . "').hover(function(){ $.get('generate.php?flyerid=" . $flyer->users_flyer_id . 
																		"',function(data){ $( '#flyer_drop' ).html(data); }); }).click(function(){ $.get('generate.php?flyerid=" 
																		. $flyer->users_flyer_id . "',function(data){ $( '#flyer_drop' ).html(data); }); });</script>";
	}
	else
	{
		return $html;	
	}	
	return recurse_write_list($text_flyer_array, $text_image_flyer_array, $image_flyer_array, $html);
}
?>
<script>
$(document).ready(function(){
	$(function() {
		
		var mydivs = ["form_content", "content"];
		var fx = new Effects({divs: mydivs});
		
		// render middle html box
		$.post("flyer_manager_flyer_area.php", function(middleHtml){ 			
			$("#form_content").html(middleHtml);		
			$.getScript('js/flyer.js', function(){		
								
				$("#area_edit_radio").buttonset();		
		
				$('#area_edit').click(function() {
					if ($("#p_drop").attr("type") == "0") {
						$("#p_drop").html("Please click an item first!");
					}
					var f = new Flyer({param:$("#flyer_container").attr("type")});
					f.load_editor();
				});

				$('#area_remove').click(function() {
					if ($("#p_drop").attr("type") == "0") {
						$("#p_drop").html("Please click an item first!");
					}
					var f = new Flyer({param:$("#flyer_container").attr("type")});
					f.load_remover();
				});
			});							
		});	
	});	
});
</script>

<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Created Flyers</h3>       
    <div id="manager_info" class="ui-widget-content" style="width:320;padding:5px;margin-bottom:5px;">
    Your created flyers are in the list below. To edit, preview, or remove them, click the item.
    </div>
	<ul id="flyer_list" class="ui-widget-content">
			<? 
			$html = load(); 
			echo $html;
			?>
	</ul>
</div>
<div id='modal_editor' class='ui-helper-hidden'></div>
<div id='modal_remove' class='ui-helper-hidden' title='Remove flyer?'>
<label id='ltitle'></label>
<input type='hidden' id='users_flyer_id' value=''/>
</div>


