// global variable, i know bad, used as a switch
current_selected_value = null;

/*
 * Renders the Corkboard
 */
function BuildCork(first_name, last_name){
    	// new object
    	var o = new Object(); 
    	o.first_name = first_name;
    	o.last_name  = last_name;

    	// standard list container 
    	var ul = "<ul id='sortable'></ul>";
    
    	// list items
    	var li = "<li class='ui-state-default'>" + o.first_name  + "</br>" +  o.last_name + "</li>";
    	var li2 = "<li class='ui-state-default'>Oh Hai</br>blah, testing</li>";
    	var li3 = "<li class='ui-state-default'>so ugly</li>";
    
    	// apply elements    
    	$("body").append(ul);
    	$("#sortable").append(li);
    	$("#sortable").append(li2);
    	$("#sortable").append(li3);
    	$("#sortable").sortable();
}

/*
 * Builds Toolbar and Checks for which page you are currently on
 */
function BuildToolbar(page){
	// build tool bar html
	html =	'<span id="span_menu">';
	html +=	'<input type="radio" id="menu" 	   	name="menu" />	<label for="menu">Menu</label>';
	html +=	'<input type="radio" id="corkboard" name="menu" />  <label for="corkboard">Corkboard</label>';
	html +=	'<input type="radio" id="help" name="menu" />  <label for="help">Help</label>';
	html +=	'<input type="radio" id="logout"    name="menu" />	<label for="logout">Logout</label>';
	html += '</span>';
	
	// write html
	document.getElementById('toolbar').innerHTML = html;
	
	// when dom is loaded, render button
	$(document).ready(function() {
		$(function(){
			$("#span_menu").buttonset();
		});
		
		// check the box for which page you are on
		$('#' + page).attr('checked', true);
		
		$('#logout').click(function() {
			window.location = "logout.php";
		});
		
	});
	
}

/*
 * Used to toggle description fields on 
 */
function toggleDescriptionOn(div_id){
	 toggleDescriptionOff();
	 RequestFormByAjaxPost(div_id);
	 $('#' + div_id).toggleClass('ui-helper-hidden', false);
	 current_selected_value = div_id;
}

/*
 * Used to toggle description fields off
 */
function toggleDescriptionOff(){
	if (current_selected_value != null) { $('#' + current_selected_value).toggleClass('ui-helper-hidden', true) ; }
}

/*
 * used for contact type screen
 */
function toggleContactType(value){
	if (value != ('0')) { $('#contact_info').toggleClass('ui-helper-hidden', false);} 
	else { $('#contact_info').toggleClass('ui-helper-hidden', true); }
}

/*
 * used for feed permissions settings
 */
function toggleShuffleFeature(value){
	$('#interval').toggleClass('ui-helper-hidden', value); 
	$('#label_interval').toggleClass('ui-helper-hidden', value); 
}

/*
 * used for feed permissions settings
 */
function togglePayPerSpaceFeature(value){
	if (value != ('none')){ 
		$('#cashamount').toggleClass('ui-helper-hidden', false);
		$('#label_cashamount').toggleClass('ui-helper-hidden', false);
		$('#flyerdays').toggleClass('ui-helper-hidden', false);
		$('#label_flyerdays').toggleClass('ui-helper-hidden', false);
	} 
	else { 
		$('#cashamount').toggleClass('ui-helper-hidden', true);
		$('#label_cashamount').toggleClass('ui-helper-hidden', true);
		$('#flyerdays').toggleClass('ui-helper-hidden',  true);
		$('#label_flyerdays').toggleClass('ui-helper-hidden',  true);
	}
}

/*
 * used to reset the form divs on ajax get
 */
function cleanContentAndFormFields(){
	$('#content').html("");
	$('#form_content').html("");
}
/*
 * Allow flyers to become editable by user BROKEN
 */
function ActivateSelectableContent(){
	
	$(function() {
		$( "#item_one" ).draggable({ 
				revert: "valid" 
				
				});

		$( "#droppable_editor" ).droppable({
			activeClass: "ui-state-hover",
			hoverClass: "ui-state-active",
			drop: function( event, ui ) {
				$( this )
					.addClass( "ui-state-highlight" )
					.find( "p" )
						.html( "Dropped!" );
			}
		});
	});
	
}

/*
 * Launches Modal Window to edit or remove flyers
 */
