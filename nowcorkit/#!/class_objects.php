<?

/***********************************************************************
* class_objects.php
* Author		: Christopher Bartholomew
* Last Updated  : 11/13/2011
* Purpose		: file, which holds my class objects and its functions
**********************************************************************/



/*
 * Object: State
 * Used to contain state information from the database
 */
class State
{	
	public $id = NULL;
	public $name = NULL;
}


/*
 * Object: User
 * Used to contain information about the user. 
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
	 * insert()
	 * inserts the new user into the database
	 */
	function insert()
	{
		
		$date_time = date('Y-m-d H:i:s');
		// insert the user in the database		
		$sql = "insert into users \n"
			. "(users_email, users_hash,users_first_name, users_last_name, \n"
				. "users_state_id,users_subscription_type,users_last_login,users_account_disable) \n"
			. "values \n"
			. "('$this->email','$this->password_hash','$this->first_name','$this->last_name', '$this->state_id', \n"
				. "'0', '$date_time', '0')";
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with inserting user into the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		// get the newly assigned cork id. 
		$this->cork_id = mysql_insert_id();
	
		return true;	
	}
	
}

/*
 * Object: FacebookUser
 * Used to contain information about the user. 
 */
class FacebookUser
{	
	public $cork_id				= NULL;
	public $id					= NULL;
	public $name 				= NULL;
	public $first_name   		= NULL;
	public $last_name			= NULL;
	public $link				= NULL;
	public $username			= NULL;
	public $gender   			= NULL;
	public $locale				= NULL;
	public $location_id 		= NULL;
	public $location_name 		= NULL;		
	
	
	/*
	 * __construct($_DATA) 
	 * Contructs a user object based on the form data
	 */
    function __construct($_DATA) 
	{
		
		$this->id					= $_DATA->id;
		$this->name 				= $_DATA->name;
		$this->first_name   		= $_DATA->first_name;
		$this->last_name			= $_DATA->last_name;
		$this->link					= $_DATA->link;
		$this->username				= $_DATA->username;
		$this->gender   			= $_DATA->gender;
		$this->locale				= $_DATA->locale;
		$this->location_id 			= $_DATA->location->id;
		$this->location_name 		= $_DATA->location->name;		
		
    }
	
	/*
	 * insert()
	 * inserts the new user into the database
	 */
	function insert()
	{
	
		// insert the user in the database		
		$sql = "insert into facebook_users \n"
			. "(facebook_users_id, facebook_users_name, facebook_users_first_name, facebook_users_last_name, facebook_users_link, \n"
			. "facebook_users_username, facebook_users_gender, facebook_users_locale,facebook_users_location_id, facebook_users_location_name) \n"
			. "values \n"
			. "('$this->id','$this->name','$this->first_name','$this->last_name','$this->link', '$this->username', \n"
			. "'$this->gender', '$this->locale', '$this->location_id', '$this->location_name')";
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with inserting facebook user into the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;	
	}
	/*
	 * insert_into_users()
	 * inserts the new user into the database with assoicated facebook id
	 */
	function insert_into_users()
	{
		$date_time = date('Y-m-d H:i:s');
		// insert the user in the database		
		$sql = "insert into users "
			. "(users_facebook_users_id, users_email, users_hash,users_first_name, users_last_name,"
			. "users_state_id, users_subscription_type, users_last_login, users_account_disable, users_created_dttm) "
			. "values "
			. "('$this->id','NULL','NULL','$this->first_name','$this->last_name', '0',"
			. "'0', '$date_time', '0','$date_time')";
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with inserting user into the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		// get the newly assigned cork id. 
		$this->cork_id = mysql_insert_id();
	
		return true;
	
	}
	
}

 /* Object: FacebookUser
  * Used to contain information about the user. 
  */
class Flyer
{
		
		public $id 						= NULL;
		public $cork_id					= NULL;
		public $contact_name			= NULL;
		public $title 					= NULL;
		public $desc 					= NULL;
		public $location				= NULL;
		public $contact_id				= NULL;
		public $contact_desc			= NULL;
		public $enable_qr				= NULL;
		public $qr_blob					= NULL;
		public $image_meta_data_id		= NULL;
		
		/*
		 * __construct($_DATA) 
		 * Contructs a user object based on the form data
		 */
	    function __construct($_DATA) 
		{
			$this->title   					= mysql_real_escape_string($_DATA["title"]);
			$this->description				= mysql_real_escape_string($_DATA["description"]);
			$this->location					= mysql_real_escape_string($_DATA["location"]);
			$this->name						= mysql_real_escape_string($_DATA["name"]);
			$this->type						= mysql_real_escape_string($_DATA["type"]);
			$this->contact   				= mysql_real_escape_string($_DATA["contact"]);
			$this->cork_id					= $_SESSION["cork_id"];

	    }
	
	function insert()
	{
		// LEFT OFF HERE - MAKE SURE YOU FIX THE QUERY TO MATCH TABLE CHANGES!!!!!
				$date_time = date('Y-m-d H:i:s');
				// insert the user in the database		
				$sql = "insert into text_flyers \n"
					. "(text_flyer_title, text_flyer_desc, text_flyer_location, text_flyer_contact_type_id, text_flyer_contact_name_or_email, \n"
					. "text_flyer_generate_qr_code, text_flyer_qr_code, text_flyer_users_cork_id, text_flyer_created_dttm) \n"
					. "values \n"
					. "('$this->title','$this->desc','$this->location','$this->contact_id','$this->contact_desc', '$this->enable_qr', \n"
					. "'$this->qr_blob', '$this->cork_id', '$date_time')";
						
				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with inserting text flyer into the database'));
				
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
				
				return true;
		
	}
	
	function generateQR()
	{

	}
	
	function update()
	{	
		
	}
	
	function delete()
	{
		
	}		
		
}
		
class Image
{
	
	
	
	
}

?>