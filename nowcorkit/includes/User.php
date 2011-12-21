<?
/***********************************************************************
* User.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: User Object
**********************************************************************/

/*
 * Object: User
 * Used to contain information about the user. 
 * General User object
 */
class User
{	
 	public $cork_id				= NULL;
	public $email 				= NULL;
	public $password_hash   	= NULL;
	public $first_name			= NULL;
	public $last_name			= NULL;
	public $state_id			= NULL;
	public $subscription_type   = NULL;
	
	/*
	 * __construct($_DATA) 
	 * Contructs a user object based on the form data
	 */
    function __construct($_DATA) 
	{
      $this->email 			= mysql_real_escape_string($_DATA["email"]);
	  $this->first_name		= mysql_real_escape_string($_DATA["firstname"]);
	  $this->last_name		= mysql_real_escape_string($_DATA["lastname"]);
	  $this->password_hash  = mysql_real_escape_string($_DATA["password"]);
	  $this->state_id	    = $_DATA["state"];	
    }

	/*
	 * hash_password($password)
	 * hashes the user's password
	 */
	function hash_password()
	{
		$this->password_hash = crypt($this->password_hash);		
	}
	
	
	
	/*
	 * 
	 */
	
	/*
	 * insert()
	 * inserts the new user into the database
	 */
	function insert()
	{
		
		$date_time = date('Y-m-d H:i:s');
		// insert the user in the database		
		$sql = "insert into users 			\n"
			. "( 							\n" 
			. "users_email, 				\n" 
			. "users_hash,users_first_name, \n"
			. "users_last_name, 			\n"
			. "users_state_id, 				\n"
			. "users_subscription_type, 	\n"
			. "users_last_login, 			\n"
			. "users_account_disable, 		\n"
			. "users_created_dttm			\n"
			. ") 							\n"
			. " values 						\n"
			. "( 							\n"
			. "'$this->email', 				\n" 
			. "'$this->password_hash', 		\n" 
			. "'$this->first_name',			\n" 
			. "'$this->last_name', 			\n" 
			. "'$this->state_id', 			\n"
			. "'0',							\n"
			. "'$date_time', 				\n"
			. " '0', 						\n"
			. "'$date_time' 				\n"
			. ")";
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with inserting user into the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		// get the newly assigned cork id. 
		$this->cork_id = mysql_insert_id();
	
		return true;	
	}
	
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