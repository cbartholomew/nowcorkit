<?
  /***********************************************************************
  * corkbaord.php
  * Author		  : Christopher Bartholomew
  * Last Updated  :  12/08/2011
  * Purpose		  :  The workhorse of the application. Renders a variety of flyers
  * based on the screen resolution. Once it determines this, it renders a specific set of
  * containers that will be used to render the json data and create html
  **********************************************************************/
  require_once("includes/common.php");
  $board_id = $_POST["board_id"];
	
  if ($_SERVER['REQUEST_METHOD'] == 'GET') { echo "<h1>We're sorry, you can only access this board by logging into your account!</h1>"; return;}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

	
	// build screen variables
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
	
	/* insertFlyers(data)
	 * this function will look at the json request, and render the flyers inthe containers
	 */
	function insertFlyers(data) {
		var containerCount = 1;
		var flyerCount = 0;      
		var p = 0;
		var fHTML = "";
		var tackPos;
		//console.log(data);
		// we have the data(board objects, which contain flyers) - start rendering them
		for(flyer in data){

		tackPos = (fWidth*.6) - (Math.ceil(Math.random()*(fWidth*.2)));
		fHTML = "<div  id='flyer" + flyerCount + "'><img src='images/tack.png' style='width:" + (fWidth*.10) + "px; position:absolute; top: 0px;  z-index: 10;left: " + tackPos + "px;' ></img>";
			
			if ( data[p].flyer.type_id ==  "1" ) {						
				// text only

				fHTML += "<center><h3>" + data[p].flyer.title + "</h3></center><table>";
				fHTML += "<tr><td><b><label>Location<label><b></td><td><i>" + data[p].flyer.location + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Contact<label><b></td><td><i>" + data[p].flyer.contact_name + "</i></td></tr>";
				fHTML += "<tr><td></td><td><i>" + data[p].flyer.contact_info + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Event Date<label><b></td><td><i>" + data[p].flyer.event_date + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Additional Info<label><b></td><td><i>" + data[p].flyer.description + "</i></td></tr></table>";			
				// only create QR Code if enable_qr is "on"
				if (data[p].flyer.enable_qr == "on"){
					fHTML += "<img src='" + data[p].flyer.qr_full_location + "' style='height:100px;width:100px;z-index:9;position:absolute;bottom:1%;right:1%;'></img>";
				}
				flyerCount++;  
				p++;			
				
			} else if ( data[p].flyer.type_id ==  "2" ) {	
				
				// text & image				
				fHTML += "<center><h3>" + data[p].flyer.title + "</h3></center><table>";
				fHTML += "<tr><td><b><label>Location<label><b></td><td><i>" + data[p].flyer.location + "</i></td><td></td></tr>";
				fHTML += "<tr><td><b><label>Contact<label><b></td><td><i>" + data[p].flyer.contact_name + "</i></td></tr>";
				fHTML += "<tr><td></td><td><i>" + data[p].flyer.contact_info + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Event Date<label><b></td><td><i>" + data[p].flyer.event_date + "</i></td></tr>";
				fHTML += "<tr><td><b><label>Additional Info<label><b></td><td><i>" + data[p].flyer.description + "</i></td></tr></table>";
				fHTML += "<center><img src='" + data[p].flyer.image_path + "' style='height: " + fHeight*.4 + "px;'></img></center>";
				// only create QR Code if enable_qr is "on"
				if (data[p].flyer.enable_qr == "on"){
					fHTML += "<img src='" + data[p].flyer.qr_full_location + "' style='height:100px;width:100px;z-index:9;position:absolute;bottom:1%;right:1%;'></img>";
				}
						
				flyerCount++;
				p++;			
			} else {
				// full image upload
				fHTML += "<img src='" + data[p].flyer.image_path + "' id='picFlyer" + flyerCount + "'></img>";
		
				flyerCount++;  
				p++;							
			}			
			fHTML += "</div>";
			
			$("#container" + containerCount).html(fHTML);
			$("#flyer" + (flyerCount-1) ).css( {"width": fWidth, "height" : fHeight, "float" : "left", "margin" : "0px", "position":"relative","background-image":"url('images/paper.jpg')"  } );
		    
			$("#picFlyer" + (flyerCount-1) ).css( {"width": fWidth, "height" : fHeight, "position" : "absolute", "top" : "0px", "left" : "0px", "z-index" : "1"});	
		   
			if (containerCount == (cNumber*rNumber) ) containerCount = 1;
		    containerCount++;
		}
	}	
	function reload_board(board_id)
	{
		$.getScript('js/board.js', function(){
			var b = new Board({param:'create', page:''});
			b.load_corkboard(board_id);
		});	
	}
	/* GenerateBoard(board_id)
	 * used to make the json request to the script for board objects
	 */
	function GenerateBoard(board_id){ 
		
		// ghetto refresh the page every 60 seconds, for jquery fade-in breaks
		setTimeout("reload_board(" + board_id + ");",60000);
		       		
		$.ajax({	
			url: "generate_board.php",
			type: 'post',			
			dataType: 'json',	
			data: {			
				boardid: board_id			
			},			
			success: function(data) {				
				insertFlyers(data);		
			}
		});	
		
			$.ajax({
				url: "board_status_update.php",
				type: "POST",
				data:{
					boardid: board_id,
					board_status: 1
				}
			});
	}
				
	// when document is loased, start constructing the containers				
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
		sWidth  -= cNumber*2.5;
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
		// php code writing in the board id from the get request
		<? echo "GenerateBoard(". $board_id .");"; ?>
		
		$(function(){
			$(window).unload(function(){
				$.ajax({
					async: false,
					url: "board_status_update.php",
					type: "POST",
					data:{
						boardid: <? echo " " . $board_id ?>,
						board_status: 0
					}
				});			
			});
		});
	
	});

	var html = "";
	html =	'<span id="span_menu">';
	html +=	'<input type="radio" id="home" name="home" /><label for="home">Home</label>';
	html += '</span>';
	
	$("#toolbar").html(html);

	$(function(){
		$("#span_menu").buttonset();
		
		$("#home").click(function(){
			window.location = "index.php";
		});
	});
	
</script>
<body>
<div id="toolbar" style="position:absolute;bottom:0px;right:0px;z-index:-99;"></div>
</body>
</html>



