<?

 /***********************************************************************
 * common.php
 * Author		: Christopher Bartholomew
 * Last Updated : 12/08/2011
 * Purpose		: Used to control sessions and loading of additional helpers. 
 * this also includes the creating of session variables
 **********************************************************************/
	ini_set("display_errors", false);
   	error_reporting(E_ALL ^ E_NOTICE);
	session_save_path("/var/chroot/home/content/43/4173543/html/tmp");
    session_start();    
	// requirements 
 	require_once('constants.php');  
	require_once('class_objects.php');
	require_once('DAL.php');  	    
	require_once('helpers.php');     
	require_once('google-api-php-client/src/apiClient.php');   
	require_once('google-api-php-client/src/contrib/apiOauth2Service.php');
      
	//enable client
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
			  $_SESSION['third_party_token'] = $client->getAccessToken();
			  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
			}
		
			if (isset($_SESSION['third_party_token'])) {
			 $client->setAccessToken($_SESSION['third_party_token']); 
			 $user  = $oauth2->userinfo->get();  
			
			 validate_third_party_user($user);	                       	   
			 $_COOKIE['email'] 	    = filter_var($user['email'], FILTER_SANITIZE_EMAIL); 
			 $_COOKIE['picture']    = (filter_var($user['picture'], FILTER_VALIDATE_URL) == null) ? "images/nophoto.png" 
																								  : filter_var($user['picture'], FILTER_VALIDATE_URL);	    
			 $_COOKIE['id']		    = $user['id'];
			 $_COOKIE['given_name'] = $user['given_name'];
			
			}
		
			if (isset($_REQUEST['logout'])) {
			  unset($_SESSION['third_party_token']);
			  $client->revokeToken();     
			  redirect("index.php");
			}
		
			if ($client->getAccessToken()) {	  
			  // The access token may have been updated lazily.
			  $_SESSION['third_party_token'] = $client->getAccessToken();
			} else {       
			  redirect("index.php");
			}	                                             	
?>
