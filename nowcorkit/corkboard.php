<?
  /***********************************************************************
  * XXX.php
  * Author		  : Christopher Bartholomew
  * Last Updated  : 
  * Purpose		  : 
  **********************************************************************/

  $board_id = $_GET["boardid"];

?>
<!DOCTYPE html>

<html>
<head>
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	var sWidth;
	var sHeight;

	var cNumber;
	var rNumber;

	var fWidth;
	var fHeight;

	var vMargin;
	var hMargin;

	var HTML;
	var temp;	
	function insertFlyers(data) {
		var containerCount = 1;
		var flyerCount = 0;      
		var p = 0;
		var fHTML = "";
		var tackPos;
		
		for(flyer in data){
			console.log(flyerCount);
			console.log(data);
			tackPos = (fWidth*.6) - (Math.ceil(Math.random()*(fWidth*.2)));
		fHTML = "<div id='flyer" + flyerCount + "'><img src='images/tack.png' style='width:" + (fWidth*.10) + "px; position:absolute; top: 0px;  z-index: 10;  left: " + tackPos + "px;' ></img>";
			if ( data[p].flyer.type_id ==  "1" ) {						
				
				fHTML += "<center><h3>" + data[p].flyer.title + "</h3></center><table>";
				fHTML += "<tr><td><b><label>Location<label><b></td><td><i>" + data[p].flyer.location + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Contact<label><b></td><td><i>" + data[p].flyer.contact_name + "</i></td></tr>";
				fHTML += "<tr><td></td><td><i>" + data[p].flyer.contact_info + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Event Date<label><b></td><td><i>" + data[p].flyer.event_date + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Additional Info<label><b></td><td><i>" + data[p].flyer.description + "</i></td></tr></table>";
				fHTML += "<center><img src='" + data[p].flyer.qr_full_location + "' style='height: " + fHeight*.4 + "px;'></img></center>";								
				
				flyerCount++;  
				p++;			
				
			} else if ( data[p].flyer.type_id ==  "2" ) {	
				fHTML += "<center><h3>" + data[p].flyer.title + "</h3></center><table>";
				fHTML += "<tr><td><b><label>Location<label><b></td><td><i>" + data[p].flyer.location + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Contact<label><b></td><td><i>" + data[p].flyer.contact_name + "</i></td></tr>";
				fHTML += "<tr><td></td><td><i>" + data[p].flyer.contact_info + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Event Date<label><b></td><td><i>" + data[p].flyer.event_date + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Additional Info<label><b></td><td><i>" + data[p].flyer.description + "</i></td></tr></table>";
				fHTML += "<center><img src='" + data[p].flyer.image_path + "' style='height: " + fHeight*.4 + "px;'></img>";
				fHTML += "<img src='" + data[p].flyer.qr_full_location + "' style='height: " + fHeight*.4 + "px;'></img></center>";				
				flyerCount++;
				p++;			
			} else {
				fHTML += "<img src='" + data[p].flyer.image_path + "' id='picFlyer" + flyerCount + "'></img>";
		
				flyerCount++;  
				p++;							
			}			
			fHTML += "</div>";
			$("#container" + containerCount).html(fHTML);
			$("#flyer" + (flyerCount-1) ).css( {"width": fWidth, "height" : fHeight, "float" : "left", "margin" : "0px", "position" : "relative", "background-color" : "white"} );
		    $("#picFlyer" + (flyerCount-1) ).css( {"width": fWidth, "height" : fHeight, "position" : "absolute", "top" : "0px", "left" : "0px", "z-index" : "1"} );	
		    if (containerCount == (cNumber*rNumber) ) containerCount = 1;
		
		    containerCount++;
		}
	}	
	
	function GenerateBoard(board_id){        		
		$.ajax({	
				url: "generate_board.php",
				type: 'get',			
				dataType: 'json',	
				data: {			
				boardid: board_id			
				}, 
				beforeSend: function(){},			
				success: function(data) {				
					insertFlyers(data);		
				}
				});	
				}
					
	$(document).ready(function(){		
		sWidth  = $(window).width() - 6;
		sHeight = $(window).height();
		$("body").css( "margin","0" );
	
		//get number of collums 
		temp = (sWidth/375)%1;
		cNumber = (sWidth/375) - temp;
		if (temp >= 0.5) cNumber += 1;

		//get individual flyer width
		fWidth = (sWidth/cNumber) - 20;

		//get individual flyer height
		fHeight = (fWidth * 11)/8.5;

		//get number of rows
		temp = (sHeight/fHeight)%1;
		rNumber = (sHeight/fHeight) - temp;
		if (temp >= 0.75){
			rNumber += 1;
			fHeight = (sHeight/rNumber) - 20;
			fWidth = (fHeight * 8.5)/11;
			
		}
		sWidth -=  cNumber*2.5;
		sHeight -= rNumber*2.5;
		$("body").css( "margin-left", (cNumber) );
		
		hMargin = (sWidth - (fWidth * cNumber))/(cNumber*2);	
		vMargin = (sHeight - (fHeight * rNumber))/(rNumber*2);
	 	
		HTML = "";
		for (var i = 0; i < (cNumber*rNumber); i++){
			HTML += "<div id='container" + (i+1) + "' style=' width: " + fWidth + "px; height: " + fHeight + "px; border-width: 0px; border-color: black; border-style: solid;"
			HTML += "float: left; margin: " + vMargin + "px " + hMargin + "px " +vMargin +"px " + hMargin + "px ' ></div>"
		}
		
		$("body").append(HTML);
		
		var refreshId = setInterval(function()
		{

		 $('body').fadeOut('slow').load('corkboard.php?boardid=' + board_id).fadeIn('fast');

		}, 60000);
		
	<? echo "GenerateBoard(". $board_id .");"; ?>
	
	});

	
</script>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<body>
</body>
</html>



