<?

/***********************************************************************
* constants.php
* Author		: Christopher Bartholomew
* Last Updated  : 11/28/2011
* Purpose		: Provides Global Constants for application. 
* For demo, please use test as the production is to my third party server. ;-(  
**********************************************************************/

//Production /**/
/*
	// your database's name (i.e., )
    define("DB_NAME", "nowcorkitdb");

    // your database's server
    define("DB_SERVER", "50.63.228.94");

    // your database's username
    define("DB_USERNAME", "nowcorkitdb");
	
    // your database's password
    define("DB_PASSWORD", "N0wC0rk1t!");

	// facebook oAuth App Id
	define("APP_ID", "301835463167653");
	
	// facebook oAuth App Secret (shhh)
	define("APP_SECRET","0aff787b4958291bcd00416674f08110");
	
	// constants for max flyers
	define("MAX_FLYERS", 4);
	
	// define the session save path
	define("SESSION_PATH", "/var/chroot/home/content/43/4173543/html/tmp");
*/
// TEST 

    // your database's Information
    define("DB_NAME", "nowcorkitdb");
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "root");

	// facebook oAuth App Id
	define("FACEBOOK_APP_ID", "301835463167653");   
	define("FACEBOO_APP_SECRET","0aff787b4958291bcd00416674f08110");  
	
	// google API information
	define("GCLIENT_ID", "861149793626.apps.googleusercontent.com");
	define("GCLIENT_SECRET", "Tv2im0BvO6Ca2YszIp7e-Iix");    
	define("GCLIENT_REDIRECT_URL", "http://localhost/nowcorkit/main.php");
	define("GCLIENT_SIMPLE_KEY", "AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0");
	define("GSCOPE_PROFILE","https://www.googleapis.com/auth/userinfo.profile");                 
	define("GSCOPE_EMAIL","https://www.googleapis.com/auth/userinfo.email");         
	
	// constants for max flyers
	define("MAX_FLYERS", 4);
	
	// define the session save path
	define("SESSION_PATH", "/Users/chrisb/Documents/workspace/nowcorkit/tmp");

   
?>
