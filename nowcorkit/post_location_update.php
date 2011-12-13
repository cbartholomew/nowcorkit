<?
/***********************************************************************
 * post_location_update.php
 * Author		  : Christopher Bartholomew
 * Last Updated  :  12/08/2011
 * Purpose		 : This file, depending on the state, will render a new list of
 * locations (boards) within a specific state. It will give the user the ability to add these
 **********************************************************************/

require_once('includes/common.php');

// based on the query string, obtain the property. 
// Although the request is registered as POST, the variable will be in $_GET
$state_id = $_POST["state_id"];

echo "<table id='table_content' class='ui-corner-all table_data'>";
	echo "<tbody>";
		echo "<tr>";
			echo "<th class='ui-widget-header table_data'><label>Location Name</label></th>";
			echo "<th class='ui-widget-header table_data'><label>Address</label></th>";
			echo "<th class='ui-widget-header table_data'><label>Permission</label></th>";
			echo "<th class='ui-widget-header table_data'><label>Flyer</label></th>";
			echo "<th class='ui-widget-header table_data'><label>Add</label></th>";
		echo "</tr>";
		
			echo "<tr>";
				echo "<td class='ui-widget-content table_data'>";
				echo "<select id='location' name='location' onchange='InitializeMapsAPI(this.value);' class='ui-widget-content'>";
					 echo "<option value='0' selected='selected'>Choose Location...</option>";
					
							// if the state isn't null, then look for all the boards associated by state.
							if ($state_id != null)
							{							
								// build an object and start popping them off the array
								$boards_array = get_all_boards_by_state($state_id);
								for ($i=0, $n=count($boards_array); $i<$n;$i++)
								{
									$board = new Board(null);
									$board = array_pop($boards_array);
									echo "<option class='ui-widget-content' value='" . $board->address 					. ","  
																					 . $board->city    					. ","
																					 . $board->state_desc   			. ","
																					 . $board->zip     					. ","
																					 . $board->id     					. ","
																					 . $board->permission_type_desc 	. "'>" 
																					 . $board->title 					. "</option>";	
								}			
							}
							else
							{
								echo "<option value='31 Church Street,Cambridge,MA,02138'>Starbucks: Cambridge</option>";						
							}
		
				echo "</select></td>";
				echo "<td id=table_address class='ui-widget-content table_data'></td>";
				echo "<td id=table_permission class='ui-widget-content table_data'></td>";
				echo "<td class='ui-widget-content table_data'><select id='flyers' name='flyers' class='ui-widget-content'>";
					echo "<option value='0' selected='selected'>Choose Flyer...</option>";
						// load the flyers to id select box
						$text_flyer_array = GetFlyers($_SESSION["users_cork_id"], "1");
						$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
						$image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "3");
						
						// loads all different flyers in one box
						// loads text
						for ($i=0, $n=count($text_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($text_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}
						
						//loads text and image
						for ($i=0, $n=count($text_image_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($text_image_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}
						
						//loads images
						for ($i=0, $n=count($image_flyer_array); $i<$n;$i++)
						{
							$flyer = new Flyer(null);
							$flyer = array_pop($image_flyer_array);
							echo "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
						}					
							
					echo "</select></td>";
				echo "<td class='ui-widget-content table_data'><button onclick='PostToLocation(this.value);' value='' type='button' id='add_button'>Add/Remove</button></td>";

			echo "</tr>";
		echo "<script>LoadAddButton()</script>";
echo "</tbody>";
echo "</table>";	
echo "</form>";
echo "<div class='posting'>";

echo "<div id='column' class='row''>";
// will update the div via ajax post and users'id to track which posts he or she had posted. 
$posts = get_all_posts_by_users_cork_id($_SESSION["users_cork_id"]);

for ($i=0,$n=count($posts); $i<$n; $i++)
{
	$board = new Board(null);
	$board = array_pop($posts);

	echo "	<div class='portlet' style='width:500px'>";
	echo "		<div class='portlet-header'>Location: ". $board->title ."</div>";
	echo "		<div class='portlet-content'><b>" . $board->flyers->title 
												  . "</b> is in status <b>" 
												  . $board->flyers->post_status_desc 
												  . "</b> and will expire on <b>" 
												  . $board->flyers->post_expiration ."</b></div>";
												
	echo "		<button style='float:right' onclick='RemovePost(this.id);' value='" . $board->flyers->users_flyers_id  . "'"
	 																					  	    . "type='button' id='" . $board->board_post_id ."'"
																							    . ">Remove</button>";
	echo "		<script>LoadRemoveButton(" . $board->board_post_id . ")</script>";
	echo "	</div>";
} 

echo "<script>LaunchFlyerPortables();</script>";
echo "</div>";
?>