<?
 require_once('#!/common.php');
 	
 /***********************************************************************
  * register_user.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 11/26/2011
  * Purpose		  : register's user inside of the database
  **********************************************************************/

  // pass the form data into the user object constructor
  $new_user = new User($_POST);
  $new_user->hash_password();	
  // insert the new user into the database;
  $new_user->insert();
	
  // set the session to the newly registered id
  $_SESSION["users_cork_id"] = $new_user->cork_id;

  // redirect the user to the menu page
  redirect("menu.php");
?>