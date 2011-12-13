<?
  /***********************************************************************
  * board_update.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 12/08/2011
  * Purpose		  : based on the updates parameter (object) that is sent form
  * the application. We will determine which of the "tabs" needed to be updated
  * and thus, we shall update those accordingly
  **********************************************************************/
		require_once("includes/common.php");
		
			// create an empty board object object
			$board = new Board(null);
			
			// get the current values for the board object
			$board = get_specific_board($_POST["updates"]["id"]);
				
			//based on which page is making the postback, update that specific data set
			// only assign, which is applicable for this specific update
			switch($_POST["updates"]["page"])
			{
				
				case "general":
					$board->address 					= $_POST["updates"]["address"];
					$board->city 						= $_POST["updates"]["city"];
					$board->description					= $_POST["updates"]["description"];
					$board->state_id					= $_POST["updates"]["state"];
					$board->title 						= $_POST["updates"]["title"];
					$board->zip							= $_POST["updates"]["zipcode"];				
				break;
				
				case "permission":
					 $board->permission_type_id	 		= $_POST["updates"]["permissions"];
				break;
				
				case "posting":
					$board->expiration_days 			= $_POST["updates"]["flyerexpire"];
					$board->enable_shuffle				= $_POST["updates"]["shuffle"];
					$board->shuffle_interval 			= $_POST["updates"]["interval"];
					$board->pps_id						= $_POST["updates"]["postperspace"];
					$board->pps_cashamount				= $_POST["updates"]["cashamount"];
					$board->pps_flyerdays				= $_POST["updates"]["flyerdays"];
				break;
							
			}
			
			// create update
			$board->update();
			
			// return the object back as a json request
			header('Content-Type: application/json');
			echo json_encode($board);

?>