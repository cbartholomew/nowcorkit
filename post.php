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


function loadStates(){
	
	$html = "";	
	$html .=  "<div id='state_choice' class='ui-widget' >";
	$html .=  "<table id='table_state' class='ui-corner-all' >";
	$html .=  "<tbody>";
	$html .=  "<tr>";	
	$html .=  "<td colspan='2'>";
	$html .=  "<select id='state' class='ui-corner-all ui-widget-content 'name='state'>";
	$html .=  "<option value='0' selected='selected'>Choose State...</option>";
		// load the state to id select box
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

function loadPosts() {
	// load the state to id select box
	$user_state_id = get_users_state($_SESSION["users_cork_id"]);
	$html .=  "<div id='locations' class='ui-widget' >";
	$html .=  "<table id='table_location' class='ui-corner-all' style='border-collapse:collapse'>";
	$html .=  "<thead>";
	$html .=  "<tr>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>Location Name</i></label></th>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>Address</i></label></th>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>Permission</i></label></th>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>PPS Info</i></label></th>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>Flyer</i></label></th>";
	$html .=  "<th class='ui-widget-content table_data'><label><i>Add</i></label></th>";
	$html .=  "</tr>";
	$html .=  "</thead>";
	$html .=  "<tbody>";		
	$html .=  "<tr>";
	$html .=  "<td class='ui-widget-content table_data' style='border-collapse:collapse'>";
	$html .=  "<select id='location' name='location' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
	$html .=  "<option value='0' selected='selected'>Choose Location...</option>";

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
	$html .=  "</select></td>";
	$html .=  "<td id='table_address' class='ui-widget-content table_data'></td>";
	$html .=  "<td id='table_permission' class='ui-widget-content table_data' style='text-align: center;'></td>";
	$html .=  "<td id='table_pps' class='ui-widget-content table_data' style='text-align: center;'><button value='' type='button' id='pps_button'>Show</button></td>";
	$html .=  "<td class='ui-widget-content table_data'><select id='flyers' name='flyers' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
	$html .=  "<option value='0' selected='selected'>Choose Flyer...</option>";

		// load the flyers to id select box
		$text_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "1");
		$text_image_flyer_array = GetFlyers($_SESSION["users_cork_id"], "2");
		$image_flyer_array 		= GetFlyers($_SESSION["users_cork_id"], "3");

		for ($i=0, $n=count($text_flyer_array); $i<$n;$i++)
		{
			$flyer = new Flyer(null);
			$flyer = array_pop($text_flyer_array);
			$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
		}
		
		for ($i=0, $n=count($text_image_flyer_array); $i<$n;$i++)
		{
			$flyer = new Flyer(null);
			$flyer = array_pop($text_image_flyer_array);
			$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
		}

		for ($i=0, $n=count($image_flyer_array); $i<$n;$i++)
		{
			$flyer = new Flyer(null);
			$flyer = array_pop($image_flyer_array);
			$html .=  "<option class='ui-widget-content' value='" . $flyer->users_flyer_id . "'>" . $flyer->title . "</option>";	
		}				
							
	$html .=  "</select></td>";
	$html .=  "<td class='ui-widget-content table_data'><button value='' type='button' id='add_button'>Add/Remove</button></td>";
	$html .=  "</tr>";
	$html .=  "<script>initialize_cork_flyer();</script>";
	$html .=  "</tbody>";
	$html .=  "</table>";
	$html .=  "</div>";


	return $html;
}

// $html .=  "<h3 class='ui-widget-header ui-corner-tr ui-corner-tl' style='padding:5px'>Step 3 - View Flyers' Status or Remove Your Posts' </h3>";
// $html .=  "<div id='posting' class='ui-widget'>";
// $html .=  "<table id='table_posts' style='border-collapse:collapse' class='ui-corner-all' >";
// $html .=  "<thead>";
// $html .=  "<tr>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Location Name</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Status</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Title</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Post Status</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Post Expiration</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Scout</i></label></th>";
// $html .=  "<th class='ui-widget-content table_data'><label><i>Remove</i></label></th>";
// $html .=  "</tr>";
// $html .=  "</thead>";
// $html .=  "<tbody>";	
// 
// 	$posts = get_all_posts_by_users_cork_id($_SESSION["users_cork_id"]);
// 	if (count($posts) > 0)
// 	{
// 		for ($i=0,$n=count($posts); $i<$n; $i++)
// 		{
// 			$board = new Board(null);
// 			$board = array_pop($posts);
// 			
// 			$status_image = ($board->board_status_is_displaying == 0) ? "offline.png" : "online.png";
// 		
// 			$html .=  "<tr>";
// 			$html .=  "<td id='board_title' class='ui-widget-content table_data'>" . $board->title . "</td>";
// 			$html .=  "<td id='board_status'class='ui-widget-content table_data'><img src='images/" . $status_image . "' width='50' height='50' alt='status_image'/></td>";
// 			$html .=  "<td class='ui-widget-content table_data'>" . $board->flyers->title . "</td>";
// 			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_status_desc ."</td>";
// 			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_expiration  ."</td>";
// 			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>";
// 			$html .=  "<button value='". $board->id  . "'"
// 										 . "type='button' id='" . $board->id . "_" . $board->board_post_id ."'"
// 									 . ">Scout</button></td>";
// 			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>";
// 			$html .=  "<button value='"	 . $board->flyers->users_flyers_id  . "'"
// 										 . "type='button' id='" . $board->board_post_id ."'"
// 									 	 . ">Remove</button></td>";
// 			$html .=  "</tr>";
// 			$html .=  "<script>render_remove_button(" . $board->board_post_id . "," . $board->id .");</script>";	
// 		}
// 	}
// 	else
// 	{
// 		$html .=  "<tr>";
// 		$html .=  "<td class='ui-widget-content table_data' colspan='5'>You have no flyers posted</td>";
// 		$html .=  "</tr>";
// 	}
// 	
// $html .=  "</tbody>";
// $html .=  "</table>";
// $html .=  "</div>";
// $html .=  "<div id='map_canvas' style='width:200px;height:200px;' class='ui-corner-all'></div>";
// $html .=  "<div id='pps_modal'  class='ui-corner-all'></div>";

//echo $html;
?>

<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">View Boards' Locations by State</h3>
    <? echo loadStates(); ?>
</div>
<div id='hcontainer' class='ui-helper-hidden'>
<div id="middleContainer" class="ui-widget-content ui-corner-all middleContainer">
	<h3 class="ui-widget-header ui-corner-all middleContainerHead">Posting Section</h3>
	<div id="post_section" class='ui-widget'>
		<? echo loadPosts(); ?>
	</div>
	</div>
	<div id='pps_modal'  class='ui-corner-all'></div>
</div>
<div id='map_canvas' style='width:200px;height:200px;' class='ui-corner-all'></div>





