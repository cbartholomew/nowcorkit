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
					$board->address 					= mysql_real_escape_string($_POST["updates"]["address"]);
					$board->city 						= mysql_real_escape_string($_POST["updates"]["city"]);
					$board->description					= mysql_real_escape_string($_POST["updates"]["description"]);
					$board->state_id					= mysql_real_escape_string($_POST["updates"]["state"]);
					$board->title 						= mysql_real_escape_string($_POST["updates"]["title"]);
					$board->zip							= mysql_real_escape_string($_POST["updates"]["zipcode"]);				
				break;
				
				case "permission":
					 $board->permission_type_id	 		= $_POST["updates"]["permissions"];
				break;
				
				case "posting":
					$board->expiration_days 			= mysql_real_escape_string($_POST["updates"]["flyerexpire"]);
					$board->enable_shuffle				= $_POST["updates"]["shuffle"];
					$board->shuffle_interval 			= $_POST["updates"]["interval"];
					$board->pps_id						= $_POST["updates"]["postperspace"];
					$board->pps_cashamount				= mysql_real_escape_string($_POST["updates"]["cashamount"]);
					$board->pps_flyerdays				= mysql_real_escape_string($_POST["updates"]["flyerdays"]);
					$board->pps_payment					= $_POST["updates"]["pay_handle"];
				break;
							
			}
			
			// create update
			$board->update();
			
			// return the object back as a json request
			header('Content-Type: application/json');
			echo json_encode($board);

?>