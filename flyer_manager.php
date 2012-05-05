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

function load()
{

	$html = "";
	$text_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "1");
	$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
	$image_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "3");
	
	$html = recurse_write_list($text_flyer_array, $text_image_flyer_array, $image_flyer_array, $html);
	
	return $html;
}
	
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
		$html .= "<li class='ui-state-default ui-corner-all' id='t_flyer_" . $flyer->users_flyer_id . "' value='" . $flyer->users_flyer_id . "'>&nbsp;";
		$html .= "<span class='ui-icon ui-icon-pencil' title='Text Only' style='float:left;'></span>";
		$html .= "<span class='ui-icon ui-icon-circle-arrow-e' style='float:right;'></span>";
		$html .= $flyer->title . "</li>";
		$html .= "<script>$('#t_flyer_" . $flyer->users_flyer_id . "').draggable({revert:'valid', distance:100, axis:'x'})</script>";
	}
	else if(count($text_image_flyer_array) > 0)
	{
		$flyer = new Flyer(null);
		$flyer = array_pop($text_image_flyer_array);	
		$html .= "<li class='ui-state-default ui-corner-all' id='ti_flyer_" . $flyer->users_flyer_id . "'  value='" . $flyer->users_flyer_id . "'>&nbsp;";
		$html .= "<span class='ui-icon ui-icon-image'  title='Text and Image' style='float:left;'></span>";
		$html .= "<span class='ui-icon ui-icon-pencil' style='float:left;' title='Text and Image'></span>";
		$html .= "<span class='ui-icon ui-icon-circle-arrow-e' style='float:right;'></span>";
		$html .= $flyer->title . "</li>";
		$html .= "<script>$('#ti_flyer_" . $flyer->users_flyer_id . "').draggable({revert:'valid', distance:100, axis:'x'})</script>";
	}
	else if(count($image_flyer_array) > 0)
	{
		$flyer = new Flyer(null);
		$flyer = array_pop($image_flyer_array);
		$html .= "<li class='ui-state-default ui-corner-all' id='i_flyer_" . $flyer->users_flyer_id . "'  value='" . $flyer->users_flyer_id . "'>&nbsp;";
		$html .= "<span class='ui-icon ui-icon-image' style='float:left;'  title='Image Only'></span>";
		$html .= "<span class='ui-icon ui-icon-circle-arrow-e' style='float:right;'></span>";
		$html .=  $flyer->title . "</li>";
		$html .= "<script>$('#i_flyer_" . $flyer->users_flyer_id . "').draggable({revert:'valid', distance:100, axis:'x'})</script>";
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
		// render middle html box
		$.post("flyer_manager_flyer_area.php", function(middleHtml){ $("#form_content").html(middleHtml);
			// bind droppable listener, call api to generate flyer
			$("#area_edit_radio").buttonset();
						
			$( "#flyer_drop" ).droppable({
				over: function(){
					$(this).addClass('ui-state-highlight');
				},
				out: function()
				{
					$(this).removeClass('ui-state-highlight');
				},
				drop: function(event,ui) {
					$(this).removeClass('ui-state-highlight');
					var flyerid = ui.draggable.context.id.split('_')[2];
					// on drop, create call back that will apply the inner html of the flyer to the flyer area
					$.get("generate.php?flyerid=" + flyerid, function(data){ $( "#flyer_drop" ).html(data); });				
				}
			});	
			
			$('#flyer_drop').css('height',$("#flyer_list").height() + 34);
			$('#p_drop').css('height',$("#flyer_list").height() - 6);
			
		});	
	});	
});
</script>

<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Created Flyers</h3>       
    <div id="manager_info" class="ui-widget-content" style="width:320;padding:5px;margin-bottom:5px;">
    Your created flyers are in the list below. To edit, preview, or remove them, drag the item to the flyer area.
    </div>
	<div id="flyer_list" class="ui-widget-content">
			<? 
				$html = load(); 
				echo $html;
			?>
	</div>
</div>
<div id='modal_editor' class='ui-helper-hidden'></div>
<div id='modal_remove' class='ui-helper-hidden' title='Remove flyer?'>
<label id='ltitle'></label>
<input type='hidden' id='users_flyer_id' value=''/>
</div>

