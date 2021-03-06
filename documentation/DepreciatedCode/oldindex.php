<?

/***********************************************************************
* login.php
* Author		 : Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		 : The login menu uses server side validation (boooo)
* to login users into the database. I would have rather used jquery, but 
* I didn't because of the registration & login used different methods than
* when I had orginally had designed for the facbeook login.
**********************************************************************/

require_once('includes/common.php');     
require_once('includes/google-api-php-client/src/apiClient.php');   
require_once('includes/constants.php');

/*
  Google API 
*/
$client = new apiClient();
$client->setApplicationName('Nowcorkit Authenticator');
$client->setClientId(GCLIENT_ID);
$client->setClientSecret(GCLIENT_SECRET);
$client->setRedirectUri(GCLIENT_REDIRECT_URL);
$client->setDeveloperKey(GCLIENT_SIMPLE_KEY);  
$goolgeScopes = Array("https://www.googleapis.com/auth/userinfo.profile");            
$client->setScopes($goolgeScopes);
$googleAuthUrl = $client->createAuthUrl();     

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ $login_correct = ValidateNormalLogin($_POST);} 
else { $login_correct = true; }		
?>

<!DOCTYPE html>
<html>
<head>
<!--Load CSS Libraries-->	
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" title="no title" charset="utf-8">	
<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--Load Javascript Libraries-->
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
<script>
//Render Submit Button
$(function() {
$( "input:submit", "login-form" ).button();
});

$(function(){
	$.ajax({
				url: 'content_main.php',
				type: 'GET',
				success: function(data){
					$('#home_content').html(data);	
				},
				failure: function(){
					$('#home_content').html("Problem loading content");
				}
			});
		});

</script>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-27673016-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<!-- Update your html tag to include the itemscope and itemtype attributes -->
<html itemscope itemtype="http://schema.org/Product">

<!-- Add the following three tags inside head -->
<meta itemprop="name" content="Nowcorkit">
<meta itemprop="description" content="Nowcorkit.com is a FREE digital corkboard web application. An alternative to replace the paper riddled corkboards, which now plague this century. The idea of nowcorkit.com is two fold: Users can create digital boards for flyers, which can be displayed on any device that has an HTML5 compliant browser (Chrome Preferred). And, Users will be able to generate their own flyers using three specific templates: text, text and image, and just image.">
<meta itemprop="image" content="nowcorkit.com/images">

</head>

<body>		
<img src="images/pin.png" width="48" height="48" style="position: absolute;left:725px;z-index: 2;" alt="Pin2">
<img id='logo' class="ui-corner-all" src="images/logo.png" width="480" height="180" style="display:block;z-index:-1;margin-left:auto;margin-right:auto;"alt="Logo">
<br>
<div id="login" title="login" class="ui-widget-content ui-corner-all">
<h1>Login using...</h1>	   
<?
  echo "<div class='login'><a href='$googleAuthUrl'><img src='images/gplus-large.png' width='100' height='100'  alt='plusbutton'></a></div>"; 
?>
</div>
<br>
<div id="home_content" style="position:absolute;left:10px;top:10px;"></div>
<br>

<div id="footer" class="ui-widget-header">
<!-- Place this tag where you want the +1 button to render -->
<p>nowcorkit.com 2012 - the digital corkboard app<br><p>
<table>
<tr>
<td><g:plusone size="tall" annotation="inline" width="200"></g:plusone></td>
<td><a href="https://twitter.com/nowcorkit" class="twitter-follow-button" data-show-count="false">Follow @nowcorkit</a></td>		
</tr>
</table>
</div>
</body>
</html>