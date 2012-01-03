<?
/***********************************************************************
* post_pps.php
* Author		  : Christopher Bartholomew
* Last Updated    : 12/08/2011
* Purpose		  : Begin Processing PPS if is_ready submits false, check 
**********************************************************************/
	require_once("includes/common.php");
	
	
	// left off here - need to make ajax submission to this form.	
	// create an empty board object object
	$board = new Board(null);
	
	// get the board
	$board = get_specific_board($_POST["board_id"]);
	
	// assign the specific post id on the board
	$board->board_post_id = $_POST["board_post_id"];
	
	$needs_extension = $board->determine_pps_extension();
	
	switch($needs_extension)
	{
		case true:
			// if enabled now, the flyer will expire before the time is up. Thus, we extend the flyer an additional amount equal to the difference
			$board->update_pps_expire_date();
			// enable it
			$board->enable_pps();
		break;
		
		case false:
			// enable it
			$board->enable_pps();
		break;
	}
	
?>