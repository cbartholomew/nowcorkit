<?
/***********************************************************************
 * logout.php
 * Author		  : Christopher Bartholomew
 * Last Updated   : 11/26/2011
 * Purpose		  : logs the user out by destroying any session states, which belong to nowcorkit.com
 **********************************************************************/
// require common code
require_once("#!/common.php"); 
// log out current user, if any
logout();
// redirect back to index after session is destroyed.
redirect("index.php");
?>