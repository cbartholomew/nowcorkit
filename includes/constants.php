<?

/***********************************************************************
* constants.php
* Author		: Christopher Bartholomew
* Last Updated  : 11/28/2011
* Purpose		: Provides Global Constants for application. 
* For demo, please use test as the production is to my third party server. ;-(  
**********************************************************************/
/*
// TEST 

    // your database's Information
    define("DB_NAME"			, "nowcorkitdb");
    define("DB_SERVER"			, "localhost");
    define("DB_USERNAME"		, "root");
    define("DB_PASSWORD"		, "root");

	// google API information
	define("GCLIENT_ID"				, "861149793626.apps.googleusercontent.com");
	define("GCLIENT_SECRET"			, "Tv2im0BvO6Ca2YszIp7e-Iix");    
	define("GCLIENT_REDIRECT_URL"	, "http://localhost/nowcorkit/main.php");
	define("GCLIENT_SIMPLE_KEY"		, "AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0");
	define("GSCOPE_PROFILE"			,"https://www.googleapis.com/auth/userinfo.profile");                 
	define("GSCOPE_EMAIL"			,"https://www.googleapis.com/auth/userinfo.email");
	
	define("SESSION_PATH", "/Users/chrisb/Documents/workspace/nowcorkit/tmp");   
*/
// PROD
	// your database's Information
    define("DB_NAME", "nowcorkitdb");
    define("DB_SERVER", "50.63.228.94");
    define("DB_USERNAME", "nowcorkitdb");
    define("DB_PASSWORD", "N0wC0rk1t!");
	
	define("GCLIENT_ID"				, "861149793626-ouo3jgojgefe3qmhrlj4fg39ounl6n0e.apps.googleusercontent.com");
	define("GCLIENT_SECRET"			, "DumcFCTug4gxfMqUYwM2wevf");    
	define("GCLIENT_REDIRECT_URL"	, "http://www.nowcorkit.com/main.php");
	define("GCLIENT_SIMPLE_KEY"		, "AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0");
	define("GSCOPE_PROFILE"			,"https://www.googleapis.com/auth/userinfo.profile");                 
	define("GSCOPE_EMAIL"			,"https://www.googleapis.com/auth/userinfo.email");
     
	
	// constants for max flyers
	define("MAX_FLYERS", 4);
	
	//session path
	define("SESSION_PATH", "/var/chroot/home/content/43/4173543/html/tmp");
?>
