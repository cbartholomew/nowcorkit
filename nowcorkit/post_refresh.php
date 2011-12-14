<?
/***********************************************************************
 * post_refresh.php
 * Author		  :  Christopher Bartholomew
 * Last Updated   :  12/08/2011
 * Purpose		  :  this script will refresh the portables that show what the user has posted to
 **********************************************************************/

require_once("includes/common.php");

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

?>