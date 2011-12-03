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
		$sql = "insert into users 			\n"
			. "( 							\n" 
			. "users_email, 				\n" 
			. "users_hash,users_first_name, \n"
			. "users_last_name, 			\n"
			. "users_state_id, 				\n"
			. "users_subscription_type, 	\n"
			. "users_last_login, 			\n"
			. "users_account_disable 		\n"
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
			. " '0' 						\n"
			. ")";
				
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
		$sql = "insert into facebook_users 		\n"
			. "( 								\n" 
			. "facebook_users_id, 				\n" 
			. "facebook_users_name, 			\n" 
			. "facebook_users_first_name, 		\n" 
			. "facebook_users_last_name, 		\n" 
			. "facebook_users_link, 			\n"
			. "facebook_users_username, 		\n" 
			. "facebook_users_gender, 			\n" 
			. "facebook_users_locale, 			\n" 
			. "facebook_users_location_id, 		\n"
			. "facebook_users_location_name 	\n"
			. ") 								\n"
			. " values 							\n"
			. "( 								\n"
			. "'$this->id', 					\n"
			. "'$this->name', 					\n" 
			. "'$this->first_name', 			\n" 
			. "'$this->last_name', 				\n" 
			. "'$this->link', 					\n" 
			. "'$this->username', 				\n"
			. "'$this->gender', 				\n" 
			. "'$this->locale', 				\n" 
			. "'$this->location_id', 			\n" 
			. "'$this->location_name' 			\n"
			. ")";
				
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
			. "( \n"
			. "users_facebook_users_id, 	\n"
			. "users_email,					\n"
			. "users_hash,					\n"
			. "users_first_name, 			\n"
			. "users_last_name,				\n"
			. "users_state_id,				\n"
			. "users_subscription_type, 	\n"
			. "users_last_login, 			\n"
			. "users_account_disable, 		\n"
			. "users_created_dttm 			\n"
			. ")  							\n"
			. " values "
			. "( 							\n" 
			. "'$this->id', 				\n"
			. "'NULL',						\n"
			. "'NULL',						\n"
			. "'$this->first_name',			\n" 
			. "'$this->last_name', 			\n"
			. "'0',							\n"
			. "'0', 						\n"
			. "'$date_time',				\n"
			. "'0',							\n"
			. "'$date_time'					\n"
			. ")";
				
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
		public $title 					= NULL;
		public $description 			= NULL;
		public $location				= NULL;
		public $event_date				= NULL;
		public $contact_id				= NULL;
		public $contact_name			= NULL;
		public $contact_info			= NULL;
		public $enable_qr				= NULL;
		public $qr_location_path		= NULL;
		public $qr_location_file 		= NULL;
		public $image_meta_data_id		= NULL;
		public $type					= NULL;
		
		/*
		 * __construct($_DATA) 
		 * Contructs a user object based on the form data
		 */
	    function __construct($_DATA) 
		{
			$this->title   					= mysql_real_escape_string($_DATA["title"]);
			$this->description				= mysql_real_escape_string($_DATA["description"]);
			$this->location					= mysql_real_escape_string($_DATA["location"]);
			$this->event_date   			= mysql_real_escape_string($_DATA["event_date"]);
			$this->contact_id   			= mysql_real_escape_string($_DATA["contact_id"]);
			$this->contact_name   			= mysql_real_escape_string($_DATA["contact_name"]);
			$this->contact_info   			= mysql_real_escape_string($_DATA["contact_info"]);
			$this->enable_qr	   			= mysql_real_escape_string($_DATA["enable_qr"]);
			$this->type						= mysql_real_escape_string($_DATA["flyer_type"]);
			$this->cork_id					= $_SESSION["users_cork_id"];
	    }
	/*
	 * insert()
     * Based on the data from the form post, this will submit the the text flyer in the system 
	 */	
	function insert()
	{
				$date_time = date('Y-m-d H:i:s');
				// insert the user in the database		
				$sql = $this->get_form_sql(); 
					  			
				// run statement or die
				$result = mysql_query($sql) or die (show_error($sql));
				
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
				
				// get the recent cork id
				$this->id = mysql_insert_id();
				
				// don't need to generate QR code for image only flyers
				if ($this->type != 'image')
				{
					// Generate QRCode Image, Save It, Update Location
					if ($this->enable_qr == "on") { $this->generate_qr(); $this->update_qr_location();}
				}
				
				// all is good
				return true;
	}
	
	/*
	 * generate_qr()
     * This will generate a QRCode Image, store it as FLYERID_CORKID.PNG in CORK_ID folder
	 */
	function generate_qr()
	{
		// build file name and location
		$this->qr_location_path = "flyers/qrcodes/"; 
		$this->qr_location_file = "qr" . "_" . $this->id . "_" . $this->cork_id . ".png";
	
		// use the google chart API to generate QR code
		$url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=http://nowcorkit.com/generate.php?flyerid=' . $this->id;
			
		// create the file based on the path and filename in generate_qr()
		$img = $this->qr_location_path . $this->qr_location_file;	
			
		// write contents of the data to file using cURL
		$ch = curl_init($url);
		$fp = fopen($img, 'wb');
			  curl_setopt($ch, CURLOPT_FILE, $fp);
			  curl_setopt($ch, CURLOPT_HEADER, 0);
			  curl_exec($ch);
		 	  curl_close($ch);
			  fclose($fp);				
	}
	
	/* update_qr_location()
     * This will update the flyer table with the QR Code's location path and file name
	 */
	function update_qr_location()
	{
		// based on the flyer type, get sql
		$sql = $this->get_qr_sql();

		// run statement or die
		$result = mysql_query($sql) or die (show_error('Problem with updating qrcode in the database'));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		// all is good, i'd hope.
		return true;			
	}
	
	function update()
	{	
		
		
	}
	
	function delete()
	{
		
	}		
	
	/*
	 *  get_form_sql()
	 * 	Keep the SQL in one function because it's pretty long for each flyer table
	 *  return the statement that shoulds be used depends on the specific flyer
	 */
	function get_form_sql()
	{
		$SQL = "";
				
		// based on the page, prepare the proepr sql statement that should be used
		switch($this->type){
			
			case "text":
			$SQL = "insert into text_flyers 		\n"
				. "( 								\n"
				. "text_flyer_title, 		 		\n"
				. "text_flyer_desc, 		 		\n"
				. "text_flyer_location, 	 		\n"
				. "text_flyer_event_date, 	 		\n"
				. "text_flyer_contact_type_id, 		\n"
				. "text_flyer_contact_name, 		\n"
				. "text_flyer_contact_information, 	\n"
				. "text_flyer_generate_qr_code, 	\n" 
				. "text_flyer_qr_code_location, 	\n"
				. "text_flyer_users_cork_id,		\n"
				. "text_flyer_created_dttm 			\n"
				. ") 								\n"
				. " values 							\n"
				. "( 								\n"	
				. "'$this->title',					\n"
				. "'$this->description',			\n"
				. "'$this->location',				\n"
				. "'$this->event_date',				\n"
				. "'$this->contact_id',				\n"
				. "'$this->contact_name', 			\n"
				. "'$this->contact_info', 			\n"
				. "'$this->enable_qr', 				\n"
				. "'$this->qr_location', 			\n"
				. "'$this->cork_id', 				\n"
				. "'$date_time'						\n"
				. ")";			
			break;			
			case "text_image":
				$SQL = "insert into text_image_flyers 			\n"
					. "( 										\n"
					. "text_image_flyer_title, 		 			\n"
					. "text_image_flyer_desc, 		 			\n"
					. "text_image_flyer_location, 	 			\n"
					. "text_image_flyer_event_date, 			\n"
					. "text_image_flyer_contact_type_id,		\n"
					. "text_image_flyer_contact_name, 			\n"
					. "text_image_flyer_contact_information,	\n"
					. "text_image_flyer_generate_qr_code, 		\n" 
					. "text_image_flyer_qr_code_location, 		\n"
					. "text_image_flyer_users_cork_id,			\n"
					. "text_image_flyer_image_meta_data_id,		\n"
					. "text_image_flyer_created_dttm 			\n"
					. ") 										\n"
					. " values 									\n"
					. "( 										\n"	
					. "'$this->title',							\n"
					. "'$this->description',					\n"
					. "'$this->location',						\n"
					. "'$this->event_date',						\n"
					. "'$this->contact_id',						\n"
					. "'$this->contact_name', 					\n"
					. "'$this->contact_info', 					\n"
					. "'$this->enable_qr', 						\n"
					. "'$this->qr_location', 					\n"			
					. "'$this->cork_id', 						\n"
					. "'$image_meta_data_id',					\n"
					. "'$date_time'								\n"
					. ")";
			break;
			
			case "image":
			
			break;			
			
			default:
			break;				
		}		
		return $SQL;	
	}
	
	/*
	 *  get_qr_sql()
	 * 	Keep the SQL in one function because it's pretty long for each flyer table
	 *  return the statement that shoulds be used depends on the specific flyer
	 */
	function get_qr_sql()
	{
		$SQL = "";
				
		// based on the page, prepare the proepr sql statement that should be used
		switch($this->type){
			
			case "text":
				$SQL = 	"update text_flyers \n"
					.  "set text_flyer_qr_code_location = ('$this->qr_location_path$this->qr_location_file' ) \n"
					.  "where \n"
					.  "text_flyer_id = ('$this->id') \n"
					.  "and  \n"
					.  "text_flyer_users_cork_id = ('$this->cork_id')";	
			break;			
			case "text_image":
				$SQL = "update text_image_flyers \n"
					.  "set text_image_flyer_qr_code_location = ('$this->qr_location_path$this->qr_location_file' ) \n"
					.  "where \n"
					.  "text_image_flyer_id = ('$this->id') \n"
					.  "and  \n"
					.  "text_image_flyer_users_cork_id = ('$this->cork_id')";
			break;
			
			default:
			break;				
		}		
		return $SQL;	
	}
		
}
	
