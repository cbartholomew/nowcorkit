<?
  /***********************************************************************
  * board_remove.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 12/8/2011
  * Purpose		  : This will construct a specific class object, and then it will be deleted
  **********************************************************************/
		require_once("includes/common.php");
		
			// create an empty board object object
			$board = new Board(null);
			
			// get the current values for the board object
			$board = get_specific_board($_POST["id"]);
			
			// remove the board	
			$confim = $board->delete();
			
?>