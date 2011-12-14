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

	echo "<table class='ui-widget' style='border-spacing:0;'>";
		echo "<tr>";
			echo "<th class='ui-widget-header ui-corner-tl'>Text Flyers</th>";
			echo "<th class='ui-widget-header ui-corner-tl'>Actions</th>";
		echo "</tr>";
	echo "<tbody>";
	
	echo "<tr class='ui-widget-content'>";
		echo "<td class='ui-widget-content ui-corner-bl'>";
		echo "<select id='text_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
			echo "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
			// load the flyers to id select box
			$text_flyer_array = GetFlyers($_SESSION["users_cork_id"], "1");
			for ($i=0, $n=count($text_flyer_array); $i<$n;$i++)
			{
				$flyer = new Flyer(null);
				$flyer = array_pop($text_flyer_array);
				echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
			}
		echo "</select>";
		echo "</td>";

	echo "<td class='ui-widget-content ui-corner-br'>";
		echo "<div id='text_radio' style='margin:15px'>";
			echo "<input type='radio' id='text_preview' 	name='text' /><label for='text_preview' id='ltext_preview'>Preview</label>";
			echo "<input type='radio' id='text_edit' 		name='text' /><label for='text_edit' 	id='ltext_edit'>Edit</label>";
			echo "<input type='radio' id='text_remove' 		name='text' /><label for='text_remove'	id='ltext_remove'>Remove</label>";
		echo "</div>";
	echo "</td>";
	
	
	echo "</tr>";
	echo "</tbody>";
	echo "</table>";
	echo "<br>";

	echo "<table class='ui-widget' style='border-spacing:0px;'>";
		echo "<tr>";
			echo "<th class='ui-widget-header ui-corner-tl'>Text & Image Flyers</th>";
			echo "<th class='ui-widget-header ui-corner-tr'>Actions</th>";
		echo "</tr>";
	echo "<tbody>";
	
	echo "<tr class='ui-widget-content'>";
	echo "<td class='ui-widget-content ui-corner-bl'>";
		echo "<select id='text_image_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
			echo "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
			// load the flyers to id select box
			$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
			for ($i=0, $n=count($text_image_flyer_array); $i<$n;$i++)
			{
				$flyer = new Flyer(null);
				$flyer = array_pop($text_image_flyer_array);
				echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
			}
		echo "</select>";
	echo "</td>";
	
	echo "<td class='ui-widget-content ui-corner-br'>";
		echo "<div id='text_image_radio' style='margin:15px'>";
			echo "<input type='radio' id='text_image_preview' name='text_image' /> 	  <label for='text_image_preview'  id='ltext_image_preview'>Preview</label>";
			echo "<input type='radio' id='text_image_edit' 	  name='text_image' />    <label for='text_image_edit'     id='ltext_image_edit'>Edit</label>";
			echo "<input type='radio' id='text_image_remove'  name='text_image' />    <label for='text_image_remove'   id='ltext_image_remove'>Remove</label>";
		echo "</div>";
	echo "</td>";
	
	echo "</tr>";
	echo "</tbody>";	
	echo "</table>";
	echo "<br>";

	echo "<table class='ui-widget' style='border-spacing:0;'>";
		echo "<tr>";
			echo "<th class='ui-widget-header ui-corner-tl'>Image Flyers</th>";
			echo "<th class='ui-widget-header ui-corner-tr'>Actions</th>";
		echo "</tr>";
	echo "<tbody>";
	
	echo "<tr class='ui-widget-content'>";
		echo "<td class='ui-widget-content ui-corner-bl'>";
		echo "<select id='image_flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
		echo "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
		// load the flyers to id select box
		$image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "3");
		for ($i=0, $n=count($image_flyer_array); $i<$n;$i++)
		{
			$flyer = new Flyer(null);
			$flyer = array_pop($image_flyer_array);
			echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";
		}
		echo "</select>";
		echo "</td>";
	
	echo "<td class='ui-widget-content ui-corner-br'>";
		echo "<div id='image_radio' style='margin:15px'>";
			echo "<input type='radio' id='image_preview' name='image' /><label for='image_preview' id='limage_preview'>Preview</label>";
			echo "<input type='radio' id='image_edit' 	 name='image' /><label for='image_edit'    id='limage_edit'>Edit</label>";
			echo "<input type='radio' id='image_remove'  name='image' /><label for='image_remove'  id='limage_remove'>Remove</label>";
		echo "</div>";
	echo "</td>";
	
	echo "</tr>";
	echo "</tbody>";
	echo "</table>";
	
	echo "<div id='modal_editor' class='ui-helper-hidden'>";
	echo "</div>";
	echo "<div id='modal_remove' class='ui-helper-hidden' title='Remove flyer?'>";
		echo "<p><span class='ui-icon ui-icon-alert'></span>"; 
		echo "Once committed, this flyer cannot be recovered.</p>";
		echo "<b>Remove? </b>";
		echo "<br>";
		echo "<label id='ltitle'></label>";
		echo "<input type='hidden' id='users_flyer_id' value=''/>";
	echo "</div>";

	echo "<script>ActivateSelectableContent();</script>";

?>