function LaunchEditorModal(div_id, is_remove){
	
	if (is_remove == false)
	{
		// make an ajax call to render a form window screen
		$.ajax({
	       	url: "flyer_constructor.php",
		   	type: 'post',
		   	data: {
					template: 'text'
		   	},
	        success: function(data) {
	 	   		$("#modal_editor").html(data);			
	       }
		});
		// render the dialog
		$("#modal_editor").dialog({
					autoOpen: false,
					modal: true,
					height: 800,
					width: 600,
					draggable: false,
					resizable: false,
					close: function() {
						//revert dropped entity
						dropped_editor.removeClass("ui-state-highlight").find("p").html("Drop here to edit flyer");
					}	
		});
	
		// open the dialog
		$( "#modal_editor" ).dialog( "open" );
	
	} 
	else
	{
		// render the dialog to commit flyer removal
		$("#modal_remove").dialog({
				resizable: false,
				height:250,
				width: 250,
				modal: true,
				buttons: {
					Delete: function() {
						$( this ).dialog( "close" );
						//revert dropped entity
						dropped_remove.removeClass("ui-state-error").find("p").html("Drop here to remove flyer");
						RemoveFlyer('item_one');
					},
					Cancel: function() {
						$( this ).dialog( "close" );
						//revert dropped entity
						dropped_remove.removeClass("ui-state-error").find("p").html("Drop here to remove flyer");
				}
			}	
		});
	
		// open the dialog
		$( "#modal_remove" ).dialog( "open" );
			
	}

}

/*
 * Enables "add" button in table
 */
function LoadAddButton(){
$(function() {
	$( "#add_button" ).button({
        icons: {
            primary: "ui-icon-plus"
        },
	 text: false
	})
});

}

/*
 * initalize the map's api via an onchange event
 */
function InitializeMapsAPI(address){
  	// load the data 
  	LoadTableEntry(address);
	
  	var latlng = new google.maps.LatLng();
	var geocoder = new google.maps.Geocoder();
	
	geocoder.geocode( {'address': address },
	function(data, status) { 
		 latlng = data[0].geometry.location;
		  
		 var myOptions = {
		    zoom: 10,
		    center: latlng,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  };

		  var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		  var marker = new google.maps.Marker({
		  	    position: latlng,
		  		animation: google.maps.Animation.DROP,
		  	    title:"Starbucks of Cambridge"
		  });

		  marker.setMap(map);
	});
}
/*
 * Load the address inside of the table
 */
function LoadTableEntry(address){	
	var location = {
		address_line: address.toString().split(',')[0],
		city		: address.toString().split(',')[1],
		state		: address.toString().split(',')[2],
		zip			: address.toString().split(',')[3]
	}	

	$("#table_address").html(location.address_line);
	$("#table_city").html(location.city);
	$("#table_state").html(location.state);
	$("#table_zip").html(location.zip);
	$("#flyers").attr( "disabled", false );		
}

/*
 * Load and Toggle the Menu
 */
function toggleAndLoadFeed(value){
	$('#tabs').toggleClass('ui-helper-hidden', false);
}

/*
 * Load the tab container, and use ajax for each of the tabs
 */
function LoadFeedManagerTabs(){
 		$(function() {
			$( "#tabs" ).tabs({
				ajaxOptions: {
				type: 'POST',
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			 }
			});
		});
}

/*
 * Called by flyer constructor, loads date picker
 */
function loadDatePicker(){
	$(function(){
		$('#event_date').datepicker();
	});
}

/*
 * Remove Flyer Element
 */
function RemoveFlyer(flyer_id){
	// makes ajax call
	
	// remove from the element list
	$("#" + flyer_id).remove();
	
	
}

/*
 * Load Page using AJAX GET
 */
function RequestPageByAjaxGet(page){	
	$.ajax({
	       url: page + ".php",
	       success: function(data) {
				cleanContentAndFormFields();
	 	   		$("#content").html(data);			
	       }
	});	
	return false;
}

/*
 * Submit Form using AJAX POST
 */
function SubmitFormByAjaxPost(page){	
	
	$.ajax({
	       url: "flyer_creation.php",
		   type: "post",
		   data: {
				title			: $("#title").val(),
				description		: $("#description").val(),
				location		: $("#location").val(),
				event_date   	: $("#event_date").val(),
				contact_id   	: $("#contact").val(),
				contact_name   	: $("#contact_name").val(),
				contact_info   	: $("#contact_info").val(),
				enable_qr	   	: $("#enable_qr").val(),
				image_meta_data	: image_meta_data,
				flyer_type		: page
		   },
		   beforeSend: function(){
				$("#form_content").mask("creating...");
		   },
	       success: function(data){
				console.log(data);
	 	   		$('#form_content').mask("completed!");	
	       },
		   error:  function(data){
				$("#form_content").unmask();
				$('#form_content').mask("Error Occured!",5000);	
		   },
		   complete: function(){
				RequestFormByAjaxPost(page)
				$('#form_content').unmask();
		   }
	});	
	return false;
}


/*
 * Load Page using AJAX post
 */
function RequestFormByAjaxPost(page){	
	$.ajax({
	       url: "flyer_constructor.php",
		   type: 'post',
		   data: {
				template: page
		   },
	       success: function(data) {
	 	   		$("#form_content").html(data);			
	       }
	});	
	return false;
}


