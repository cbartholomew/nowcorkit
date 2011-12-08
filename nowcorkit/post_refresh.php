<?
	/***********************************************************************
	 * XXX.php
	 * Author		  : Christopher Bartholomew
	 * Last Updated  : 
	 * Purpose		  : 
	 **********************************************************************/

require_once("includes/common.php");

echo "<div id='column' class='row'>";

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
	 																					  	    . "type='button' id='" 
																								. $board->board_post_id ."'"
																							    . ">Remove</button>";
	echo "		<script>LoadRemoveButton(" . $board->board_post_id . ")</script>";
	echo "	</div>";
} 

echo "<script>LaunchFlyerPortables();</script>";

?>