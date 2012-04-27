<?php 
//$plus = new apiPlusService($client);      
//$authURL = $client->createAuthUrl();                                                 
//require_once 'google-api-php-client/src/contrib/apiPlusService.php';   
//session_start(); 

require_once 'google-api-php-client/src/apiClient.php';   
require_once 'google-api-php-client/src/contrib/apiOauth2Service.php';

$client = new apiClient();
$client->setApplicationName('Nowcorkit Authenticator');
$client->setClientId(GCLIENT_ID);
$client->setClientSecret(GCLIENT_SECRET);
$client->setRedirectUri(GCLIENT_REDIRECT_URL);
$client->setDeveloperKey(GCLIENT_SIMPLE_KEY);    
  
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) { 
  $client->authenticate(); 
  $responseAccessToken = $client->getAccessToken();       
  $response = json_decode($responseAccessToken, true); 
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);

  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));     

  // $client->authenticate();
  // $_SESSION['token'] = $client->getAccessToken();
  // $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  // header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));  
}

if (isset($response["access_token"])) {
 $client->setAccessToken($response["access_token"]);
}

if (isset($_REQUEST['logout'])) {
  unset($response["access_token"]);
  $client->revokeToken();
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();

  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  $personMarkup = "$email<div><img src='$img?sz=50'></div>";

  // The access token may have been updated lazily.
  $response["access_token"] = $client->getAccessToken();
} else {
  redirect("login_other.php");   
}
                   

//if (isset($_SESSION['token'])) {
//  $client->setAccessToken($_SESSION['token']);
//}

// if ($client->getAccessToken()) {
//                                       
//   $person = $plus->people->get('me');   
//   //$activities = $plus->activities->listActivities('me', 'public');     
//   print 'Your Activities: <pre>' . print_r($person, true) . '</pre>';
//   // The access token may have been updated.
//   $_SESSION['token'] = $client->getAccessToken();      
// } else {
//   $authUrl = $client->createAuthUrl();           
//   print "<a href='$authUrl'>Connect Me!</a>";
// }     
?>