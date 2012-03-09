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
	<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.loadmask.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/src/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
	<!--<script src="js/helper.js" type="text/javascript" charset="utf-8"></script>-->
	<!--<script src="js/jshmin.js" type="text/javascript" charset="utf-8"></script>-->
	

	<script src="js/nowcorkit.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/date.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/modal.js" type="text/javascript" charset="utf-8"></script>	
	<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDaVcENLnUcWYLoeoIQPAmpHNeZTON0ml0&sensor=false"></script>
	
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
<body onload="initialize_page();">
	<div id='status_messages' class='ui-widget-content ui-corner-all'>
	<label style="color: #9BCC60;">Messages:</label>
	</div>
<div id="toolbar"></div>
<div id="menu_items">
	<ol id="selectable">
	<li id="0" class="ui-widget-content ui-corner-all">Create Flyer</li>
	<li id="1" class="ui-widget-content ui-corner-all">Flyer Manager</li>		
	<li id="2" class="ui-widget-content ui-corner-all">Cork Flyer</li>
	<li id="3" class="ui-widget-content ui-corner-all">Board Manager</li>
	</ol>
</div>
<div id="content">
	<p class='ui-widget-content ui-corner-all' style='padding:10px' >
	Welcome to nowcorkit.com! Visit the help menu above if you are not sure where to start!
	</p>
</div>
<div id="form_content" class="ui-corner-all"></div>
<div id="modal_help"></div>
<div id="modal_dialog"></div>
</body>
</html>