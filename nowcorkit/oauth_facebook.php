<?

/***********************************************************************
 * oauth_facebook.php
 * Author		: Christopher Bartholomew
 * Last Updated : 11/13/2011
 * Purpose		: manage facebook logins for application
 **********************************************************************/
	
   	// requirements 
	require_once("includes/constants.php");
	require_once("includes/DAL.php");
	require_once("includes/helpers.php");
	require_once("includes/class_objects.php");
	
   $app_id 		= APP_ID;
   $app_secret  = APP_SECRET;
   $my_url 		= "http://nowcorkit.com/menu.php";	
   
   session_start();

   $code = $_REQUEST["code"];

   if(empty($code)) 
   {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_REQUEST['state'] == $_SESSION['state']) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];
		
     $user = json_decode(file_get_contents($graph_url));
	 
	 // create facebook user from return data
	$fb = new FacebookUser($user);
		
	//  check if facebook account already lives in user table
	$fb->cork_id = LookupFacebookUserIdInUsers($fb);
	
		// no user found
		if ($fb->cork_id == 0)
		{
			// insert the user in the table
			$fb->insert();
			// create new user account with assoicated cork_id
			$fb->insert_into_users();	
		}
	
		// at this point, there should now be a cork_id associated to the object update session
		SetSessionId($fb->cork_id);
   }
   else 
   {
     echo("The state does not match. You may be a victim of CSRF.");
   }

function SetSessionId($users_cork_id)
{
		// set the session to the newly registered id
	  	$_SESSION["users_cork_id"] = $users_cork_id;	
}
?>


