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
			
			$type = $_POST["is_approve"];
				
			// get the current values for the board object
			$board->board_post_id = $_POST["id"]; 
						
			switch($type)
			{			
				case "true":
					$board->approve();
				break;
				
				case "false":
					$board->not_approve();
				break;
			}

?>