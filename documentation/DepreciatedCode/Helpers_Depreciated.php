<?
/* [DEPRECIATED WITH oAUTH management]
 * ValidateNormalLogin($_FORMDATA)
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

/* [DEPRECIATED]	
 * ValidateNewRegistration($_FORMDATA)
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

?>