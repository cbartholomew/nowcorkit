<?
/*
  Google API 
*/ 
require_once('includes/constants.php');   
require_once('includes/google-api-php-client/src/apiClient.php');   

$client = new apiClient();
$client->setApplicationName('Nowcorkit Authenticator');
$client->setClientId(GCLIENT_ID);
$client->setClientSecret(GCLIENT_SECRET);
$client->setRedirectUri(GCLIENT_REDIRECT_URL);
$client->setDeveloperKey(GCLIENT_SIMPLE_KEY);  
$goolgeScopes = Array(GSCOPE_PROFILE,GSCOPE_EMAIL);           
$client->setScopes($goolgeScopes); 
$googleAuthURL = $client->createAuthUrl();      
  
?>

<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/Product">
<head>
<title>Nowcorkit</title>
<!--Load CSS Libraries-->	
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/index.css" type="text/css" media="screen" title="no title" charset="utf-8">	
<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--Load Javascript Libraries-->
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
<script src="js/social.js" type="text/javascript"></script>   
<script>
$(function(){ $.ajax({ url: 'content_main.php',type: 'GET',success: function(data){$('#login_content').html(data);},
														   failure:function(){$('#login_content').html("Problem loading content");}});
$("#login_tab").tabs();}); 
</script>

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

<meta itemprop="name" content="Nowcorkit">
<meta itemprop="description" content="Nowcorkit.com is a FREE digital corkboard web application. An alternative to replace the paper riddled corkboards, which now plague this century. The idea of nowcorkit.com is two fold: Users can create digital boards for flyers, which can be displayed on any device that has an HTML5 compliant browser (Chrome Preferred). And, Users will be able to generate their own flyers using three specific templates: text, text and image, and just image.">
<meta itemprop="image" content="nowcorkit.com/images">
</head>
<body>
<div id="header" class="ui-widget-content ui-corner-all header">
<div class="logo"><img src="images/logo.png" class="ui-widget-content" width="400" height="130px" alt="Logo"></div>     
<div class="snButton"><g:plusone size="tall" annotation="inline" width="200"></g:plusone></div>
<div class="snButton"><a href="https://twitter.com/nowcorkit" class="twitter-follow-button" data-show-count="false">Follow @nowcorkit</a></div>  
<hr  align="left">
<div class="loginButton">
<? echo "<a href='$googleAuthURL'><img src='images/gplus-large.png' width='50' height='50' alt='plusbutton'></img></a>"; ?>
</div>
<div class="signIn">Sign in with Google+</div>   
</div> 
<div id="login_content" class="leftContentLogin"></div>
<div id="login_tab"		class="middleContentLogin"> 
<ul><li><a href="#tabs-1">Welcome!!</a></li></ul>
<div id="tabs-1"><p>Welcome to the nowcorkit.com new release! We've added a new look to accommodate for our future plans! Currently, we are only supporting Google accounts for nowcorkit.com. Please sign in by clicking the G+ image above!</p></div>        
</div> 
</div> 
     
</body>
</html>