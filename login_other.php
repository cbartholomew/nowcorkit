<?
   require_once 'includes/google-api-php-client/src/apiClient.php';   
   require_once 'includes/constants.php';
   
	$client = new apiClient();
	$client->setApplicationName('Nowcorkit Authenticator');
	$client->setClientId(GCLIENT_ID);
	$client->setClientSecret(GCLIENT_SECRET);
	$client->setRedirectUri(GCLIENT_REDIRECT_URL);
	$client->setDeveloperKey(GCLIENT_SIMPLE_KEY);  
    $goolgeScopes = Array("https://www.googleapis.com/auth/userinfo.profile");            
	$client->setScopes($goolgeScopes);
	$authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">	
<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--Load Javascript Libraries-->
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
</head>
<div id="login_buttons" class='ui-widget'>
<!--<h2  class='ui-widget-header' style='text-align:center'>Please choose your login method</h2>-->
<?
  echo "<div class='login'><a href='$authUrl'><img src='images/gplus-icon.png' width='29' height='29' alt='plusbutton'></a></div>";
?>

<!--
<div class='login'><img src="images/facebookbutton.png" width="100" height="100" alt="Facebookbutton"></div>
<div class='login'><img src="images/twitterbutton.png" width="100" height="100" alt="Twitterbutton"></div>
--> 
</div>
<body>
</body>
</html>