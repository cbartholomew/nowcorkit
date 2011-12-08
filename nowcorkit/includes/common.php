<?

    /***********************************************************************
     * common.php
	 * Author		: Christopher Bartholomew
	 * Last Updated : 11/13/2011
	 * Purpose		: Opens connection to MySQL server & Loads additional helpers
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
	require_once("DAL.php");
	require_once("helpers.php");
	require_once("class_objects.php");
	
	//require authentication for most pages
    if (!preg_match("{/(:?login|register|logout)\d*\.php$}", $_SERVER["PHP_SELF"]))
        {
           if (!isset($_SESSION["users_cork_id"]))
		   {
               redirect("login.php");
		   }
        }		
?>
