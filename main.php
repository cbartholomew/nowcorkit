<?
/***********************************************************************
 * index.php
 * Author		 : Christopher Bartholomew
 * Last Updated  : 12/08/2011
 * Purpose		 : The main menu for the user. In change of loading all
 * scripts and style sheets that are needed for the application
 **********************************************************************/
 	require_once('includes/common.php');
   	
?>
<!DOCTYPE html>
<head>
	<title>Nowcorkit <? print " : " . $_COOKIE['given_name'] ?></title>
	<link rel="stylesheet" href="css/index.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel='stylesheet' href='css/validation.css' type='text/css' media='screen' title='no title' charset='utf-8'>
	<link rel="stylesheet" type="text/css" media="all" href="css/fileupload.css" />
	<link rel="stylesheet" href="css/jquery.loadmask.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="icon" type="image/png" href="images/headersmall.png" />
	<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.loadmask.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>	
    <script src='http://maps.googleapis.com/maps/api/js?key=AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0&sensor=false' type='text/javascript'></script> 
 
	<script src='js/constants.js' type='text/javascript'charset='utf-8'></script>
	<script src='js/nowcorkit.js' type='text/javascript' charset='utf-8'></script>
	<script src='js/social.js' type='text/javascript' charset='utf-8'></script>
	<script src='js/date.js' type='text/javascript' charset='utf-8'></script>
	<script src='js/detectbrowser.js' type='text/javascript' charset='utf-8'></script>
	<script src='js/modal.js' type='text/javascript' charset='utf-8'></script>  
                                                                               

</head>
<html>
<body onload="initialize_page();">
<div id="header" class="ui-widget-content ui-corner-all header">

<div id="menu_items" class="menuContent">
	<ol id="selectable">                                                                                                                                  
	<li id="4" class="ui-widget-content ui-corner-all"><img src="images/preferences.jpeg" 	width="170" height="115" alt="preferences">Location Preference</li>	
	<li id="0" class="ui-widget-content ui-corner-all"><img src="images/create_flyer.jpeg"  width="170" height="115" alt="Create Flyer">Create Flyers</li>
	<li id="2" class="ui-widget-content ui-corner-all"><img src="images/cork_flyer.jpeg" 	width="170" height="115" alt="Cork Flyers">Cork Flyers</li> 
	<li id="1" class="ui-widget-content ui-corner-all"><img src="images/flyer_manager.jpeg" width="170" height="115" alt="Manage Flyers">Manage Flyers</li>		
	<li id="3" class="ui-widget-content ui-corner-all"><img src="images/board_manager.jpeg" width="170" height="115" alt="Manage Boards">Manage Boards</li>
	<li id="5" class="ui-widget-content ui-corner-all"><img src="images/help.jpeg" 		  	width="170" height="115" alt="help">Help</li>  
	<li id="6" class="ui-widget-content ui-corner-all"><img src="images/logout.jpeg"		width="170" height="115" alt="logout">Logout</li>  
	</ol>
</div>
<div class="logosmall"><img class="ui-widget-content" src="images/headersmall.png" width="156" height="70" alt="Headersmall"></div>       
<hr  align="left"> 
<div class="userInfo">                                                
<? 
$markup = "<img class='ui-widget-content' height=50 width=50 src='" . $_COOKIE['picture'] . "?sz=50'>"; 
print $markup;
?>   
</div>                                                                           
<div class="message"><? print "Welcome " . $_COOKIE['given_name'] . "!"; ?></div>       
</div>                                           

<div id="content" class="leftContent"></div>
<div id="form_content" class="ui-corner-all middleContent"></div>
<div id="modal_help"></div>
<div id="modal_dialog"></div>
<div class="footer ui-widget-content ui-corner-all">
	<div class="snButtonFooter"><g:plusone size="tall" annotation="inline" width="200"></g:plusone></div>
	<div class="snButtonFooter"><a href="https://twitter.com/nowcorkit" class="twitter-follow-button" data-show-count="false">Follow @nowcorkit</a></div>
</div>   
</body>
</html>
