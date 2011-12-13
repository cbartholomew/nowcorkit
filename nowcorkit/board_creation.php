<?
/***********************************************************************
* board_creation.php
* Author		  : Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		  : based on the post request, we construct an object to insert
* into the application.
**********************************************************************/
		require_once("includes/common.php");
		
			// create new flyer object
			$board = new Board($_POST);

			// insert the new text flyer in the database
			$board->insert();
			
			// return the object back as a json response
			header('Content-Type: application/json');
			echo json_encode($board);
			
?>