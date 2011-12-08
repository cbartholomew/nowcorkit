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

class Post{
	
	public $flyer = NULL;
	
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
		$sql = "insert into users 			\n"
			. "( 							\n"
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
			. " values 						\n"
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

 /* Object: Flyer
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
		public $created_dttm			= NULL;
		public $contact_id				= NULL;
		public $contact_name			= NULL;
		public $contact_info			= NULL;
		public $enable_qr				= NULL;
		public $qr_location_path		= NULL;
		public $qr_location_file 		= NULL;
		public $image_meta_data_id		= NULL;
		public $type					= NULL;
		public $type_id					= NULL;
		public $users_flyer_id			= NULL;
		public $qr_full_location		= NULL;
		public $image_path				= NULL;
		public $flyer_error_id			= NULL;
		public $flyer_message			= NULL;
		public $post_status_desc		= NULL;
		public $post_expiration			= NULL;
		public $board_post_id			= NULL;
		
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
				// insert the user in the database		
				$sql = $this->get_form_sql(); 					  	
						
				// run statement or die
				$result = mysql_query($sql) or die (show_error("Problem with inserting flyer into database"));
				
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
				
				// get the recent cork id
				$this->id = mysql_insert_id();
			
				return true;
	}
	/*
	 * insert_into_user_flyers()
	 * this function inserts data into the table, which services as the relation of user and flyers
	 */
	function insert_into_users_flyers()
	{
				// set the flyer type
				$this->set_flyer_type_id();
				
				// insert the user in the database		
				$sql = "insert into users_flyers 		\n"
					 . "( 								\n" 
					 . "users_flyers_users_cork_id, 	\n"
					 . "users_flyers_flyers_type_id, 	\n" 
					 . "users_flyers_flyers_id 			\n" 
					 . ") 								\n"
					 . "values							\n" 
					 . "(								\n"
					 . "'$this->cork_id', 				\n"
					 . "'$this->type_id', 				\n"
					 . "'$this->id' 					\n"
					 .")";  	
						
				// run statement or die
				$result = mysql_query($sql) or die (show_error($sql));
				
				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
				
				// get the recent users flyer id
				$this->users_flyer_id = mysql_insert_id();
				
				// If applicable, generate QR code image, save it, and update location in assoicated flyer table
				if ($this->type != 'image') { if ($this->enable_qr == "on") { $this->generate_qr(); $this->update_qr_location();}}
				
				return true;
				
	}
	
	/*
	 * delete_users_flyers()
	 * this function inserts data into the table, which services as the relation of user and flyers
	 */
	function delete_users_flyers()
	{
			// set the flyer type
			$this->set_flyer_type_id();
				
			// delete the users_flyer in the database		
			$sql = "DELETE FROM users_flyers 									  				\n"
				 . "WHERE users_flyers.users_flyers_id 				= ('$this->users_flyer_id')";

			 // run statement or die
			$result = mysql_query($sql) or die (show_error("Problem with removing users flyer from database"));
		
			// other than an error, there was a problem submitting the user
			if ($result == false) { return false; }
				
			return true;	
	}
	
	/*
	 * delete_post_flyers()
	 * this function inserts data into the table, which services as the relation of user and flyers
	 */
	function delete_post_from_flyers()
	{
			// delete the users_flyer in the database		
			$sql = "DELETE FROM board_posting 									  				\n"
				 . "board_post_users_flyers_id = ('$this->users_flyer_id')";

			 // run statement or die
			$result = mysql_query($sql) or die (show_error("Problem with removing post from postings"));
		
			// other than an error, there was a problem submitting the user
			if ($result == false) { return false; }
				
			return true;	
	}
	
