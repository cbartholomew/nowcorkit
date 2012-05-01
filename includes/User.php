<?
/***********************************************************************
* User.php
* Author		: Christopher Bartholomew
* Last Updated  : 04/26/2012
* Purpose		: User Object
**********************************************************************/



/*
 * Object: User
 * Used to contain information about the user. 
 * General User object
 */
class User
{	                                            
 	public $cork_id				   			= NULL; 
	public $email 				   			= NULL; 
	public $password_hash   	   			= NULL; 
	public $first_name			   			= NULL; 
	public $last_name			   			= NULL; 
	public $state_id			   			= NULL; 
	public $subscription_type      			= NULL; 
	public $session_id			   			= NULL; 
	public $third_party_user_id    			= NULL; 
	public $third_party_user_account_type 	= NULL;
	
	/*
	 * __construct($_DATA) 
	 * Contructs a user object based on the form data
	 */
    function __construct($ACCOUNT_TYPE) 
	{
		$this->third_party_user_account_type = $ACCOUNT_TYPE;
    }
	
	/*
	 * set_google_plus_user($_ACCOUNT)
	 * Sets the properties for the user account
	 *
	 */
	function set_google_plus_user($_ACCOUNT)
	{
		$this->third_party_user_id  = $_ACCOUNT["id"];           
		$this->email  			    = $_ACCOUNT["email"];        
		$this->first_name		    = $_ACCOUNT["given_name"];   
		$this->last_name		    = $_ACCOUNT["family_name"];     
		$this->state_id			    = 0;                         
	}
		
	/*
	 * insert()
	 * inserts the new user into the database
	 */
	function insert()
	{
		
		$date_time = date('Y-m-d H:i:s');
		// insert the user in the database	   	        
		$sql = "insert into users 			   	   			\n"
			. "( 							   	   			\n"
			. "users_third_party_account_id, 		   	   	\n"	 
			. "users_third_party_account_type_id,			\n" 
			. "users_email, 				   	   			\n"
			. "users_hash,									\n"
			. "users_first_name,    	   					\n"
			. "users_last_name, 			   	   			\n"
			. "users_state_id, 				   	   			\n"
			. "users_subscription_type, 	   	   			\n"
			. "users_last_login, 			   	   			\n"
			. "users_account_disable, 		   	   			\n"
			. "users_created_dttm			   	   			\n"
			. ") 							   	   			\n"
			. " values 						   	   			\n"
			. "( 							   	   			\n"
			. "'$this->third_party_user_id',  	   			\n"
			. "'$this->third_party_user_account_type',		\n"
			. "'$this->email', 				   	   			\n" 
			. "'$this->password_hash', 		   				\n" 
			. "'$this->first_name',			   				\n" 
			. "'$this->last_name', 			   				\n" 
			. "'$this->state_id', 			   				\n"
			. "'0',							   				\n"
			. "'$date_time', 				   				\n"
			. " '0', 						   				\n"
			. "'$date_time' 				   				\n"
			. ")";
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with inserting user into the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		// get the newly assigned cork id. 
		$this->cork_id = mysql_insert_id();
		
		// update user account
		$this->update_login_time_and_count();
		
		return true;	
	}
	
	/*
	 * update()
	 * updates user's account information always to keep sync. 
	 */
	function update()
	{
	    // make updates
		$this->set_users_cork_id();
		$this->update_existing_user_account();
			
	}
	
	/*
	 * set_users_cork_id()
	 * lazy association of cork id in session variables or this->cork_id
	 */
	function set_users_cork_id()
	{
		if(!isset($_SESSION["users_cork_id"])) 
		{
			$sql 	   = "SELECT users_cork_id FROM users WHERE users_email = '$this->email'";			
			$result    = mysql_query($sql) or die (show_error('Problem with getting user account info on update'));
			//check if the user has a cork_id - create user if none is there
		    if (mysql_num_rows($result) == 0) { return 0; }
		    else 
	   		{				
	   			while($row = mysql_fetch_array($result))
	   			{
	   				$this->cork_id = $row["users_cork_id"];	
					break;
	   			}	
	   		}
			
			$_SESSION["users_cork_id"] = $this->cork_id;
			$this->update_login_time_and_count();
		}
	}
	
	/*
	 * update_existing_user_account() 
	 * updates the current user account with new information
	 */
	function update_existing_user_account()
	{
		$sql = "UPDATE users SET  														\n"
		. "users_third_party_account_id 	 = '$this->third_party_user_id', 			\n"
		. "users_third_party_account_type_id = '$this->third_party_user_account_type',  \n"
		. "users_first_name					 = '$this->first_name',						\n"
		. "users_last_name					 = '$this->last_name' 						\n"
		. "where users_email				 = '$this->email'							\n";
		
		$result    = mysql_query($sql) or die (show_error('Problem with updating user information'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;	
	}
	
	/*
	 * update_registration_info_by_cork_id($case) 
	 * updates the state or location of the user
	 */
	function update_registration_info_by_cork_id($case)
	{
		// update the user's password	
		$sql = "";
		switch($case)
		{
			// state only
			case 0:
			$sql = "UPDATE users SET users_state_id = ('$this->state_id') where users_cork_id = ('$this->cork_id')";
			break;		
		}
	
		$result = mysql_query($sql) or die (show_error('Problem with updating your account info'));
			
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
	}
	
	/*
	 * update_login_time_and_count()
	 * update the login count and time when people login
	 */
	function update_login_time_and_count()
	{
		$date_time = date('Y-m-d H:i:s');
		
		// insert the user in the database	
		$sql = "update users set users_last_login = ('$date_time'), users_login_count = users_login_count + 1 where users_cork_id = ('$this->cork_id')";	

		// run statement or die
		$result = mysql_query($sql) or die (show_error("Problem with updating user"));

		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
	}       
}


?>