<?
// $html  = "";
// $html .=  "<table class='ui-widget' style='border-spacing:0;'>";
// $html .=  "<tr>";
// $html .=  "<th class='ui-widget-header ui-corner-tl'>Text Flyers</th>";
// $html .=  "<th class='ui-widget-header ui-corner-tl'>Actions</th>";
// $html .=  "</tr>";
// $html .=  "<tbody>";
// $html .=  "<tr class='ui-widget-content'>";
// $html .=  "<td class='ui-widget-content ui-corner-bl'>";
// $html .=  "<select id='text_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
// $html .=  "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
// 		// load the flyers to id select box
// 		$text_flyer_array = GetFlyers($_SESSION["users_cork_id"], "1");
// 		for ($i=0, $n=count($text_flyer_array); $i<$n;$i++)
// 		{
// 		$flyer = new Flyer(null);
// 		$flyer = array_pop($text_flyer_array);
// 		$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
// 		}
// $html .=  "</select>";
// $html .=  "</td>";
// $html .=  "<td class='ui-widget-content ui-corner-br'>";
// $html .=  "<div id='text_radio' style='margin:15px'>";
// $html .=  "<input type='radio' id='text_preview' 	name='text' /><label for='text_preview' id='ltext_preview'>Preview</label>";
// $html .=  "<input type='radio' id='text_edit' 		name='text' /><label for='text_edit' 	id='ltext_edit'>Edit</label>";
// $html .=  "<input type='radio' id='text_remove' 		name='text' /><label for='text_remove'	id='ltext_remove'>Remove</label>";
// $html .=  "</div>";
// $html .=  "</td>";
// $html .=  "</tr>";
// $html .=  "</tbody>";
// $html .=  "</table>";
// $html .=  "<br>";
// $html .=  "<table class='ui-widget' style='border-spacing:0px;'>";
// $html .=  "<tr>";
// $html .=  "<th class='ui-widget-header ui-corner-tl'>Text & Image Flyers</th>";
// $html .=  "<th class='ui-widget-header ui-corner-tr'>Actions</th>";
// $html .=  "</tr>";
// $html .=  "<tbody>";
// $html .=  "<tr class='ui-widget-content'>";
// $html .=  "<td class='ui-widget-content ui-corner-bl'>";
// $html .=  "<select id='text_image_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
// $html .=  "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
// 		// load the flyers to id select box
// 		$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
// 		for ($i=0, $n=count($text_image_flyer_array); $i<$n;$i++)
// 		{
// 		$flyer = new Flyer(null);
// 		$flyer = array_pop($text_image_flyer_array);
// 		$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
// 		}
// $html .=  "</select>";
// $html .=  "</td>";
// $html .=  "<td class='ui-widget-content ui-corner-br'>";
// $html .=  "<div id='text_image_radio' style='margin:15px'>";
// $html .=  "<input type='radio' id='text_image_preview' name='text_image' /> 	  <label for='text_image_preview'  id='ltext_image_preview'>Preview</label>";
// $html .=  "<input type='radio' id='text_image_edit' 	  name='text_image' />    <label for='text_image_edit'     id='ltext_image_edit'>Edit</label>";
// $html .=  "<input type='radio' id='text_image_remove'  name='text_image' />    <label for='text_image_remove'   id='ltext_image_remove'>Remove</label>";
// $html .=  "</div>";
// $html .=  "</td>";
// $html .=  "</tr>";
// $html .=  "</tbody>";	
// $html .=  "</table>";
// $html .=  "<br>";
// $html .=  "<table class='ui-widget' style='border-spacing:0;'>";
// $html .=  "<tr>";
// $html .=  "<th class='ui-widget-header ui-corner-tl'>Image Flyers</th>";
// $html .=  "<th class='ui-widget-header ui-corner-tr'>Actions</th>";
// $html .=  "</tr>";
// $html .=  "<tbody>";
// $html .=  "<tr class='ui-widget-content'>";
// $html .=  "<td class='ui-widget-content ui-corner-bl'>";
// $html .=  "<select id='image_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
// $html .=  "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
// 		// load the flyers to id select box
// 		$image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "3");
// 		for ($i=0, $n=count($image_flyer_array); $i<$n;$i++)
// 		{
// 		$flyer = new Flyer(null);
// 		$flyer = array_pop($image_flyer_array);
// 		$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
// 		}
// $html .=  "</select>";
// $html .=  "</td>";
// $html .=  "<td class='ui-widget-content ui-corner-br'>";
// $html .=  "<div id='image_radio' style='margin:15px'>";
// $html .=  "<input type='radio' id='image_preview' name='image' /><label for='image_preview' id='limage_preview'>Preview</label>";
// $html .=  "<input type='radio' id='image_edit' 	 name='image' /><label for='image_edit'    id='limage_edit'>Edit</label>";
// $html .=  "<input type='radio' id='image_remove'  name='image' /><label for='image_remove'  id='limage_remove'>Remove</label>";
// $html .=  "</div>";
// $html .=  "</td>";
// $html .=  "</tr>";
// $html .=  "</tbody>";
// $html .=  "</table>";
// $html .=  "<div id='modal_editor' class='ui-helper-hidden'>";
// $html .=  "</div>";
// $html .=  "<div id='modal_remove' class='ui-helper-hidden' title='Remove flyer?'>";
// $html .=  "<label id='ltitle'></label>";
// $html .=  "<input type='hidden' id='users_flyer_id' value=''/>";
// $html .=  "</div>";
// $html .=  "<script>initialize_flyer_manager();</script>";
// $html .=  "<script src='js/flyer_edit_validation_handler.js' type='text/javascript' charset='utf-8'></script>";
// 
// echo $html;

?>