	function update()
	{	
		// get the sql invovled for updating the database
		$sql = $this->get_update_form_sql(); 					  	
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error("Problem with updating flyer into database" . $sql));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
		
	}
	
	function delete()
	{	
		$this->delete_users_flyers();
		$this->delete_post_from_flyers();
		
		$sql = $this->get_delete_form_sql();
		
		// run statement or die
		$result = mysql_query($sql) or die (show_error("Problem with removing flyer from database"));

    	// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }

		// If applicable, generate QR code image, save it, and update location in assoicated flyer table
		if ($this->type == 'image' || $this->type =="text_image") 
		{ 
			// come back to this later
			
		}		

		return true;
			
		
	}
    
	/* 
	 *	set_flyer_type_id()
	 *  sets the $this->type_id to the proper id based on "type"
	 */ 
	function set_flyer_type_id(){
		
		//sets the $this->type_id to the proper based on "type"
			switch ($this->type)
			{
				case "text":
					$this->type_id = 1;
				break;
				
				case "text_image":
					$this->type_id = 2;
				break;
				
				case "image":
					$this->type_id = 3;
				break;
				
				default:
					$this->type_id = 0;
				break;		
			}	
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
		$url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=http://nowcorkit.com/generate.php?flyerid=' . $this->users_flyer_id;
			
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
		
	/*
	 *  get_form_sql()
	 * 	Keep the SQL in one function because it's pretty long for each flyer table
	 *  return the statement that shoulds be used depends on the specific flyer
	 */
	function get_form_sql()
	{
		$SQL = "";
		$date_time = date('Y-m-d H:i:s');
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
					. "'$this->image_meta_data_id',				\n"
					. "'$date_time'								\n"
					. ")";
			break;
			
			case "image":
				$SQL = "insert into image_flyers 			\n"
					. "( 									\n"
					. "image_flyer_title, 		 			\n"
					. "image_flyer_image_meta_data_id,		\n"
					. "image_flyer_users_cork_id,			\n"
					. "image_flyer_created_dttm 			\n"
					. ") 									\n"
					. " values 								\n"
					. "( 									\n"	
					. "'$this->title',						\n"
					. "'$this->image_meta_data_id',			\n"	
					. "'$this->cork_id', 					\n"
					. "'$date_time'							\n"
					. ")";
			break;			
			
			default:
			break;				
		}		
		return $SQL;	
	}
	/*
	 * get_update_form_sql()
	 * Allows the user to udpate SQL 
 	 */
	function get_delete_form_sql(){
		
			$SQL = "";
			// based on the page, prepare the proepr sql statement that should be used
			switch($this->type){

				case "text":
					$SQL = "DELETE FROM text_flyers 												\n"
						 . "WHERE text_flyers.text_flyer_id 				= ('$this->id')";
				break;			

				case "text_image":
					$SQL = "DELETE FROM text_image_flyers 											\n"
						 . "WHERE text_image_flyers.text_image_flyer_id 	= ('$this->id')";
				break;

				case "image":
					$SQL = "DELETE FROM image_flyers												\n"
						 . "WHERE image_flyers.image_flyer_id	 			= ('$this->id')";
				break;			
				default:
				break;				
			}		
			return $SQL;
		
	}
	
	/*
	 * get_update_form_sql()
	 * Allows the user to udpate SQL 
 	 */
	function get_update_form_sql(){
		
		$SQL = "";
		// based on the page, prepare the proepr sql statement that should be used
		switch($this->type){
			
			case "text":
				$SQL = "UPDATE text_flyers SET 															\n"
					 . "text_flyer_title 								= ('$this->title'), 			\n" 
					 . "text_flyer_desc 								= ('$this->description'), 		\n"
					 . "text_flyer_location 							= ('$this->location'), 			\n"
					 . "text_flyer_event_date 							= ('$this->event_date'),		\n" 
					 . "text_flyer_contact_type_id						= ('$this->contact_id') , 		\n" 
					 . "text_flyer_contact_name 						= ('$this->contact_name'), 		\n" 
					 . "text_flyer_contact_information 					= ('$this->contact_info'), 		\n" 
					 . "text_flyer_generate_qr_code 					= ('$this->enable_qr'), 		\n" 
					 . "text_flyer_users_cork_id 						= ('$this->cork_id')			\n" 
					 . "WHERE text_flyers.text_flyer_id 				= ('$this->id')";
			break;			
			
			case "text_image":
				$SQL = "UPDATE text_image_flyers SET 													\n"
					 . "text_image_flyer_title 							= ('$this->title'), 			\n" 
					 . "text_image_flyer_desc 							= ('$this->description'), 		\n"
					 . "text_image_flyer_location 						= ('$this->location'), 			\n"
					 . "text_image_flyer_event_date 					= ('$this->event_date'),		\n" 
					 . "text_image_flyer_contact_type_id				= ('$this->contact_id') , 		\n" 
					 . "text_image_flyer_contact_name 					= ('$this->contact_name'), 		\n" 
					 . "text_image_flyer_contact_information 			= ('$this->contact_info'), 		\n" 
					 . "text_image_flyer_generate_qr_code 				= ('$this->enable_qr'), 		\n" 
					 . "text_image_flyer_users_cork_id	 			    = ('$this->cork_id') 			\n" 
					 . "WHERE text_image_flyers.text_image_flyer_id 	= ('$this->id')";
			break;
			
			case "image":
				$SQL = "UPDATE image_flyers SET 														\n"
					 . "image_flyer_title 								= ('$this->title'), 			\n" 
				     . "image_flyer_users_cork_id						= ('$this->cork_id')			\n"			
					 . "WHERE image_flyers.image_flyer_id	 			= ('$this->id')";
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
				$SQL = "update text_flyers 																	   \n"
					.  "set text_flyer_qr_code_location = ('$this->qr_location_path$this->qr_location_file' )  \n"
					.  "where 																				   \n"
					.  "text_flyer_id = ('$this->id') 														   \n"
					.  "and  																				   \n"
					.  "text_flyer_users_cork_id = ('$this->cork_id')";	
			break;			
			case "text_image":
				$SQL = "update text_image_flyers 																	\n"
					.  "set text_image_flyer_qr_code_location = ('$this->qr_location_path$this->qr_location_file' ) \n"
					.  "where 																						\n"
					.  "text_image_flyer_id = ('$this->id') 														\n"
					.  "and  																						\n"
					.  "text_image_flyer_users_cork_id = ('$this->cork_id')";
			break;
			
			default:
			break;				
		}		
		return $SQL;	
	}
		
}
/* Object: Image
 * Used to contain information about the user. 
 */
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
		
		function delete($meta_id)
		{
					
			// prepare sql statement that will insert the user in the database		
			$sql = "DELETE FROM image_meta_data 											\n"
				 . "WHERE image_meta_data.image_meta_data_id 					= ('$meta_id')";
			
			// run statement or die
			$result = mysql_query($sql) or die (show_error('Problem with removing image from the database'));
			
			// other than an error, there was a problem submitting the user
			if ($result == false) { return false; }
					
			// all is good
			return true;
			
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
				$this->cork_id 							= $_SESSION['users_cork_id'];

	    }
						
		/*
		 *
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
				. " '$this->cork_id', 						\n" 
				. " '$date_time' 							\n" 
				. ")";
		
				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with inserting board into the database'));

				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }

				// get the newly assigned cork id. 
				$this->id = mysql_insert_id();

				return true;
		
		}
		
		/*
		 *
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
				. "board_pps_flyerdays 							= ('$this->pps_flyerdays')  		\n" 
				. "WHERE board_id 								= ('$this->id')";

				// run statement or die
				$result = mysql_query($sql) or die (show_error('Problem with updating board into the database'));

				// other than an error, there was a problem submitting the user
				if ($result == false) { return false; }
			
				return true;
		}
		
		/*
		 *
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
			 * delete_post_flyers()
			 * this function inserts data into the table, which services as the relation of user and flyers
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
		     *	post($posting)
			 *
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
		
	
	
	
}
?>