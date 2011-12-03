<?

	require_once("constants.php");
	require_once("DAL.php");
	require_once("class_objects.php");
	
	/***********************************************************************
	* helpers.php
	* Author		: Christopher Bartholomew
	* Last Updated  : 11/13/2011
	* Purpose		: Provides helper functions for application
	**********************************************************************/

	/*
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

	            // redirect to portfolio
	            redirect("/nowcorkit/menu.php");
	        }
	    }
	
		return false;
	}
	
	/*
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
     * Purpose: Based on the hashed passwords passed into function
     * check and make sure the password hashes match 
     */
    function ComparePasswords($password_one, $password_two)
    {
        // compare values
       // if ($password_one != $password_two) { return false; }
   	  return ($password_one == $password_two) ? true : false;

      
    }
	
	/*
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
	
	/*
	 * Checks if user's email is valid
	 */
	function ValidEmail($email_address)
	{
		
		if(preg_match("/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9-])+.([a-zA-Z0-9-.])+$/", $email_address)) {return true;}
	 	return false;
	}
	
	/*
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

	/*
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
    
	/*
     * void
     * dump($variable)
     *
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        // dump variable with some quick and dirty HTML
        require("dump.php");

        // exit immediately so that we can see what we printed
        exit;
    }
	/*
	 * function, which builds a show error page
	 */
	function show_error($message)
	{
		// require template
        require_once("error.php");

        // exit immediately since we're apologizing
        exit;
	}
	
	/*
	 * function, which will logout the user and destroy its cookie
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