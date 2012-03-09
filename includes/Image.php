<?
/***********************************************************************
* Image.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Image Object
**********************************************************************/
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
		/* delete($meta_id)
		 * Will delete the image meta data from the database
		 */
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
		/* insert()
		 * Will insert a new row in the image_meta_data table
		 */
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