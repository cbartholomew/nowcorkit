<?
/*
 * hash_password($password)
 * hashes the user's password
 */
function hash_password()
{
	$this->password_hash = crypt($this->password_hash);		
}

/* 
 * check_session_expired()
 * Checks
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
		$user_session["email"] 	 = $row["forgot_password_users_email"];
		// return back object			
		return $user_session;
	}
	
	// return back default object
	return $user_session;	
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


?>