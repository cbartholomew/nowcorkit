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
				echo "<td id='table_pps' class='ui-widget-content table_data' style='text-align: center;'><button onclick='onclick='LoadModalPPSInformation();'' value='' type='button' id='pps_button'>Show</button></td>";
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

?>