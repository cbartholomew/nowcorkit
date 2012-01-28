<?
/***********************************************************************
* scoutboard.php
* Author		  : Christopher Bartholomew
* Last Updated    : 1/26/2011
* Purpose		  : Render's Board
**********************************************************************/

?>
<!DOCTYPE html>
<html>
<head>
<title>Scout Location</title>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/content.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<script src="js/detectbrowser.js" type="text/javascript" charset="utf-8"></script>		
<script type="text/javascript">

function render_scout(id)
{
	$( "#" + id ).button({
    icons: {
        primary: "ui-icon-search"
    },
	 text: false
	});
	$( "#" + id ).click(function(){
		console.log($(this).attr('id'));
	});
}

$(document).ready(function(){
	
	$(function(){
		$("#modal").dialog({
			autoOpen: false,
			height: 'auto',
			width: 'auto',
			resizeable: false,
			draggable:false,
			title: "Preview",
			buttons: {
				close: function(){ $(this).dialog("close"); }
			}
		});
	});
	
	$(function(){				
		var count = 0;
			
		$.ajax({	
			url: "generate_board.php",
			type: 'post',			
			dataType: 'json',	
			data: {			
				boardid: 4			
			},			
			success: function(data) {	
				$.each(data, function(key,value){
								
				    count++;				   
					html =  "<tr>";
					html += "<td class='ui-widget-content table_data'>" + value["flyer"]["title"] + "</td>";
					html += "<td class='ui-widget-content table_data'>" + count + "</td>";
					html += "<td class='ui-widget-content table_data'>" + value["flyer"]["post_status_desc"] + "</td>";
					html += "<td class='ui-widget-content table_data'>" + value["flyer"]["post_expiration"] + "</td>";
					html += "<td class='ui-widget-content table_data'>" + value["flyer"]["type"] + "</td>";
					html += "<td class='ui-widget-content table_data'><center><button id='" + value["flyer"]["users_flyers_id"] + "'>Preview</button></td><center>";
				    html += "</tr>";
						
					$("tbody").append(html);
					
					$(function(){
						$( "#" + value["flyer"]["users_flyers_id"] ).button({
					    icons: {
					        primary: "ui-icon-search"
					    },
						 text: false
						});
						$( "#" + value["flyer"]["users_flyers_id"] ).click(function(){
							$("#modal").load("generate.php?flyerid=" + $(this).attr('id'));
							$("#modal").dialog("open");
						});
					});
				   	console.log(value["flyer"]);

				});	

			}
		});
	});	
});
</script>
</head>
<body>
<table id="board_scout" class='ui-widget table_data'>
<thead>
<th class='ui-widget-header'>Title</th>
<th class='ui-widget-header'>Position</th>
<th class='ui-widget-header'>Status</th>
<th class='ui-widget-header'>Expiration</th>
<th class='ui-widget-header'>Flyer Type</th>
<th class='ui-widget-header'>Preview</th>
</thead>
<tbody>
</tbody>
</table>
<div id="modal" style="width:800px;height:600px"></div>
</body>
</html>