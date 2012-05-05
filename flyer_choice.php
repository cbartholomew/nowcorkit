<?
/***********************************************************************
 * flyer_choice.php
 * Author		  : Christopher Bartholomew
 * Last Updated   :  05/2/2011
 * Purpose		  :  This file will render the new flyer choice screen
 **********************************************************************/
?>

<script> 
$(function() {
	var div = ["text","text_image","image","container", "bottomLeftContainer"];
	
	// run the currently selected effect
	function runEffect() {
		// run the effect
		$( "#" + div[3] ).removeAttr( "style" ).hide().fadeIn("slow");
		$( "#" + div[0] ).removeAttr( "style" ).hide().fadeIn("slow");   
		$( "#" + div[1] ).removeAttr( "style" ).hide().fadeIn("slow");   
		$( "#" + div[2] ).removeAttr( "style" ).hide().fadeIn("slow"); 
		 $("#" + div[4] ).removeAttr( "style" ).hide().fadeIn("slow");   
	};  
	runEffect();
		
});	
</script>


<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Step 1: Select a Flyer Type</h3>
	<div id='text' id2="1" class="ui-widget-content ui-corner-all  flyerSelectImage">
	<img src="images/text_only.jpeg"  width="80px" height="100px" alt="Text">Text
	</div>
	<div id='text_image' id2="2" class="ui-widget-content ui-corner-all  flyerSelectImage">
	<img src="images/text_image.jpeg"  width="80px" height="100px" alt="Text_Image">Text & Image   	
	</div>
	<div id='image' id2="3" class=" ui-widget-content  ui-corner-all  flyerSelectImage">
	<img src="images/image_only.jpeg"  width="80px" height="100px" alt="Image">Image   	
	</div>
	<br>
	<div id="flyer_info" class='ui-widget-content ui-corner-all flyerDescription'>You can choose one of the three different flyer types: text, text & image, and image only.</div>           
</div>           
<br>

<script type='text/javascript'>initialize_create_flyer();</script>   



<!--
<div id='bottomLeftContainer' class='ui-widget-content ui-corner-all bottomLeftContainer'>
<h3 class="ui-widget-header ui-corner-all bottomLeftContainerHead">Preview Pane</h3>
<div style="width:140px;height:100px;margin: 0 auto 0 auto;"><img src="images/paper.jpg" class="ui-widget-content" alt="Paper"></div>     
</div> 
<div class="scroll-pane ui-widget ui-widget-header ui-corner-all">
	<div class="scroll-content">
		<div id="bg_1" class="scroll-content-item ui-widget-header"><img src="images/paper.jpg" width="400" height="400" alt="Paper"></div>
		<div id="bg_2" class="scroll-content-item ui-widget-header"><img src="images/oldpaper.jpeg" width="119" height="170" alt="Oldpaper"></div>
		<div id="bg_3" class="scroll-content-item ui-widget-header"><img src="images/cream.jpeg" width="114" height="170" alt="Cream"></div> 
		<div id="bg_4" class="scroll-content-item ui-widget-header"><img src="images/notepaper.jpeg" width="170" height="170" alt="Notepaper"></div> 
	</div>
 </div>
<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
	<div class="scroll-bar"></div>
<style>

#bottomLeftContainer > div.bottomLeftContainer { padding: 10px !important; }
.scroll-pane { overflow: auto; width: 99%; float:left; }
.scroll-content { width: 500px; float: left; }
.scroll-content-item { width: 100px; height: 100px; float: left; margin: 10px; font-size: 3em; line-height: 96px; text-align: center;}
* html .scroll-content-item { display: inline; } /* IE6 float double margin bug */
.scroll-bar-wrap { clear: left; padding: 0px 4px 0 2px; margin: 0 -1px -1px -1px; }
.scroll-bar-wrap .ui-slider { background: none; border:0; height: 2em; margin: 0 auto;  }
.scroll-bar-wrap .ui-handle-helper-parent { position: relative; width: 100%; height: 100%; margin: 0 auto; }
.scroll-bar-wrap .ui-slider-handle { top:.2em; height: 1.5em; }
.scroll-bar-wrap .ui-slider-handle .ui-icon { margin: -8px auto 0; position: relative; top: 50%; }
</style>

//scrollpane parts
			var scrollPane = $( ".scroll-pane" ),
				scrollContent = $( ".scroll-content" );

			//build slider
			var scrollbar = $( ".scroll-bar" ).slider({
				slide: function( event, ui ) {
					if ( scrollContent.width() > scrollPane.width() ) {
						scrollContent.css( "margin-left", Math.round(
							ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
						) + "px" );
					} else {
						scrollContent.css( "margin-left", 0 );
					}
				}
			});

			//append icon to handle
			var handleHelper = scrollbar.find( ".ui-slider-handle" )
			.mousedown(function() {
				scrollbar.width( handleHelper.width() );
			})
			.mouseup(function() {
				scrollbar.width( "100%" );
			})
			.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
			.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();

			//change overflow to hidden now that slider handles the scrolling
			scrollPane.css( "overflow", "hidden" );

			//size scrollbar and handle proportionally to scroll distance
			function sizeScrollbar() {
				var remainder = scrollContent.width() - scrollPane.width();
				var proportion = remainder / scrollContent.width();
				var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
				scrollbar.find( ".ui-slider-handle" ).css({
					width: handleSize,
					"margin-left": -handleSize / 2
				});
				handleHelper.width( "" ).width( scrollbar.width() - handleSize );
			}

			//reset slider value based on scroll content position
			function resetValue() {
				var remainder = scrollPane.width() - scrollContent.width();
				var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
					parseInt( scrollContent.css( "margin-left" ) );
				var percentage = Math.round( leftVal / remainder * 100 );
				scrollbar.slider( "value", percentage );
			}

			//if the slider is 100% and window gets larger, reveal content
			function reflowContent() {
					var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
					var gap = scrollPane.width() - showing;
					if ( gap > 0 ) {
						scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
					}
			}

			//change handle position on window resize
			$( window ).resize(function() {
				resetValue();
				sizeScrollbar();
				reflowContent();
			});
			//init scrollbar size
			setTimeout( sizeScrollbar, 10 );//safari wants a timeout
	        
			$("#bg_1").click(function(){
				
				
				console.log(this + "clicked");
				
				
			});                                                        -->