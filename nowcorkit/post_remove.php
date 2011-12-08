<?
  /***********************************************************************
  * XXX.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 
  * Purpose		  : 
  **********************************************************************/
		require_once("includes/common.php");
		
			// create an empty board object object
			$board = new Board(null);
			
			// get the current values for the board object
			$board->board_post_id = $_POST["id"]; 

			// remove the board	
			$board->delete_post_from_board();
			
?>