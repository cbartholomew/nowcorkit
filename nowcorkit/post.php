<?

require_once('#!/common.php');
echo "<form id='add_post' action='add_post.php' method='POST'>";
	
	echo "<table id='table_content' class='ui-corner-all table_data ui-widget-content'>";
	echo "<tbody>";
		echo "<tr>";
		
		echo "<td><label  class='ui-corner-all' for='state_chooser'>Feed's State</label></td>";
		echo "<td><select id='state_chooser' class='ui-corner-al ui-widget-content 'name='state'>";
		echo "<option value='0' selected='selected'>Default State</option>";
				// load the state to id select box
				$state_array = GetStates();
				for ($i=0; $i<50;$i++)
				{
					$state = new State();
					$state = array_pop($state_array);
					echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
				}								
		echo "</select></td>";
		echo "<td><label id='status'></label></td>";
	echo "</table>";
	echo "</tbody>";		
	echo "<br>";
	echo "<br>";
	echo "<table id='table_content' class='ui-corner-all table_data'>";
	echo "<tbody>";
		echo "<tr>";
			echo "<th class='ui-widget-content table_data'><label>Location Name</label></th>";
			echo "<th class='ui-widget-content table_data'><label>Address</label></th>";
			echo "<th class='ui-widget-content table_data'><label>City</label></th>";
			echo "<th class='ui-widget-content table_data'><label>State</label></th>";
			echo "<th class='ui-widget-content table_data'><label>Zip</label></th>";
			echo "<th class='ui-widget-content table_data'><label>Flyer</label></th>";
			echo "<th class='ui-widget-content table_data'><label>Add</label></th>";
		echo "</tr>";
		
			echo "<tr>";
				echo "<td class='ui-widget-content table_data'>";
				echo "<select id='location' name='location' onchange='InitializeMapsAPI(this.value);' class='ui-widget-content'>";
					 echo "<option value='0' selected='selected'>Choose Location...</option>";
							// load the state to id select box
							//$location_array = GetFeedLocations();
							// for ($i=0; $i<50;$i++)
							// 						{
							// 							$state = new State();
							// 							$state = array_pop($state_array);
							// 							echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
							// 						}
						// placeholder				
						echo "<option value='31 Church Street,Cambridge,MA,02138'>Starbucks: Cambridge</option>";			
					echo "</select></td>";
				echo "<td id=table_address class='ui-widget-content table_data'></td>";
				echo "<td id=table_city class='ui-widget-content table_data'></td>";
				echo "<td id=table_state class='ui-widget-content table_data'></td>";
				echo "<td id=table_zip class='ui-widget-content table_data'></td>";
				echo "<td class='ui-widget-content table_data'><select id='flyers' name='flyers' class='ui-widget-content'>";
					echo "<option value='0' selected='selected'>Choose Flyer...</option>";
							// load the state to id select box
							//$location_array = GetFeedLocations();
							// for ($i=0; $i<50;$i++)
							// 						{
							// 							$state = new State();
							// 							$state = array_pop($state_array);
							// 							echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
							// 						}
						// placeholder				
						echo "<option value='test_value'>Test Flyer</option>";			
					echo "</select></td>";
					
				echo "<td class='ui-widget-content table_data'><button id='add_button'>Add/Remove</button></td>";
			echo "</tr>";
		echo "<script>LoadAddButton()</script>";

echo "</tbody>";
echo "</table>";	
echo "</form>";
echo "<div id='map_canvas' class='ui-corner-all'></div>";



?>