<?
/***********************************************************************
 * forgot_password.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/14/2011
 * Purpose		  : based on users' email, will send temporary link to reset password.
 **********************************************************************/
	
	require_once("includes/class_objects.php");
	require_once("includes/constants.php");
	require_once("includes/DAL.php");

	session_start();
	// initalize new user
	$u = new User(null);
	// assign email to object
	$u->email = $_SESSION["email"];
	// create user_session array
	$user_session = array();
	// obtain my session id
	$u->session_id = session_id();
	// check if the session is expired
	$user_session = $u->check_session_expired();
		
	if (!$user_session["found"])
	{
		//create new entry
		echo "not found";	
			$old_sessionid = session_id();
			echo $old_sessionid;
	}
	else
	{
		// user is found, so we'll regenerate a new session id and update that and its expiration
		session_regenerate_id();				
		// user is found, so we'll just update the table with a new expire date
		$u->session_id = session_id();
		echo $u->session_id;	
		//$u->update_session();
		
	}
	
	
	
	
	// $saved_session = '3dc5b88934a53794f4740a466c8966e1';
	// 	$is_expired = false;
	// 	// start session
	// 	session_start();
	// 	// obtain my session id
	// 	$my_session = session_id();
	// 	
	// 	// 	check if the user's the session is the same (probably should go into the insert)
	// 	// 	$is_expire = true;
	// 	// incase they need another e-mail sent to them, and if the session expired - then regengerate a new id - kill the old one
	// 	// 1. ask for session expire dttm - if dttm is past, generate new id & update the dttm. 
	// 	if ($my_session == $saved_session)
	// 	{
	// 		// is the flag expired?
	// 		if ($is_expired == true)
	// 		{	
	// 	 		session_regenerate_id();
	// 		}
	// 	}
	// 	
	// 	// 	check if the user's the session is the same based on the GET?
	// 	//  check if it has expired.
	// 	// 	$is_expire = true;
	// 	// is the flag expired? 
	// 	if ($my_session == $saved_session) { if (!$is_expired) { RenderResetPassword() } }
	// 	
	// 	
	// 	// echo out the session

	
	
?>