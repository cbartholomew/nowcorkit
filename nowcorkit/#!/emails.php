<?
 require_once('common.php');
 	
 /***********************************************************************
  * emails.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 11/13/2011
  * Purpose		  : checks for e-mail inside the database for front end validation
  **********************************************************************/
 $email = mysql_real_escape_string($_POST["email"]);
 $valid = LookupEmail($email);
 echo $valid;

?>