class Image
{
		
		// create properties
		public $id 			= NULL;
		public $file_name 	= NULL;
		public $type 		= NULL;
		public $size 		= NULL;
		public $location 	= NULL;
		public $cork_id 	= NULL;

		/*
		 * __construct($_DATA) 
		 * Contructs a user object based on the form data
		 */
	    function __construct($_DATA) 
		{
			$this->id   					= $_DATA["image_meta_data"]["id"];
			$this->file_name				= $_DATA["image_meta_data"]["name"];
			$this->type						= $_DATA["image_meta_data"]["type"];
			$this->size   					= $_DATA["image_meta_data"]["size"];
			$this->location   				= $_DATA["image_meta_data"]["location"];
			$this->cork_id					= $_SESSION["users_cork_id"];
	    }
		
		function insert()
		{
			// append the user's cork_id to the image
			$this->file_name = $this->cork_id . "_" . $this->file_name;
			
			// get current date time
			$date_time = date('Y-m-d H:i:s');
			
			// prepare sql statement that will insert the user in the database		
			$sql = "insert into image_meta_data 	\n"
				. "( 								\n"
				. "image_meta_data_file_name, 		\n"
				. "image_meta_data_type, 		 	\n"
				. "image_meta_data_size, 	 		\n"
				. "image_meta_data_image_location, 	\n"
				. "image_meta_data_users_cork_id, 	\n"
				. "image_meta_data_created_dttm 	\n"
				. ") 								\n"
				. " values 							\n"
				. "( 								\n"	
				. "'$this->file_name',				\n"
				. "'$this->type',					\n"
				. "'$this->size',					\n"
				. "'$this->location',				\n"
				. "'$this->cork_id',				\n"
				. "'$date_time'						\n"
				. ")";
			
			// run statement or die
			$result = mysql_query($sql) or die (show_error('Problem with inserting image into the database'));
			
			// other than an error, there was a problem submitting the user
			if ($result == false) { return false; }
			
			// get the newly created image_meta_data_id to associate it to the flyer text
			$this->id = mysql_insert_id();
					
			// all is good
			return true;
		}
	
}

?>