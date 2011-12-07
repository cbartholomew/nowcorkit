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
			$board = get_specific_board($_POST["id"]);
			
			// remove the board	
			$board->delete();
			
?>