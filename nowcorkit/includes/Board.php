<?
/***********************************************************************
* Board.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Board Object
**********************************************************************/


/* Object: Board
 * Used to contain information about the user. 
 */
class Board
{
	
		public $id 						= NULL;
		public $title 					= NULL;
		public $description 			= NULL;
		public $address 				= NULL;
		public $city 					= NULL;
		public $state_id 				= NULL;
		public $state_desc				= NULL;
		public $zip 					= NULL;
		public $permission_type_id	 	= NULL;
		public $permission_type_desc	= NULL;
		public $expiration_days 		= NULL;
		public $enable_shuffle			= NULL;
		public $shuffle_interval 		= NULL;
		public $enable_pps				= NULL;
		public $pps_id					= NULL;
		public $pps_cashamount			= NULL;
		public $pps_flyerdays			= NULL;
		public $pps_payment				= NULL;
		public $cork_id 				= NULL;
		public $flyers					= NULL;
		public $users_flyers_id			= NULL;
		public $post_status_id			= NULL;
		public $board_post_id			= NULL;
	
		/*
		 * __construct($_DATA) 
		 * Contructs a user object based on the form data
		 */
	    function __construct($_DATA) 
		{
	
				$this->title 							= mysql_real_escape_string($_DATA["title"]);
				$this->description 					 	= mysql_real_escape_string($_DATA["description"]);
				$this->address 							= mysql_real_escape_string($_DATA["address"]);
				$this->city 							= mysql_real_escape_string($_DATA["city"]);
				$this->state_id 						= mysql_real_escape_string($_DATA["state"]);
				$this->zip 								= mysql_real_escape_string($_DATA["zipcode"]);
				$this->permission_type_id 				= mysql_real_escape_string($_DATA["permissions"]);
				$this->expiration_days 					= mysql_real_escape_string($_DATA["flyerexpire"]);
				$this->enable_shuffle					= mysql_real_escape_string($_DATA["shuffle"]);
				$this->shuffle_interval					= mysql_real_escape_string($_DATA["interval"]);
				$this->pps_id							= mysql_real_escape_string($_DATA["postperspace"]);
				$this->pps_cashamount					= mysql_real_escape_string($_DATA["cashamount"]);
				$this->pps_flyerdays					= mysql_real_escape_string($_DATA["flyerdays"]);
				$this->pps_payment						= mysql_real_escape_string($_DATA["pay_handle"]);
				$this->cork_id 							= $_SESSION['users_cork_id'];

	    }
						
		/* insert()
		 * Inserts a new "board" into the board preferences table
		 */
		function insert()
		{

		// Prepare the statement to insert the new value
		$date_time = date('Y-m-d H:i:s');
		$sql = "INSERT INTO board_preferences 				\n"  
				. " ( 										\n" 
				. "board_title,   							\n" 
				. "board_description, 						\n" 
				. "board_address, 							\n" 
				. "board_city, 								\n" 
				. "board_state_id, 							\n" 
				. "board_zip, 								\n" 
				. "board_permission_type_id, 				\n"
				. "board_expiration_days, 					\n" 
				. "board_enable_shuffler, 					\n"
				. "board_shuffler_interval, 				\n"
				. "board_pps_id, 							\n" 
				. "board_pps_cash_amount, 					\n" 
				. "board_pps_flyerdays, 					\n" 
				. "board_pps_payment,						\n"
				. "board_users_cork_id, 					\n" 
				. "board_created_dttm 						\n" 
				. ") 										\n" 
				. "VALUES 									\n" 
				. "(  										\n"
				. " '$this->title', 						\n" 
				. " '$this->description', 					\n" 
				. " '$this->address', 						\n" 
				. " '$this->city', 							\n" 
				. " '$this->state_id', 						\n" 
				. " '$this->zip', 							\n" 
				. " '$this->permission_type_id', 			\n" 
				. " '$this->expiration_days', 				\n" 
				. " '$this->enable_shuffle', 				\n"
				. " '$this->shuffle_interval', 				\n" 
				. " '$this->pps_id', 						\n" 
				. " '$this->pps_cashamount', 				\n" 
				. " '$this->pps_flyerdays', 				\n" 
				. "	'$this->pps_payment',					\n"
				. " '$this->cork_id', 						\n" 
				. " '$date_time' 							\n" 
				. ")";
		
				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with inserting board into the database' . $sql));

				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				// get the newly assigned cork id. 
				$this->id = mysql_insert_id();

				return true;
		
		}
		
