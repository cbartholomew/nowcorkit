<?
 /***********************************************************************
 * post_remove.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/08/2011
 * Purpose		  : when called, this will remove the post from any board
 **********************************************************************/
		require_once("includes/common.php");
		
			// create an empty board object object
			$board = new Board(null);
			
			// get the current values for the board object
			$board->board_post_id = $_POST["id"]; 

			// remove the board	
			$board->delete_post_from_board();
			
?>