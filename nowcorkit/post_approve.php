<?
/***********************************************************************
* post_approve.php
* Author		  : Christopher Bartholomew
* Last Updated    : 12/08/2011
* Purpose		  : Based on the parameter, is_approve - this will send a request
* that will ask the object to either approve a post in the database or not approve
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