<?
/***********************************************************************
* FacebookUser.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: FacebookUser Object
**********************************************************************/
/*
 * Object: FacebookUser
 * Used to contain information about the user. 
 * Not Used - at least until I get oAuth back up
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


?>