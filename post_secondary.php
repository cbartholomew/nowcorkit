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

function loadPosts() {

		$html = "";
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
		
	return $html;
}

function loadPostedFlyers()
{
	
$html .=  "<div id='posting' class='ui-widget '>";
$html .=  "<table id='table_posts' style='border-collapse:collapse' class='ui-corner-all' >";
$html .=  "<thead>";
$html .=  "<tr>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Location Name</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Board Status</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Title</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Post Status</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Post Expiration</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Scout</i></label></th>";
$html .=  "<th class='ui-widget-content table_data'><label><i>Remove</i></label></th>";
$html .=  "</tr>";
$html .=  "</thead>";
$html .=  "<tbody>";	

	$posts = get_all_posts_by_users_cork_id($_SESSION["users_cork_id"]);
	if (count($posts) > 0)
	{
		for ($i=0,$n=count($posts); $i<$n; $i++)
		{
			$board = new Board(null);
			$board = array_pop($posts);
			
			$status_image = ($board->board_status_is_displaying == 0) ? "offline.png" : "online.png";
		
			$html .=  "<tr>";
			$html .=  "<td id='board_title' class='ui-widget-content table_data'>" . $board->title . "</td>";
			$html .=  "<td id='board_status'class='ui-widget-content table_data'><img src='images/" . $status_image . "' width='50' height='50' alt='red means offline'/></td>";
			$html .=  "<td class='ui-widget-content table_data'>" . $board->flyers->title . "</td>";
			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_status_desc ."</td>";
			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>" . $board->flyers->post_expiration  ."</td>";
			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>";
			$html .=  "<button value='". $board->id  . "'"
										 . "type='button' id='" . $board->id . "_" . $board->board_post_id ."'"
									 . ">Scout</button></td>";
			$html .=  "<td class='ui-widget-content table_data' style='text-align: center;'>";
			$html .=  "<button value='"	 . $board->flyers->users_flyers_id  . "'"
										 . "type='button' id='" . $board->board_post_id ."'"
									 	 . ">Remove</button></td>";
			$html .=  "</tr>";
			$html .=  "<script>render_remove_button(" . $board->board_post_id . "," . $board->id .");</script>";	
		}
	}
	else
	{
		$html .=  "<tr>";
		$html .=  "<td class='ui-widget-content table_data' colspan='5'>You have no flyers posted</td>";
		$html .=  "</tr>";
	}
	
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</div>";

return $html;

	
}

?>

<div id="middleContainer" class="ui-widget-content ui-corner-all middleContainer">
	<h3 class="ui-widget-header ui-corner-all middleContainerHead">Cork Flyer to Board</h3>
	<div id="post_section" class='ui-widget'>
	<div id='locations' class='ui-widget'>
	<table id='table_location' class='ui-corner-all' style='border-collapse:collapse'>
	<thead>
	<tr>
	<th class='ui-widget-content table_data'><label><i>Address</i></label></th>
	<th class='ui-widget-content table_data'><label><i>Permission</i></label></th>
	<th class='ui-widget-content table_data'><label><i>PPS Info</i></label></th>
	<th class='ui-widget-content table_data'><label><i>Flyer</i></label></th>
	<th class='ui-widget-content table_data'><label><i>Add</i></label></th>
	</tr>
	</thead>
	<tbody>	
	<tr>
	<td id='table_address' class='ui-widget-content table_data'><div id='map_canvas' class='ui-corner-all'></div><br><div id='map_address' class='ui-widget ui-corner-all' style='padding:5px'></div></td>
	<td id='table_permission' class='ui-widget-content table_data' style='text-align: center;'></td>
	<td id='table_pps' class='ui-widget-content table_data' style='text-align: center;'><button value='' type='button' id='pps_button'>Show</button></td>
	<td class='ui-widget-content table_data'>
	<select id='flyers' name='flyers' class='ui-widget-content' style='color: rgb(155, 204, 96);'>
		<? echo loadPosts(); ?>
	</select>
	</td>
	<td class='ui-widget-content table_data'><button value='' type='button' id='add_button'>Add/Remove</button></td>
	</tr>
	</tbody>
	</table>
	</div>
	<br>
	<h3 class="ui-widget-header ui-corner-all middleContainerHead">Corked Flyers</h3>
	<? echo loadPostedFlyers(); ?>
	</div>
</div>