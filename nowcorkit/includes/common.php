<?

 /***********************************************************************
 * common.php
 * Author		: Christopher Bartholomew
 * Last Updated : 12/08/2011
 * Purpose		: Used to control sessions and loading of additional helpers. 
 * this also includes the creating of session variables
 **********************************************************************/
    
	// display errors and warnings but not notices
    ini_set("display_errors", true);
    error_reporting(E_ALL ^ E_NOTICE);

	//enable sessions, restricting cookie to /nowcorkit/
    if (preg_match("{^(/)}", $_SERVER["REQUEST_URI"], $matches))
           session_set_cookie_params(0, $matches[1]);
        session_start();

 	// requirements 
 	require_once("constants.php");
	require_once("class_objects.php");
	require_once("DAL.php");
	require_once("helpers.php");

	
	//require authentication for most pages
    if (!preg_match("{/(:?login|register|logout)\d*\.php$}", $_SERVER["PHP_SELF"]))
        {
           if (!isset($_SESSION["users_cork_id"]))
		   {
               redirect("login.php");
		   }
        }		
?>
