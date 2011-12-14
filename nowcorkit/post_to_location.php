<?
/***********************************************************************
 * post_to_location.php
 * Author		  : Christopher Bartholomew
 * Last Updated   :  12/08/2011
 * Purpose		  : This script will find a specific board based on the id
 * and then it will, depending on the post type, will post the specific status
 * that the flyer should be in: public, pending, etc.
 **********************************************************************/

require_once('includes/common.php');


	
	// instantiate a new board object
    $board = new Board(null);
	
	// construct the object
	$board = get_specific_board($_POST["boardid"]);

	// create the posting temp object
	$board->users_flyers_id		    	= $_POST["users_flyer_id"];
	$board->post_status_id				= $_POST["post_status_id"];
	$board->cork_id						= $_SESSION["users_cork_id"];
	
	// post the object
	$board->post();

	// get all the 
	$posts = get_all_posts_by_users_cork_id($_SESSION['users_cork_id']);
		
	// return the object back as a json request
	header('Content-Type: application/json');
	echo json_encode($posts);

	

?>