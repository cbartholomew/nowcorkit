<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
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
					
							if ($state_id != null)
							{							
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
					
				echo "<td class='ui-widget-content table_data'><button onclick='PostToLocation(this.value);' value='' type='button id='add_button'>Add/Remove</button></td>";
			echo "</tr>";
		echo "<script>LoadAddButton()</script>";
echo "</tbody>";
echo "</table>";	
echo "</form>";

?>