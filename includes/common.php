<?

 /***********************************************************************
 * common.php
 * Author		: Christopher Bartholomew
 * Last Updated : 12/08/2011
 * Purpose		: Used to control sessions and loading of additional helpers. 
 * this also includes the creating of session variables
 **********************************************************************/
    
    session_start();    
	// requirements 
 	require_once('constants.php');  
	require_once('class_objects.php');
	require_once('DAL.php');
	require_once('helpers.php');    	        
	require_once('google-api-php-client/src/apiClient.php');   
	require_once('google-api-php-client/src/contrib/apiOauth2Service.php');
             
	// enable client
	$client = new apiClient();
	$client->setApplicationName('Nowcorkit');
	$client->setClientId(GCLIENT_ID);
	$client->setClientSecret(GCLIENT_SECRET);
	$client->setRedirectUri(GCLIENT_REDIRECT_URL);
	$client->setDeveloperKey(GCLIENT_SIMPLE_KEY); 
	$goolgeScopes = Array(GSCOPE_PROFILE,GSCOPE_EMAIL);
	$client->setScopes($goolgeScopes);    
    
	// enable service
	$oauth2 = new apiOauth2Service($client);

	if (isset($_GET['code'])) {
	  $client->authenticate();
	  $_SESSION['token'] = $client->getAccessToken();
	  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}

	if (isset($_SESSION['token'])) {
	 $client->setAccessToken($_SESSION['token']); 
	 $user  = $oauth2->userinfo->get();  
	                        
	 //    		[id] 			=> 105499867526169935261 
	 //    		[email] 		=> cbartholomew@gmail.com 
	 // 		[verified_email]=> 1 
	 // 		[name] 			=> Christopher Bartholomew 
	 // 		[given_name] 	=> Christopher 	
	 // 		[family_name] 	=> Bartholomew 
	 // 		[link] 			=> https://plus.google.com/105499867526169935261 
	 // 		[picture] 		=> https://lh3.googleusercontent.com/-ApACrt0LEVs/AAAAAAAAAAI/AAAAAAAAAY8/6wEBdkPgtiA/photo.jpg
	 // 		[gender] 		=> male 
	 // 		[locale] 		=> en-US 
	 //   
	   
	 $_COOKIE['email'] 	    = filter_var($user['email'], FILTER_SANITIZE_EMAIL); 
	 $_COOKIE['picture']    = filter_var($user['picture'], FILTER_VALIDATE_URL);    
	 $_COOKIE['id']		    = $user['id'];
	 $_COOKIE['given_name'] = $user['given_name'];
	
	}

	if (isset($_REQUEST['logout'])) {
	  unset($_SESSION['token']);
	  $client->revokeToken();     
	  redirect("index.php");
	}

	if ($client->getAccessToken()) {	  
	  // The access token may have been updated lazily.
	  $_SESSION['token'] = $client->getAccessToken();
	} else {       
	  redirect("index.php");
	}
	                                             
	// display errors and warnings but not notices
    // ini_set("display_errors", true);
    // error_reporting(E_ALL ^ E_NOTICE);      

	//enable sessions, restricting cookie to /nowcorkit/
    // if (preg_match("{^(/)}", $_SERVER["REQUEST_URI"], $matches))
    //        session_set_cookie_params(0, $matches[1]);     

	// session_save_path(SESSION_PATH);
	//     session_start();   

	//require authentication for most pages
    // if (!preg_match("{/(:?login|register|logout)\d*\.php$}", $_SERVER["PHP_SELF"]))
    //     {
    //        if (!isset($_SESSION["users_cork_id"]))
    // 		   {
    //            redirect("login.php");
    // 		   }
    //     }    	
?>
