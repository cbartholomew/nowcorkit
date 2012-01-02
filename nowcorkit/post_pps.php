<?
/***********************************************************************
* post_pps.php
* Author		  : Christopher Bartholomew
* Last Updated    : 12/08/2011
* Purpose		  : Begin Processing PPS if is_ready submits false, check 
**********************************************************************/
		require_once("includes/common.php");
		
			// create an empty board object object
			$board = new Board(null);
			$type = $_POST["is_ready"];
			// get the current values for the board object
			$board->board_post_id = $_POST["id"]; 
						
			switch($type)
			{			
				case "true":
					$board->enable_pps();
				break;
				
				case "false":
					$board->check_pps();
				break;
			}

?>