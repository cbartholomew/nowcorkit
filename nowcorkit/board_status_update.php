<?
/***********************************************************************
* board_status_update.php
* Author		  : Christopher Bartholomew
* Last Updated    : 1/28/2011
* Purpose		  : Update's the status of the board
**********************************************************************/
	
	require_once("includes/common.php");
	// create empty board object
	$board = new Board(null);
	
	// retrieve board id and board status from post header
	$board_id = $_POST["boardid"];
	$status   = $_POST["board_status"];
	
	// populate board object
	$board = get_specific_board($board_id);

	// update board_status w/ the curreent status
	$board->board_status_is_displaying = $status;
	$board->board_status_update();

?>