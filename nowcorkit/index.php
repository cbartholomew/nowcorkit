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
	<title></title>
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel='stylesheet' href='css/validation.css' type='text/css' media='screen' title='no title' charset='utf-8'>
	<link rel="stylesheet" type="text/css" media="all" href="css/fileupload.css" />
	<link rel="stylesheet" href="css/jquery.loadmask.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.loadmask.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/date.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/helper.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">	
		//ui.selected.id is the id of the list item
		$(document).ready(function(){$(function() {$( "#selectable" ).selectable({selected: function(event, ui){RequestPageByAjaxGet(ui.selected.id);}});});});
	</script>
	<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0&sensor=false"> 
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
</head>
<html>
<body onload="BuildToolbar('menu');">
	<div id='status_messages' class='ui-widget-content ui-corner-all'>
		<label style="color: #9BCC60;">Messages:</label>
	</div>
	
<div id="toolbar"></div>
<!--
	<img src="images/pin.png" width="48" height="48" style="position: absolute;left:120px;z-index: 2; top:375px" alt="Pin2">
	<img src="images/header.png" width="270" height="150" style="position: absolute;left:7px;top:400px" class='ui-corner-all'alt="Header">
-->
<div id="menu_items">
	<ol id="selectable">
		<li id="flyer_choice" class="ui-widget-content ui-corner-all">Create Flyer</li>
		<li id="flyer_manager" class="ui-widget-content ui-corner-all">Flyer Manager</li>		
		<li id="post" class="ui-widget-content ui-corner-all">Post Flyer</li>
		<li id="board_manager" class="ui-widget-content ui-corner-all">Board Manager</li>
	</ol>
</div>
<div id="content">
</div>
<div id="form_content" class="ui-corner-all">
</div>
</body>
</html>