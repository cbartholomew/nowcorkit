<?
	require_once("class_objects.php");
	require_once("constants.php");
	require_once("DAL.php");

/***********************************************************************
* helpers.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/8/2011
* Purpose		: Provides helper functions for application - this is another
* large file that should be a little smaller. I use the helpers to do anything
* that involves no-object specific database handling - EXCEPT - select satements
* All getter's of object information is done in this file. 
**********************************************************************/

	/* ValidateNormalLogin($_FORMDATA)
	 * Checks if user is in the user's table
	 */
	function ValidateNormalLogin($_FORMDATA)
	{
	    // escape username to avoid SQL injection attacks
	    $email = mysql_real_escape_string($_FORMDATA["email"]);
	    // prepare SQL
	    $sql = "SELECT * FROM users WHERE users_email ='$email'";
	    // execute query
	    $result = mysql_query($sql);
	    // if we found user, check password
	    if (mysql_num_rows($result) == 1)
	    {
	        // grab row
	        $row = mysql_fetch_array($result);

	        // compare hash of user's input against hash that's in database
	        if (crypt($_FORMDATA["password"], $row["users_hash"]) == $row["users_hash"])
	        {
	            // remember that user's now logged in by caching user's ID in session
	            $_SESSION["users_cork_id"] = $row["users_cork_id"];

				$u = new User(NULL);
				$u->cork_id = $_SESSION["users_cork_id"];
				$u->update_login_time_and_count();
				
	            // redirect to portfolio
	            redirect("index.php");
	        }
	    }
	
		return false;
	}
	
	/* change_password($email)
	 * 
	 * changes the user's password
	 */
	function change_password($form)
	{
		// create new user object
		$u = new User(null);
		
		// assign e-mail and password from form data
		$u->email 		  = $form["email"];
		$u->password_hash = $form["password"];
		
		// hash the password
		$u->hash_password();
		
		// update the hashed password
		$did_change = $u->update_password();
		
		if ($did_change) { redirect("recover_confirm.php"); } 
		else { show_error("Problem with updating password, please try again later."); }
		
	}
		
	/* ValidateNewRegistration($_FORMDATA)
	 * Server Side Validation for Registration users
	 */
	function ValidateNewRegistration($_FORMDATA)
	{
		// instantiate new user based on form data
		$user_reg = new User($_FORMDATA);	
		
		$user_reg->hash_password();
		
		// create new dictionary 
		$validation_values = array();
		
		/********* Email Validation Options *********/
		// check if the email is empty
		if (empty($user_reg->email)) 				{ $validation_values['email'] 			= 'false'; }
		else 										{ $validation_values['email'] 			= 'true';  }
			 
		// check if the email is already in the system
		if (LookupEmail($user_reg->email) == 'false') 		{ $validation_values['email_available'] = 'false'; }
		else 												{ $validation_values['email_available'] = 'true';  }
				
		// check if the email is already in the system
		if (!ValidEmail($user_reg->email)) 			{ $validation_values['email_valid'] 	= 'false'; }
		else 										{ $validation_values['email_valid'] 	= 'true';  }
		/********* End Email Validation Options *********/
		
		// check if the user's first name is blank
		if (empty($user_reg->first_name)) 			{ $validation_values['first_name'] 		= 'false'; }
		else 										{ $validation_values['first_name'] 		= 'true';  }
			
		// check if the user's last name is blank	
		if (empty($user_reg->last_name)) 			{ $validation_values['last_name'] 		= 'false'; }
		else 										{ $validation_values['last_name'] 		= 'true';  }
		
		/********* Password Validation Options *********/
		if (empty($_FORMDATA['password'])) 			{ $validation_values['password'] 	= 'false'; }
		else 										{ $validation_values['password'] 	= 'true';  }
		
		// Is the password greater than 5 characters?
		if(strlen($_FORMDATA['password']) < 5) 		{ $validation_values['password_length'] = 'false'; }
		else 										{ $validation_values['password_length'] = 'true';  }
		
		// finally, check if the password hashes match
		if( !ComparePasswords($_FORMDATA['password'], $_FORMDATA['password_confirm']))  { $validation_values['password_match'] = 'false'; }
		else 																			{ $validation_values['password_match'] = 'true';  }
		/********* End Password Validation Options *********/
		
		// check if the user has chosen a state
		if ($user_reg->state_id == 0) 				{ $validation_values['state'] 			= 'false'; }
		else 										{ $validation_values['state'] 			= 'true';  }
		
		return $validation_values;
		
	}
	
	/*
	 * generate_forgot_passsword($email)
	 * Generates the hashed link that will be sent to the user so they can reset his or her password
	 */
	function generate_forgot_password($email)
	{
			// check the database for the user
			$sql = "SELECT * FROM forgot_password WHERE forgot_password_users_email = ('$email') AND forgot_password_email_sent = 0";
			$result = mysql_query($sql) or die (show_error('Problem with generating link'));

			// return the value back to the validator. false means no user found, true means user is found
			while($row = mysql_fetch_array($result))
			{
				$url_hash 		 	= $row["forgot_password_url_hash"];
			}			
			// generate link
			$link = "http://localhost/nowcorkit/recover.php?id=" . $url_hash;
					
			return $link;
	}
	/* update_email_sent()
	 * 
	 * When user clicks link, we update the field to show that the e-mail has been sent, and thus, expiring the token
	 */
	function update_email_sent($forgot_password_id)
	{
		// build additional SQL update statement
		$sql = "UPDATE forgot_password SET forgot_password_email_sent = 1 where forgot_password_id = ('$forgot_password_id')";
		
		// update the database to notify that the password has been sent
		$result = mysql_query($sql) or die (show_error('Problem with updating email sent'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
		
	}
	
	
    /* ComparePasswords($password_one, $password_two)
     * Purpose: Based on the hashed passwords passed into function
     * check and make sure the password hashes match 
     */
    function ComparePasswords($password_one, $password_two)
    {
        // compare values
       // if ($password_one != $password_two) { return false; }
   	  return ($password_one == $password_two) ? true : false;

      
    }
	
	/* LookupEmail($email_address)
	 * Checks if user's email is in the user's table
	 */
	function LookupEmail($email_address)
	{
		// check the database for the user
		$sql = "SELECT * FROM users WHERE users_email = ('$email_address')";
		$result = mysql_query($sql) or die (show_error('Problem with checking email'));
		
		// return the value back to the validator. false means no user found, true means user is found
		$value = (mysql_num_rows($result) > 0 ) ? 'false' : 'true';
		
		return $value;
	}
	
	/* ValidEmail($email_address)
	 * Checks if user's email is valid
	 */
	function ValidEmail($email_address)
	{
		
		if(preg_match("/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9-])+.([a-zA-Z0-9-.])+$/", $email_address)) {return true;}
	 	return false;
	}
	
	/* LookupFacebookUserIdInUsers($fbuser)
	 * Checks to see if the user has already been created on the users table
	 */
	function LookupFacebookUserIdInUsers($fbuser)
	{
		
		// prepare SQL
	    $sql = "SELECT * FROM users WHERE users_facebook_users_id ='$user->id'";
	    // execute query
	    $result = mysql_query($sql);
	   	
		// check if the user has a cork_id - create user if none is there
	    if (mysql_num_rows($result) == 0)
		{
			return 0;
		}
		else
		{	
			// grab the row
			$row = mysql_fetch_array($result);
			return $row["users_cork_id"];
		}
		
	}

	/* GetStates()
	 * function, which returns a list of states from database
	 */
	function GetStates()
	{		
		// create new associative array object
		$state_array =  array();
		// prepare statement
		$sql = "select * from state order by state_id desc";
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling States'));
		
		// push the states onto the array stack LIFO. State ID 1-50.
		if (mysql_num_rows($result) > 0) 
		{
			
			while($row = mysql_fetch_array($result))
		   {	   
			// prepare new state object
			$state 		 = new State();					
			// populate object
			$state->id 		= $row["state_id"];
			$state->name 	= $row["state_desc"];
			// push onto stack
			array_push($state_array, $state);
			}
		
		}
		// return array
		return $state_array;		
	}
	
	
	/* get_users_state($cork_id)
	 * function, which returns a specific state id based on the users cork id
 	 */
	function get_users_state($cork_id)
	{
			
			// sql state to get the state_id by user's cork id
			$sql = "select users_state_id from users where users_cork_id = ('$cork_id')";
			
			// run statement or error
			$result = mysql_query($sql) or die (show_error('Problem with pulling States'));

			// push the states onto the array stack LIFO. State ID 1-50.
			if (mysql_num_rows($result) > 0) 
			{
			   while($row = mysql_fetch_array($result))
			   {	   
					// prepare new state object
					$state_id = $row["users_state_id"];				
			  		return $state_id;
			   }
			}		
	}
	
	/* GetFullFlyer($user_flyer_id)
	 * function, which returns a specific flyer based on the users_flyer id
 	 */ 
	function GetFullFlyer($user_flyer_id)
	{
		
		// select the specific data for this user
		$sql = "SELECT * 																\n"
		    . "FROM users_flyers														\n"
		    . "INNER JOIN flyer_type													\n"
		    . "ON users_flyers.users_flyers_flyers_type_id = flyer_type.flyer_type_id	\n"
		    . "WHERE users_flyers_id = ('$user_flyer_id') 								\n";
		
		$result = mysql_query($sql) or die (showerror('Problem with pulling users flyer id'));
		
		//users_flyers_id	users_flyers_users_cork_id	users_flyers_flyers_type_id	us
		if (mysql_num_rows($result) > 0)
		{
			while($row = mysql_fetch_array($result))
			{
				// assign the flyer type to variable to be used later
				$users_flyer_flyer_type_id 		= $row["users_flyers_flyers_type_id"];
				$flyer_type_desc				= $row["flyer_type_desc"];
				// create new sql query to obtain the actual flyer
				$sql = get_select_sql_specific($row["users_flyers_flyers_id"], $users_flyer_flyer_type_id);

				// get the data from the second query result
				$result = mysql_query($sql) or die (show_error("problem with pulling specific flyer"));
					
					// obtain the inner data
					while($row = mysql_fetch_array($result))
					{
						if (mysql_num_rows($result) > 0) 
						{ 
							switch($users_flyer_flyer_type_id)
							{
									case "1":
											$flyer = new Flyer(null);
											
											$flyer->flyer_error_id 			= 0;
											$flyer->id 						= $row["text_flyer_id"];
											$flyer->cork_id					= $row["text_flyer_users_cork_id"];
											$flyer->title 					= str_replace("\\","",$row["text_flyer_title"]);
											$flyer->description 			= str_replace("\\","",$row["text_flyer_desc"]);
											$flyer->location				= str_replace("\\","",$row["text_flyer_location"]);
											$flyer->event_date				= $row["text_flyer_event_date"];
											$flyer->contact_id				= $row["text_flyer_contact_type_id"];
											$flyer->contact_name			= str_replace("\\","",$row["text_flyer_contact_name"]);
											$flyer->contact_info			= $row["text_flyer_contact_information"];
											$flyer->enable_qr				= $row["text_flyer_generate_qr_code"];
											$flyer->qr_full_location		= $row["text_flyer_qr_code_location"];
											$flyer->created_dttm 			= $row["text_flyer_created_dttm"];
											$flyer->type					= $flyer_type_desc;
											$flyer->type_id					= $users_flyer_flyer_type_id;
											$flyer->users_flyer_id			= $row["users_flyers_id"];
										
											return $flyer;
									break;
								
									case "2":
									
											$flyer = new Flyer(null);
											
											$flyer->flyer_error_id 			= 0;
											$flyer->id 						= $row["text_image_flyer_id"];
											$flyer->cork_id					= $row["text_image_flyer_users_cork_id"];
										 	$flyer->title 					= str_replace("\\","",$row["text_image_flyer_title"]);
										 	$flyer->description 			= str_replace("\\","",$row["text_image_flyer_desc"]);
										 	$flyer->location				= str_replace("\\","",$row["text_image_flyer_location"]);
										 	$flyer->event_date				= $row["text_image_flyer_event_date"];
								 			$flyer->contact_id				= $row["text_image_flyer_contact_type_id"];
										 	$flyer->contact_name			= str_replace("\\","",$row["text_image_flyer_contact_name"]);
										 	$flyer->contact_info			= $row["text_image_flyer_contact_information"];
										 	$flyer->enable_qr				= $row["text_image_flyer_generate_qr_code"];
										 	$flyer->qr_full_location		= $row["text_image_flyer_qr_code_location"];
										 	$flyer->created_dttm 			= $row["text_image_flyer_created_dttm"];
										 	$flyer->type					= $flyer_type_desc;
									 		$flyer->type_id					= $users_flyer_flyer_type_id;
									 		$flyer->users_flyer_id			= $row["users_flyers_id"];
											$flyer->image_meta_data_id		= $row["text_image_flyer_image_meta_data_id"];
											$flyer->image_path 				= $row["image_meta_data_image_location"] . $row["image_meta_data_file_name"];
										
											return $flyer;
									break;
								
									case "3":
															
											$flyer = new Flyer(null);											
											
											$flyer->flyer_error_id 			= 0;
											$flyer->id 						= $row["image_flyer_id"];
											$flyer->title 					= str_replace("\\","",$row["image_flyer_title"]);
											$flyer->image_meta_data_id		= $row["image_flyer_image_meta_data_id"];
											$flyer->type					= $flyer_type_desc;
											$flyer->type_id					= $users_flyer_flyer_type_id;	
											$flyer->image_path 				= $row["image_meta_data_image_location"] . $row["image_meta_data_file_name"];
										
											return $flyer;				
									break;
								
									default:
											$flyer->flyer_error_id 			= 99;
											$flyer->flyer_message			= "There was a problem looking up the flyer.";
										
											return $flyer;
									break;				
							}							
						}
					}
				}
			}
		}
	
	
	/* GetFlyers($cork_id, $flyer_type_id)
	 * function, which returns a list of flyers from database
	 */
	function GetFlyers($cork_id, $flyer_type_id)
	{		
		// create new associative array object
		$flyer_array =  array();
		
		// prepare statement
		$sql =  get_select_sql($cork_id, $flyer_type_id);
			
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling flyers'));
		
		// push the flyers onto the array stack LIFO. 
		if (mysql_num_rows($result) > 0) 
		{
		   while($row = mysql_fetch_array($result))
		   {	   
				// prepare new flyer object
				$flyer 		 = new Flyer(null);					
				// populate object
				
				switch($flyer_type_id)
				{
					case "1":
						$flyer->id 						= $row["text_flyer_id"];
						$flyer->cork_id					= $row["text_flyer_users_cork_id"];
					 	$flyer->title 					= str_replace("\\","",$row["text_flyer_title"]);
					 	$flyer->description 			= str_replace("\\","",$row["text_flyer_desc"]);
					 	$flyer->location				= str_replace("\\","",$row["text_flyer_location"]);
					 	$flyer->event_date				= $row["text_flyer_event_date"];
					 	$flyer->contact_id				= $row["text_flyer_contact_type_id"];
					 	$flyer->contact_name			= str_replace("\\","",$row["text_flyer_contact_name"]);
					 	$flyer->contact_info			= $row["text_flyer_contact_information"];
					 	$flyer->enable_qr				= $row["text_flyer_generate_qr_code"];
					 	$flyer->qr_full_location		= $row["text_flyer_qr_code_location"];
					 	$flyer->type					= $row["flyer_type_desc"];
				 		$flyer->type_id					= $row["users_flyers_flyers_type_id"];
				 		$flyer->users_flyer_id			= $row["users_flyers_id"];
					break;
					case "2":
						$flyer->id 						= $row["text_image_flyer_id"];
						$flyer->cork_id					= $row["text_image_flyer_users_cork_id"];
					 	$flyer->title 					= str_replace("\\","",$row["text_image_flyer_title"]);
					 	$flyer->description 			= str_replace("\\","",$row["text_image_flyer_desc"]);
					 	$flyer->location				= str_replace("\\","",$row["text_image_flyer_location"]);
					 	$flyer->event_date				= $row["text_image_flyer_event_date"];
					 	$flyer->contact_id				= $row["text_image_flyer_contact_type_id"];
					 	$flyer->contact_name			= str_replace("\\","",$row["text_image_flyer_contact_name"]);
					 	$flyer->contact_info			= $row["text_image_flyer_contact_information"];
					 	$flyer->enable_qr				= $row["text_image_flyer_generate_qr_code"];
					 	$flyer->qr_full_location		= $row["text_image_flyer_qr_code_location"];
					 	$flyer->type					= $row["flyer_type_desc"];
				 		$flyer->type_id					= $row["users_flyers_flyers_type_id"];
				 		$flyer->users_flyer_id			= $row["users_flyers_id"];
						$flyer->image_meta_data_id		= $row["text_image_flyer_image_meta_data_id"];
					break;
					case "3":
						$flyer->id 						= $row["image_flyer_id"];
						$flyer->title 					= str_replace("\\","",$row["image_flyer_title"]);
						$flyer->image_meta_data_id		= $row["image_flyer_image_meta_data_id"];			
						$flyer->users_flyer_id			= $row["users_flyers_id"];		
					break;
					default:
					break;				
				}
				
				// push onto stack
				array_push($flyer_array, $flyer);
			}	
		}
		// return array
		return $flyer_array;		
	}
	
	/*  get_users_boards($cork_id)
	 * This will get all the users's boards based on the cork id
	 */
	function get_users_boards($cork_id)
	{
		$board_array = array();
		
		$sql = "SELECT * FROM board_preferences WHERE board_users_cork_id = ('$cork_id') ORDER BY board_created_dttm DESC";
		
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling user specific boards'));
			// push the boards onto the array stack LIFO
			if (mysql_num_rows($result) > 0) 
			{
			   while($row = mysql_fetch_array($result))
			   {	   
					// prepare new flyer object
					$board 		 = new Board(null);					
					// populate object
					$board->id 	  = $row["board_id"];
					$board->title = str_replace("\\","",$row["board_title"]);
					// push onto stack
				   array_push($board_array, $board);
				}	
			}
			
		// return array
		return $board_array;
		
	}
	
	/* get_all_boards_by_state($state_id)
	 * This  function will get all the boards assoicated to the state id
	 */
	function get_all_boards_by_state($state_id){
		
		$board_array = array();
				
		$sql = "SELECT * 																										\n"
		    . "FROM board_preferences																						 	\n"
		    . "INNER JOIN permission_type ON board_preferences.board_permission_type_id = permission_type.permission_type_id 	\n"
		    . "INNER JOIN state ON board_preferences.board_state_id = state.state_id 											\n"
		    . "WHERE state_id = ('$state_id')";
		
		
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling boards by state'));
			// push the boards onto the array stack LIFO
			if (mysql_num_rows($result) > 0) 
			{
			   while($row = mysql_fetch_array($result))
			   {	   
					// prepare new flyer object
					$board 		 	= new Board(null);					
					// populate object
					$board = get_specific_board($row["board_id"]);		
					// add additional properties 
					$board->state_desc 				= $row["state_desc"];
					$board->permission_type_desc	= $row["permission_type_desc"]; 
					$board->pps_id					= $row["board_pps_id"]; 	 
					$board->pps_cashamount			= $row["board_pps_cash_amount"];
					$board->pps_flyerdays			= $row["board_pps_flyerdays"];	
					$board->pps_payment				= $row["board_pps_payment"];							 	 	
					$board->check_pps();	
											 	 	 	 	 	 					 	 	 	 	 	 	
					// push onto stack
				   	array_push($board_array, $board);
				}	
			}
			
		// return array
		return $board_array;	
	}
	
	/* get_specific_board($board_id)
	 *  based on the board id, we will construct a board object that can be returned
	 */
	function get_specific_board($board_id)
	{
		$sql = "SELECT * FROM board_preferences WHERE board_id = ('$board_id')";
			
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling specific board'));
			if (mysql_num_rows($result) > 0) 
			{
			   while($row = mysql_fetch_array($result))
			   {	   
					// prepare new flyer object
					$board 		 = new Board(null);					
					// populate object					
					$board->id 						= $row["board_id"];
					$board->title 					= str_replace("\\","",$row["board_title"]);
					$board->description 			= str_replace("\\","",$row["board_description"]);
					$board->address 				= $row["board_address"];
					$board->city 					= $row["board_city"];
					$board->state_id 				= $row["board_state_id"];
					$board->zip 					= $row["board_zip"];
					$board->permission_type_id	 	= $row["board_permission_type_id"];
					$board->expiration_days 		= $row["board_expiration_days"];
					$board->enable_shuffle			= $row["board_enable_shuffler"];
					$board->shuffle_interval 		= $row["board_shuffler_interval"];
					$board->pps_id					= $row["board_pps_id"];
					$board->pps_cashamount			= $row["board_pps_cash_amount"];
					$board->pps_flyerdays			= $row["board_pps_flyerdays"];
					$board->pps_payment				= $row["board_pps_payment"];
					$board->cork_id 				= $row["board_users_cork_id"];
					$board->check_pps();
					
					// return the object
					return $board;
				}	
			}
	}

	/* get_all_posts_by_users_cork_id($users_cork_id)
	 * will return a post object that contains all the posts for a specific user
	 */
	function get_all_posts_by_users_cork_id($users_cork_id)
	{
		// You have an object, which contains a set of boards that will be sent back to the user via json
		$posts = array();
	
		// get all posts made by a specific user. 
		$sql =   "SELECT * FROM board_posting													\n"
		    	. "INNER JOIN board_preferences													\n"
		    	. "ON board_posting.board_post_board_id = board_preferences.board_id			\n"
		    	. "inner join post_status														\n"
		    	. "ON board_post_post_status_id = post_status.post_status_id					\n"
		    	. "WHERE board_posting.board_post_users_cork_id = ('$users_cork_id')			\n"
				. "ORDER BY board_posting.board_post_expire_dttm desc";
				
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling posts by user'));
		
		// for every row, take the current board and populate both the board and flyer object. 
		// contain the flyer within the board, and then push it onto the array
				if (mysql_num_rows($result) > 0) 
				{
				   while($row = mysql_fetch_array($result))
				   {	   
						// create new board and flyer objects
						$board 		 = new Board(null);	
						$flyer		 = new Flyer(null);
						
						// construct board object
						$board 		 = get_specific_board($row["board_post_board_id"]);
						$board->board_post_id 			= $row["board_post_id"];
												
												
						// construct flyer
						$flyer		 					= GetFullFlyer($row["board_post_users_flyers_id"]);					
						$flyer->users_flyers_id			= $row["board_post_users_flyers_id"];
						$flyer->post_status_desc		= $row["post_status_desc"];
						$flyer->post_expiration 		= $row["board_post_expire_dttm"];

						// assoicate the flyer to the board 
						$board->flyers = $flyer;
						
						// pop it on to the array
						array_push($posts, $board);
					}	
				}
				
		return $posts;
	}

	/*  get_all_posts_by_board_id($board_id)
	 *  Obtains all posts for a board - not including "approved"
	 */
	function get_all_posts_by_board_id($board_id)
	{
		// You have an object, which contains a set of boards that will be sent back to the user via json
		$posts = array();
	
		// get all posts made by a specific user. 
		$sql =   "SELECT * FROM board_posting													\n"
		    	. "INNER JOIN board_preferences													\n"
		    	. "ON board_posting.board_post_board_id = board_preferences.board_id			\n"
		    	. "inner join post_status														\n"
		    	. "ON board_post_post_status_id = post_status.post_status_id					\n"
		    	. "WHERE board_posting.board_post_board_id = ('$board_id')						\n"
				. "ORDER BY board_posting.board_post_created_dttm";
				
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling posts by user'));
		
		// for every row, take the current board and populate both the board and flyer object. 
		// contain the flyer within the board, and then push it onto the array
				if (mysql_num_rows($result) > 0) 
				{
				   while($row = mysql_fetch_array($result))
				   {	   
						// create new board and flyer objects
						$post		 = new Post();
						$flyer		 = new Flyer(null);
						$flyer		 = GetFullFlyer($row["board_post_users_flyers_id"]);
						$flyer->users_flyers_id			= $row["board_post_users_flyers_id"];
						$flyer->post_status_desc		= $row["post_status_desc"];
						$flyer->post_status_id			= $row["post_status_id"];
						$flyer->post_expiration 		= $row["board_post_expire_dttm"];
						$flyer->board_post_id			= $row["board_post_id"];
						$flyer->post_flyerdays			= $row["board_pps_flyerdays"];
						
						$post->flyer = $flyer;
						// pop it on to the array
						array_push($posts, $post);
					}	
				}
				
		return $posts;
	}
	/*
	 *  Obtains all approved posts for a board that are only "approved"
	 */
	function get_all_approved_posts_by_board_id($board_id)
	{
		// You have an object, which contains a set of boards that will be sent back to the user via json
		$posts = array();
	
		// get all posts made by a specific user. 
		$sql =   "SELECT * FROM board_posting													\n"
		    	. "INNER JOIN board_preferences													\n"
		    	. "ON board_posting.board_post_board_id = board_preferences.board_id			\n"
		    	. "inner join post_status														\n"
		    	. "ON board_post_post_status_id = post_status.post_status_id					\n"
		    	. "WHERE board_posting.board_post_board_id = ('$board_id')						\n"
				. "AND board_posting.board_post_post_status_id = 1								\n"
				. "ORDER BY board_posting.board_post_created_dttm";
				
		// run statement or error
		$result = mysql_query($sql) or die (show_error('Problem with pulling posts by user'));
		
		// for every row, take the current board and populate both the board and flyer object. 
		// contain the flyer within the board, and then push it onto the array
				if (mysql_num_rows($result) > 0) 
				{
				   while($row = mysql_fetch_array($result))
				   {	   
						// create new board and flyer objects
						$post		 = new Post();
						$flyer		 = new Flyer(null);
						$flyer		 = GetFullFlyer($row["board_post_users_flyers_id"]);
						$flyer->users_flyers_id			= $row["board_post_users_flyers_id"];
						$flyer->post_status_desc		= $row["post_status_desc"];
						$flyer->post_expiration 		= $row["board_post_expire_dttm"];
						$flyer->board_post_id			= $row["board_post_id"];
						
						$post->flyer = $flyer;
						// pop it on to the array
						array_push($posts, $post);
					}	
				}
				
		return $posts;
	}
	/*
	 * get_select_sql($cork_id,$flyer_type_id)
	 * This will get the specific "sql select txt" to use based on the flyer
	 */
	function get_select_sql($cork_id,$flyer_type_id)
	{
		$sql = "";
		
		switch ($flyer_type_id)
		{
		case "1":
				$sql =  "SELECT * 																\n"
				   . "FROM users_flyers 														\n"
				   . "INNER JOIN flyer_type														\n"
				   . "ON flyer_type.flyer_type_id = users_flyers.users_flyers_flyers_type_id	\n"
				   . "INNER JOIN text_flyers													\n"
				   . "ON users_flyers.users_flyers_flyers_id = text_flyers.text_flyer_id		\n"
				   . "WHERE users_flyers_flyers_type_id = ('$flyer_type_id')					\n"
				   . "AND users_flyers.users_flyers_users_cork_id = ('$cork_id')                \n"
				   . "ORDER BY text_flyers.text_flyer_created_dttm 	desc";
		break;
		
		case "2":
				$sql = "SELECT * 																		\n"
				    . "FROM users_flyers 																\n"
				    . "INNER JOIN flyer_type															\n"
				    . "ON flyer_type.flyer_type_id = users_flyers.users_flyers_flyers_type_id			\n"
				    . "INNER JOIN text_image_flyers														\n"
				    . "ON users_flyers.users_flyers_flyers_id = text_image_flyers.text_image_flyer_id	\n"
				    . "WHERE users_flyers_flyers_type_id = ('$flyer_type_id')							\n"
				    . "AND users_flyers.users_flyers_users_cork_id = ('$cork_id')						\n"
					. "ORDER BY text_image_flyers.text_image_flyer_created_dttm desc";
		
		break;
		case "3":
				$sql = "SELECT * 																	\n"
					    . "FROM users_flyers														\n"
					    . "INNER JOIN flyer_type 													\n"
					    . "ON flyer_type.flyer_type_id = users_flyers.users_flyers_flyers_type_id	\n"
					    . "INNER JOIN image_flyers 													\n"
					    . "ON users_flyers.users_flyers_flyers_id = image_flyers.image_flyer_id		\n"
					    . "WHERE users_flyers_flyers_type_id =  ('$flyer_type_id')					\n"
					    . "AND users_flyers.users_flyers_users_cork_id =  ('$cork_id')				\n"
						. "ORDER BY image_flyers.image_flyer_created_dttm desc";
			break;

		}
		
		
		return $sql;
		
	}
	
	/* get_select_sql_specific($flyer_id,$flyer_type_id)
	 * this function will obtain specific flyer id from a specific table
	 */
	function get_select_sql_specific($flyer_id,$flyer_type_id)
	{
		$sql = "";
		
		switch ($flyer_type_id)
		{
		case "1":
				$sql = "SELECT * 																		\n"
		    	. "FROM text_flyers																		\n"
		    	. "WHERE text_flyer_id = ('$flyer_id')													\n"; 
		break;		
		case "2":
				$sql = "SELECT * 																		\n"
				    . "FROM text_image_flyers															\n"
				    . "INNER JOIN image_meta_data														\n"
				    . "ON text_image_flyers.text_image_flyer_image_meta_data_id = image_meta_data_id	\n"
				    . "where text_image_flyer_id = ('$flyer_id')";
		break;
		case "3":
				$sql = "SELECT * 																		\n"
				    . "FROM image_flyers																\n"
				    . "INNER JOIN image_meta_data														\n"
				    . "ON image_flyers.image_flyer_image_meta_data_id = image_meta_data_id				\n"
				    . "where image_flyer_id = ('$flyer_id')";
			break;
		}
		
		
		return $sql;
		
	}
		
	/*
     * void
     * redirect($destination)
     * 
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */

    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^http:\/\//", $destination))
            header("Location: " . $destination);

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }
    

	/*  show_error($message)
	 * function, which builds a show error page
	 */
	function show_error($message)
	{
		// require template
        require_once("error.php");

        // exit immediately since we're apologizing
        exit;
	}
	
	/* logout()
	 * function, which will logout the user and destroy its cookie
	 * set the cookie time for 99,000 for the corkboard
	 */
	function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (isset($_COOKIE[session_name()]))
        {
            if (preg_match("{^(/nowcorkit/)}", $_SERVER["REQUEST_URI"], $matches))
                setcookie(session_name(), "", time() - 99000, $matches[1]);
            else
                setcookie(session_name(), "", time() - 99000);
        }
        // destroy session
        session_destroy();
    }

?>