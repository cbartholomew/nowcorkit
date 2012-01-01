<?
/***********************************************************************
* Flyer.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Flyer Object
**********************************************************************/

 /* Object: Flyer
  * Used to contain infomration and methods controlling flyers
  * A very important object, and if one passed the entire $_POST request
  * from a text/image flyer menu into the constructor, this would create the object
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
		public $post_status_id			= NULL;
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
	 * this function will delete the linkage between a user and a flyer
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
	 * this function will delete a flyer post, which has been already created
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
	/* update()
	 * this function will update the text of a specific flyer with  new information
	 */
	function update()
	{	
		// get the sql invovled for updating the database, this depends on text/text/image/and image
		$sql = $this->get_update_form_sql(); 					  	
				
		// run statement or die
		$result = mysql_query($sql) or die (show_error("Problem with updating flyer into database" . $sql));
		
		// other than an error, there was a problem submitting the user
		if ($result == false) { return false; }
		
		return true;
		
	}
	/*
	 * delete()
	 * Used to remove flyers from the database and unlink users_flyers
	 */
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
		$url = 'https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=http://nowcorkit.com/generate.php?flyerid=' . $this->users_flyer_id;
			
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

?>