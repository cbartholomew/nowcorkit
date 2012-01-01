<?
/***********************************************************************
 * post.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/08/2011
 * Purpose		  : This code will render the posting screen. 
 * this includes the google maps api, and ajax refresh on locations based on
 * the state that was chosen from the database
 **********************************************************************/

require_once('includes/common.php');

echo "<h3 class='ui-widget-header ui-corner-tr ui-corner-tl' style='padding:5px'>Step 1 - View Boards' Locations by State</h3>";
echo "<div id='state_choice' class='ui-widget' >";
	echo "<table id='table_state' class='ui-corner-all' >";
	echo "<tbody>";
		echo "<tr>";	
		echo "<td colspan='2'>";
		echo "<select id='state' onchange='UpdateLocationsByAjaxPost(this.value);' class='ui-corner-all ui-widget-content 'name='state'>";
		echo "<option value='0' selected='selected'>Choose State...</option>";
				// load the state to id select box
				$user_state_id = get_users_state($_SESSION["users_cork_id"]);
				
				$state_array = GetStates();
				for ($i=0; $i<50;$i++)
				{
					$state = new State();
					$state = array_pop($state_array);
					
					if ($user_state_id == $state->id)
					{
						echo "<option selected='selected' value='" . $state->id . "'>" . $state->name . "</option>";
							
					} 
					else
					{
						echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
					}
				}								
		echo "</select></td>";
		echo "<td></td>";	
		echo "<td></td>";
		echo "</tbody>";
	echo "</table>";
echo "</div>";

echo "<h3 class='ui-widget-header ui-corner-tr ui-corner-tl' style='padding:5px'>Step 2 - Choose a Location to Post a Flyer</h3>";
echo "<div id='locations' class='ui-widget'>";
	echo "<table id='table_location' class='ui-corner-all' style='border-collapse:collapse'>";
	echo "<thead>";
		echo "<tr>";
			echo "<th class='ui-widget-content table_data'><label><i>Location Name</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Address</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Permission</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>PPS Info</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Flyer</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Add</i></label></th>";
		echo "</tr>";
	echo "</thead>";
	echo "<tbody>";		
			echo "<tr>";
				echo "<td class='ui-widget-content table_data' style='border-collapse:collapse'>";
				echo "<select id='location' name='location' onchange='InitializeMapsAPI(this.value);' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
					 echo "<option value='0' selected='selected'>Choose Location...</option>";
					
							if ($user_state_id != null)
							{							
								$boards_array = get_all_boards_by_state($user_state_id);
								for ($i=0, $n=count($boards_array); $i<$n;$i++)
								{
									$board = new Board(null);
									$board = array_pop($boards_array);
									echo "<option class='ui-widget-content' value='" . $board->address 					. ","  
																					 . $board->city    					. ","
																					 . $board->state_desc   			. ","
																					 . $board->zip     					. ","
																					 . $board->id     					. ","
																					 . $board->permission_type_desc 	. ","
																					 . $board->pps_id					. "|"
																					 . $board->pps_cashamount			. "|"
																					 . $board->pps_flyerdays		    . "|"
																					 . $board->pps_payment				."'>" 																
																					 . $board->title 					. "</option>";	
								}			
							}
				echo "</select></td>";
				echo "<td id='table_address' class='ui-widget-content table_data'></td>";
				echo "<td id='table_permission' class='ui-widget-content table_data' style='text-align: center;'></td>";
				echo "<td id='table_pps' class='ui-widget-content table_data' style='text-align: center;'><button onclick='LoadModalPPSInformation();' value='' type='button' id='pps_button'>Show</button></td>";
				echo "<td class='ui-widget-content table_data'><select id='flyers' name='flyers' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
					echo "<option value='0' selected='selected'>Choose Flyer...</option>";
						// load the flyers to id select box
						$text_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "1");
						$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
						$image_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "3");
						
						for ($i=0, $n=count($text_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($text_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}
												
						for ($i=0, $n=count($text_image_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($text_image_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}
						
						for ($i=0, $n=count($image_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($image_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}											
					echo "</select></td>";
				echo "<td class='ui-widget-content table_data'><button onclick='PostToLocation(this.value);' value='' type='button'
					  id='add_button'>Add/Remove</button></td>";
			echo "</tr>";
		echo "<script>LoadAddButton()</script>";
	echo "</tbody>";
	echo "</table>";
echo "</div>";

echo "<h3 class='ui-widget-header ui-corner-tr ui-corner-tl' style='padding:5px'>Step 3 - View Flyers' Status or Remove Your Posts' </h3>";
echo "<div id='posting' class='ui-widget'>";
	echo "<table id='table_posts' style='border-collapse:collapse' class='ui-corner-all' >";
	echo "<thead>";
		echo "<tr>";
			echo "<th class='ui-widget-content table_data'><label><i>Location Name</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Title</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Post Status</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Post Expiration</i></label></th>";
			echo "<th class='ui-widget-content table_data'><label><i>Remove</i></label></th>";
		echo "</tr>";
	echo "</thead>";
	echo "<tbody>";	
	$posts = get_all_posts_by_users_cork_id($_SESSION["users_cork_id"]);
	
	if (count($posts) > 0)
	{
		for ($i=0,$n=count($posts); $i<$n; $i++)
		{
			$board = new Board(null);
			$board = array_pop($posts);

			echo "<tr>";
			echo "<td class='ui-widget-content table_data'>" . $board->title . "</td>";
			echo "<td class='ui-widget-content table_data'>" . $board->flyers->title . "</td>";
			echo "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_status_desc ."</td>";
			echo "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_expiration  ."</td>";
			echo "<td class='ui-widget-content table_data' style='text-align: center;'>";
			echo "<button onclick='RemovePost(this.id);' value='". $board->flyers->users_flyers_id  . "'"
			 													 . "type='button' id='" . $board->board_post_id ."'"
																 . ">Remove</button></td>";
			echo "</tr>";
			echo "<script>LoadRemoveButton(" . $board->board_post_id . ")</script>";	
		}
	}
	else
	{
		echo "<tr>";
		echo "<td class='ui-widget-content table_data' colspan='5'>You have no flyers posted</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
echo "</div>";
echo "<div id='map_canvas' class='ui-corner-all'></div>";
echo "<div id='pps_modal'  class='ui-corner-all'></div>";
?>