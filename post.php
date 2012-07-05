
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

// based on the query string, obtain the property. 
// Although the request is registered as POST, the variable will be in $_GET
$user_state_id = $_POST["state_id"];

function loadStates($user_state_id){
	
	$html = "";	
	$html .=  "<div id='state_choice' class='ui-widget' >";
	$html .=  "<table id='table_state' class='ui-corner-all' >";
	$html .=  "<tbody>";
	$html .=  "<tr>";	
	$html .=  "<td colspan='2'>";
	$html .=  "<select id='state' class='ui-corner-all ui-widget-content 'name='state'>";
	$html .=  "<option value='0' selected='selected'>Choose State...</option>";
		// load the state to id select box
		
		if ($user_state_id == null)
			$user_state_id = get_users_state($_SESSION["users_cork_id"]);

		$state_array = GetStates();
		for ($i=0; $i<50;$i++)
		{
			$state = new State();
			$state = array_pop($state_array);

			if ($user_state_id == $state->id)
				$html .=  "<option selected='selected' value='" . $state->id . "'>" . $state->name . "</option>";
			else
				$html .=  "<option value='" . $state->id . "'>" . $state->name . "</option>";
		}								
	$html .=  "</select></td>";
	$html .=  "<td></td>";	
	$html .=  "<td></td>";
	$html .=  "</tbody>";
	$html .=  "</table>";	
	$html .=  "</div>";

	return $html;
		
}
function loadLocations($user_state_id)
{
	// load the state to id select box
	if ($user_state_id == null)
		$user_state_id = get_users_state($_SESSION["users_cork_id"]);
		
	$html = "";
	$html .=  "<option value='0' selected='selected'>Choose Board...</option>";
	if ($user_state_id != null)
	{							
		$boards_array = get_all_boards_by_state($user_state_id);
		for ($i=0, $n=count($boards_array); $i<$n;$i++)
		{
			$board = new Board(null);
			$board = array_pop($boards_array);
			$html .=  "<option class='ui-widget-content' value='" . $board->address 					. ","  
														 . $board->city    					. ","
														 . $board->state_desc   			. ","
														 . $board->zip     					. ","
														 . $board->id     					. ","
														 . $board->permission_type_desc 	. ","
														 . $board->pps_id					. "|"
														 . $board->pps_cashamount			. "|"
														 . $board->pps_flyerdays		    . "|"																				 
														 . $board->pps_payment				. "|" 
														 . $board->pps_count				. "'>"																
														 . $board->title 					. "</option>";	
		}			
	}
	
	return $html;
}


?>

<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
<h3 class="ui-widget-header ui-corner-all leftContainerHead">View Boards' Locations</h3>
   <? echo loadStates($user_state_id); ?>
<h3 class="ui-widget-header ui-corner-all leftContainerHead">Select Board</h3>
<select id='location' name='location' class='ui-widget-content' style='color: rgb(155, 204, 96);'>
<? echo loadLocations($user_state_id); ?>
</select>
<br>
<p class="ui-widget-content ui-corner-all" style="padding:5px">
Haven't created a board yet? Jump over to the Manage Boards menu above to get started!	
</p>
</div>
<div id='pps_modal'  class='ui-corner-all'></div>
<script>initialize_cork_flyer();</script>







