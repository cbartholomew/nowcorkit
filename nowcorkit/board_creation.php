<?
  /***********************************************************************
  * XXX.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 
  * Purpose		  : 
  **********************************************************************/
		require_once("includes/common.php");
		
			// create new flyer object
			$board = new Board($_POST);

			// insert the new text flyer in the database
			$board->insert();
			
			// return the object back as a json request
			header('Content-Type: application/json');
			echo json_encode($board);
			
?>