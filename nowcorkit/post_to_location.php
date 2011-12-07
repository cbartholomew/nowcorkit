<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

require_once('includes/common.php');


	
	// instantiate a new board object
    $board = new Board(null);
	
	// construct the object
	$board = get_specific_board($_POST["boardid"]);

	// create the posting temp object
	$board->users_flyers_id		    	= $_POST["users_flyer_id"];
	$board->post_status_id				= $_POST["post_status_id"];
	
	$board->post();

	// get all the 
	$posts = get_all_posts_by_users_cork_id($_SESSION['users_cork_id']);
		
	// return the object back as a json request
	header('Content-Type: application/json');
	echo json_encode($posts);

	

?>