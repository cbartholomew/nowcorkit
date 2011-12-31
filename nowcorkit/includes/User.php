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
	public $session_id			= NULL;
	
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
	 * insert_forgot_password($session_id) 
	 * Inserts a new passowrd into the forgot_password table
	 */
	function update_password()
	{ 		
	
		// update the user's password
		$sql = "UPDATE users SET users_hash = ('$this->password_hash') where users_email = ('$this->email')";
		
		$result = mysql_query($sql) or die (show_error('Problem with updating your password'));
			
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
	}
	
	/*
	 * check_session_expired()
	 *
	 */
	function check_session_expired()
	{
		// create new object to pass back
		$user_session   		 = array();
		
		$user_session["fpid"]	 = 0;
		$user_session["found"]   = false;
		$user_session["expired"] = false;
		$user_session["email"]	 = $email;
	
		$sql	   = "SELECT * FROM forgot_password WHERE forgot_password_session_id = ('$this->session_id') AND forgot_password_users_email = ('$this->email')";		
		$result    = mysql_query($sql) or die (show_error('Problem with gathering session information'));
	   		
	    // if we found user, check password
	    if (mysql_num_rows($result) > 0)
	    {
	        // grab row
	        $row = mysql_fetch_array($result);
	        
			// compare the date time of the expired date
			// date time of now 
			$date_time 	     = new DateTime('now');
			
			// date time of created
			$expired_time    = new DateTime($row["forgot_password_session_expire"]);

			// interval date time
			$interval = $expired_time->diff($date_time);
			
			// check minutes
			$minutes = $interval->format('%I');
			
			// update ther user_session object
			$user_session["fpid"]	 = $row["forgot_password_id"];
			$user_session["found"]	 = true;
			$user_session["expired"] = ($minutes > 4) ? true : false;
			// return back object			
			return $user_session;
		}
		
		// return back default object
		return $user_session;	
	}
	
	/*
	 * check_session_expired()
	 *
	 */
	function check_session_expired_by_url()
	{
		// create new object to pass back
		$user_session   		 = array();
		
		$user_session["fpid"]	 = 0;
		$user_session["found"]   = false;
		$user_session["expired"] = false;
		$user_session["is_done"] = false;
		$user_session["email"]	 = "";
	
		
		$sql	   = "SELECT * FROM forgot_password WHERE forgot_password_session_id = ('$this->session_id')";		
		$result    = mysql_query($sql) or die (show_error('Problem with gathering session information'));
	   		
	    // if we found user, check password
	    if (mysql_num_rows($result) > 0)
	    {
	        // grab row
	        $row = mysql_fetch_array($result);
	        
			// compare the date time of the expired date
			// date time of now 
			$date_time 	     = new DateTime('now');
			
			// date time of created
			$expired_time    = new DateTime($row["forgot_password_session_expire"]);

			// interval date time
			$interval = $expired_time->diff($date_time);
			
			// check minutes
			$minutes = $interval->format('%I');
			
			// update ther user_session object
			$user_session["fpid"]	 = $row["forgot_password_id"];
			$user_session["found"]	 = true;
			$user_session["expired"] = ($minutes > 4) ? true : false;
			$user_session["is_done"] = ($row["forgot_password_email_sent"] == 0) ? false : true;
			$user_session["email"] = $row["forgot_password_users_email"];
			// return back object			
			return $user_session;
		}
		
		// return back default object
		return $user_session;	
	}
	
	
	/*
	 * update_expired_session($fpid, $urlhash)
	 * when user requesting a password, he or she's session will be updated
	 */
	function update_existing_session($fpid, $urlhash)
	{	
		$date_time = date('Y-m-d H:i:s');	

		$urlhash = urlencode($urlhash);
		
		$sql = "UPDATE forgot_password SET 																		 \n"
				. "forgot_password_session_id = '$this->session_id', 							 				 \n"	 
				. "forgot_password_session_expire = DATE_ADD('$date_time', INTERVAL 5 MINUTE), 					 \n"
				. "forgot_password_email_sent = 0,														 		 \n"
			    . "forgot_password_url_hash = '$urlhash'	 				  									 \n"
			    . "WHERE forgot_password_id = '$fpid'";
		
		$result    = mysql_query($sql) or die (show_error('Problem with password recovery information'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;		
	}
	
	/*
	 * insert_new_session($urlhash)
	 * inserts a new forgot password link if there is no email that macthes the session
	 */
	function insert_new_session($urlhash)
	{	
		$date_time = date('Y-m-d H:i:s');			
			
		$urlhash = urlencode($urlhash);
			
		$sql = "INSERT INTO forgot_password  											 	 \n"
				. "(																	 	 \n"
				. "forgot_password_session_id,												 \n"
				. "forgot_password_session_expire,											 \n"
				. "forgot_password_users_email,												 \n"
				. "forgot_password_email_sent,												 \n"
				. "forgot_password_url_hash													 \n"
				. ")																		 \n"
				. " values																 	 \n"
				. "(																	     \n"
				. "'$this->session_id', 					 								 \n"	 
				. "DATE_ADD('$date_time', INTERVAL 5 MINUTE), 							 	 \n"
				. "'$this->email',															 \n"
				. "0, 									 									 \n"
			    . "'$urlhash'	 				  			 								 \n"
			    . ")";
		
		$result    = mysql_query($sql) or die (show_error('Problem with password recovery information'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		$fpid = mysql_insert_id();
		
		return $fpid;		
	}
	
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