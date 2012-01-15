<?
/***********************************************************************
 * pps_check.php
 * Author		  : Christopher Bartholomew
 * Last Updated   :  1/15/2012
 * Purpose		  : This script will return a json object for PPS to determine if the user can add a pps or remove a flyer
 **********************************************************************/

require_once("includes/common.php");

	// create an empty board object
	$board = new Board(null);
		
	// get the current values for the board object
	$board->board_post_id = $_POST["board_post_id"];
	$board->id 			  = $_POST["board_id"];
	// check how many pps is already there
	$board->check_pps();
	// get the post status
	$board->get_post_status();
	
	$posts = array();
	
	$posts["is_pps"] = ($board->post_status_id == 4) ? true : false;
	$posts["is_max"] = ($board->pps_count >= 4) ? true : false;

	// return the object back as a json request	
	header('Content-Type: application/json');	
	echo json_encode($posts);

?>