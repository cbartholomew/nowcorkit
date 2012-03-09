<?
/***********************************************************************
* scoutboard.php
* Author		  : Christopher Bartholomew
* Last Updated    : 1/26/2011
* Purpose		  : Render's Board
**********************************************************************/

require_once("includes/common.php");

$board_id = $_GET["boardid"];
$title = $_GET["title"];

?>
<!DOCTYPE html>
<html>
<head>
<title>Scout Location: <? echo $title ?></title>
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; }
#sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 300px; height: 488px; position:relative;}
</style>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>		
<script>
$(document).ready(function(){$(function(){$("#sortable").sortable({forceHelperSize:true});$("#sortable").disableSelection();});$(function(){$.ajax({url:"generate_board.php",type:'post',dataType: 'json',data: {<? echo "boardid:" . $board_id ?>},success: function(data) {$.each(data, function(key,value){html = "<li class='ui-state-default' id='" + value['flyer']['users_flyers_id']+"'></li>";	$("#sortable").append(html);$("#" + value['flyer']['users_flyers_id']).load("generate.php?flyerid=" + value['flyer']['users_flyers_id'],function(){html = "<table style='width:300px;position:absolute;bottom:0;'>";html += "<th class='ui-widget-content table_data'>Title</th>";html += "<th class='ui-widget-content table_data'>Status</th>";html += "<th class='ui-widget-content table_data'>Expires</th>";html += "<tr>";html += "<td class='ui-widget-content table_data'>" + value["flyer"]["title"] + "</td>";html += "<td class='ui-widget-content table_data'>" + value["flyer"]["post_status_desc"] + "</td>";html += "<td class='ui-widget-content table_data'>" + value["flyer"]["post_expiration"] + "</td>";html += "</tr></table>";$("#" + value['flyer']['users_flyers_id']).append(html);});});}});});});	
</script>
</head>
<h1 class='ui-widget-header ui-corner-all' style='text-align: center; padding: 10px'>Scouting Location: <? echo $title?></h1>
<p class='ui-widget-content ui-corner-all' style='padding: 20px;text-weight:bold'>
Note: This screen only shows the flyers that are posted and PPS posted to this board. The flyer's position is sorted by create time; however, pps posted 
should always display first. This is not the actual representation of the corkboard itself, as the most recent post will be displayed <i>at the bottom</i>. Also, this page does not auto refresh.
</p>
<body>
<div id="sortable"></div>
</body>
</html>