		/* Update()
		 * When given the correct values, this will update the board's data
		 */
		function update()
		{
			
			$sql = "UPDATE board_preferences SET 													\n" 
				. "board_title 									= ('$this->title'), 				\n" 
				. "board_description 							= ('$this->description'),			\n" 
				. "board_address 								= ('$this->address'), 				\n" 
				. "board_city 									= ('$this->city'), 					\n"
				. "board_state_id 								= ('$this->state_id'), 				\n" 
				. "board_zip 									= ('$this->zip'), 					\n" 
				. "board_permission_type_id 					= ('$this->permission_type_id'), 	\n" 
				. "board_expiration_days						= ('$this->expiration_days'), 		\n" 
				. "board_enable_shuffler 						= ('$this->enable_shuffle'), 		\n"
				. "board_shuffler_interval 						= ('$this->shuffle_interval'), 		\n"
				. "board_pps_id 								= ('$this->pps_id'), 				\n" 
				. "board_pps_cash_amount 						= ('$this->pps_cashamount'), 		\n" 
				. "board_pps_flyerdays 							= ('$this->pps_flyerdays'),   		\n" 
				. "board_pps_payment							= ('$this->pps_payment')			\n"
				. "WHERE board_id 								= ('$this->id')";

				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with updating board into the database'));

				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
			
				return true;
		}
		
		/* delete()
		 * Once removed, the entire board will be removed, and thus unlinking all flyers from it
		 */
		function delete()
		{
			$sql = "DELETE FROM board_preferences WHERE board_id = ('$this->id')";
			
			// run statement or die
			$result = mysql_query($sql) or die (show_error('Problem with removing the board from the database'));

			// other than an error, there was a problem submitting the user
			if ($result == false) { return false; }
			
			return true;	
		}
			
		/*
		 * delete_post_from_board()
		 * this function will remove a specific post off the board from the manager level
		 */
		function delete_post_from_board()
		{
				// delete the users_flyer in the database		
				$sql = "DELETE FROM board_posting									  				\n"
				 . "WHERE board_post_id	 = ('$this->board_post_id')";

				 // run statement or die
				$result = mysql_query($sql) or die (show_error("Problem with removing post from postings" . $sql));

				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				return true;	
		}
			
			/*
		     *	post()
			 *  Once the object is prepared, this will add a post to the posting table
			 */
			function post()
			{
				// Prepare the statement to insert the new value
				$date_time = date('Y-m-d H:i:s');
				

				$sql = "INSERT INTO board_posting 	\n" 
				. " ( 								\n"  
				. " board_post_board_id, 			\n" 
				. " board_post_users_flyers_id, 	\n" 
				. " board_post_users_cork_id,		\n"
				. " board_post_post_status_id, 		\n"
				. " board_post_expire_dttm, 		\n" 
				. " board_post_created_dttm 		\n" 
				. " ) 								\n" 
				. " VALUES 							\n" 
				. " ( 								\n"
				. " '$this->id', 					\n"
				. " '$this->users_flyers_id', 		\n"
				. " '$this->cork_id', 				\n" 
				. " '$this->post_status_id', 		\n" 
				. " '$date_time', 					\n" 
				. " '$date_time' 					\n"
				. " )";

				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with posting to a new board'));
				
				// get the new id
				$new_id = mysql_insert_id();
				
				// populate the table w/ the expiration date
				$sql = "UPDATE board_posting SET board_post_expire_dttm = DATE_ADD(board_post_created_dttm, INTERVAL $this->expiration_days DAY) WHERE board_post_id = ('$new_id')";
				
				// run the statement
				$result = mysql_query($sql) or die (show_error('Problem with posting to a new board'));
					
				// return false if it doens't update
				
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				// get the newly assigned cork id. 
				return true;
			}
		
		/*
		 * approve()
		 * this will update the flyer's status to 1 on the board posting table which will determine if a post can be read
		 */
		function approve(){

			$sql = "update board_posting set board_post_post_status_id = 1 where board_post_id = $this->board_post_id";
			// run statement or die
			$result = mysql_query($sql) or die (show_error('Problem with approving flyer'));
			
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				// get the newly assigned cork id. 
				return true;
			
		}
	
		/*
		 * not_approve()
		 * this will update the flyer's status to 3 on the board posting table which will determine if a post can be read
		 */
		function not_approve(){
			
			$sql = "update board_posting set board_post_post_status_id = 3 where board_post_id = $this->board_post_id";
			// run statement or die
			$result = mysql_query($sql) or die (show_error('Problem with not approving flyer'));
			
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				// get the newly assigned cork id. 
				return true;
		}
		
	
}




?>