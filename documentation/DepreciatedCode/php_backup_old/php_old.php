<?
/*
PHP Code no longer used
*/

/*
			echo "<tr>";
				echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
				echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' onclick='toggleShuffleCheckBox();' value='off' 	
				class='ui-widget-content template_text' name='shuffle'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label id='label_interval' class='ui-helper-hidden'><i>Interval (in seconds)</i></label></td>";
				echo "<td><input id='interval' type='text' class='ui-widget-content template_text ui-helper-hidden' name='interval'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
*/
/*
echo "<table class='ui-widget' style='border-spacing:0;'>";
	echo "<tr>";
		echo "<th class='ui-widget-header ui-corner-tl'>Flyers</th>";

		echo "<th class='ui-widget-header ui-corner-tl'>Action</th>";
	echo "</tr>";
echo "<tbody>";

echo "<tr class='ui-widget-content'>";
	echo "<td class='ui-widget-content ui-corner-bl'>";
	echo "<select id='flyer_select' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
		echo "<option class='ui-widget-content' value='0'>Choose Flyer</option>";	
		// load the flyers to id select box
		$posts = get_all_posts_by_board_id($board_id);
				for ($i=0, $n=count($posts);$i<$n;$i++)
				{
				$post = array_pop($posts);
				echo "<option class='ui-widget-content' value='". $post->flyer->users_flyers_id ."' id='" . $post->flyer->board_post_id .  "'>" . 				
				$post->flyer->title . '-' . $post->flyer->post_status_desc . "</option>";
				
				}
	echo "</select>";
	echo "</td>";


echo "<td class='ui-widget-content ui-corner-br'>";
	echo "<div id='flyer_radio' style='margin:15px'>";
		echo "<input type='radio' id='flyer_preview' 	name='text' /><label for='flyer_preview' id='ltext_preview'>Preview</label>";
		echo "<input type='radio' id='flyer_approve' 	name='text' /><label for='flyer_approve' id='ltext_preview'>Approve</label>";
		echo "<input type='radio' id='flyer_remove' 	name='text' /><label for='flyer_remove'	id='ltext_remove'>Remove</label>";
	echo "</div>";
echo "</td>";

echo "</tr>";
echo "</tbody>";
echo "</table>";
echo "<script>ActivateBoardSelectableContent();</script>";
*/

/*			
			if ($board->enable_shuffle != 'on')
			{
			echo "<tr>";
				echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
			echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' class='ui-widget-content template_text' 		
			name='shuffle'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label id='label_interval' class='ui-helper-hidden'><i>Interval (in seconds)</i></label></td>";
				echo "<td><input id='interval' type='text' class='ui-widget-content template_text ui-helper-hidden' name='interval'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			} 
			else 
			{
				echo "<tr>";
					echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
				echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' onclick='toggleShuffleCheckBox();' 
				class='ui-widget-content template_text' name='shuffle' value='". $board->shuffle ."' checked='checked'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label id='label_interval'><i>Interval (in seconds)</i></label></td>";
					echo "<td><input id='interval' type='text' class='ui-widget-content template_text' name='interval' value='". $board->shuffle_interval . 
					"'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";
			
			}
*/

?>