/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

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
function toggleManagerActionsOff()
{
	$('#ltext_preview').toggleClass('ui-state-active',false);
	$('#ltext_edit').toggleClass('ui-state-active',false);
	$('#ltext_remove').toggleClass('ui-state-active',false);	
	
	$('#ltext_image_preview').toggleClass('ui-state-active',false);
	$('#ltext_image_edit').toggleClass('ui-state-active',false);
	$('#ltext_image_remove').toggleClass('ui-state-active',false);
	
	$('#limage_preview').toggleClass('ui-state-active',false);
	$('#limage_edit').toggleClass('ui-state-active',false);
	$('#limage_remove').toggleClass('ui-state-active',false);
	
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
 * Using these button sets, users will be able to edit/remove/preview flyers
 */
function ActivateSelectableContent(){
	
	$(function() {		
		// render button sets
		$('#text_radio').buttonset();		
		$('#text_image_radio').buttonset();
		$('#image_radio').buttonset();
	});
	
	// text flyer menu click listeners
	$('#text_preview').click(function() {
		if ($('#tex_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		window.open('generate.php?flyerid=' + $('#text_flyer_select option:selected').val(),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no'); 
		self.close();
	});
	
	$('#text_edit').click(function() {		
		if ($('#text_flyer_select option:selected').val() == '0') { 			
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		} 
		LaunchEditorModal($('#text_flyer_select option:selected').val(),'text', false);
	});
	
	$('#text_remove').click(function() {
		if ($('#text_flyer_select option:selected').val() == '0') { 				
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		LaunchEditorModal($('#text_image_flyer_select option:selected').val(),'text', true);
	});
	
	// text_image flyer menu click listeners
	$('#text_image_preview').click(function() {
		if ($('#text_image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		window.open('generate.php?flyerid=' + $('#text_image_flyer_select option:selected').val(),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no');	
	});
	
	$('#text_image_edit').click(function() {
		if ($('#text_image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		LaunchEditorModal($('#text_image_flyer_select option:selected').val(),'text_image', false);
	});
	$('#text_image_remove').click(function() {
		if ($('#text_image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		LaunchEditorModal($('#text_image_flyer_select option:selected').val(),'text_image', true);
	});
	
	// image flyer menu click listeners
	$('#image_preview').click(function() {
		if ($('#image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		window.open('generate.php?flyerid=' + $('#image_flyer_select option:selected').val(),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no');
	});
	$('#image_edit').click(function() {
		if ($('#image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		LaunchEditorModal($('#image_flyer_select option:selected').val(),'image', false);
	});
	$('#image_remove').click(function() {
		if ($('#image_flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		LaunchEditorModal($('#text_image_flyer_select option:selected').val(),'image', true);
	});
}

/*
 * Launches Modal Window to edit or remove flyers
 */
function LaunchEditorModal(flyer_id, page, is_remove){
	
	if (is_remove == false)
	{
		// make an ajax call to render a form window screen
		$.ajax({
	       	url:  "flyer_editor.php",
		   	type: 'post',
		   	data: {
					template: page,
					users_flyer_id: $('#' + page +'_flyer_select option:selected').val()
		   	},
	        success: function(data) {
				$("#modal_editor").html(data);		
	       }
		});
		// render the dialog
		$("#modal_editor").dialog({
					autoOpen: false,
					cache: false,
					modal: true,
					height: 565,
					width:  550,
					draggable: false,
					resizable: false,
					title: 'Updating Flyer: ' + $('#' + page +'_flyer_select option:selected').html(),
					close: function() {
					 	toggleManagerActionsOff();
					}	
		});
		// open the dialog
		$( "#modal_editor" ).dialog( "open" );
	
	} 
	else
	{
	
		PendingPurgeFlyer(page);
		
		// render the dialog to commit flyer removal
		$("#modal_remove").dialog({
				resizable: false,
				autoOpen:  false,
				height:    250,
				cache:     false,
				width:     250,
				modal:     true,
				buttons: {
					Delete: function() {
							if (PurgeFlyer(flyer, page) == true) {					
									$( this ).dialog( "close" );
									toggleManagerActionsOff();
									$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer removal was a success!</label>");
									RequestPageByAjaxGet('flyer_manager');
								}
						
					},
					Cancel: function() {
						toggleManagerActionsOff();
						$( this ).dialog( "close" );						
				}
			}	
		});
	
		// open the dialog
		$( "#modal_remove" ).dialog( "open" );
			
	}

}

/*
 * Prepares the deletion dialog for removal
 */
function PendingPurgeFlyer(page){
		// make an ajax call to render a form window screen
		$.ajax({
	      	url:  "flyer_remove.php",
		   	type: 'post',
		   	data: {
					template: page,
					users_flyer_id: $('#' + page +'_flyer_select option:selected').val(),
					is_purge: 'false'
		   	},
	        success: function(data) {
				 	flyer = data;
					flyer['type'] = page;		
					$('#ltitle').html(flyer['title']);
					$('#modal_remove').dialog("option","title",'Remove Flyer -> ' + flyer['title']);
		    }
		});
}

/*
 *  It may actually remove the flyer
 */
function PurgeFlyer(data, page)
{
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "flyer_remove.php",
	   	type: 'post',
	   	data: {
				template	: page,
				flyer		: flyer,
				is_purge	: 'true'
	   	},
		beforeSend: function(){
			$("#modal_remove").mask("Removing...");
		},
		error: function(data)
		{
			$("#modal_remove").html(data);
		},
        success: function(data) {
			$("#modal_remove").unmask();
       }
	});
	
	return true;
	
	
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
 * Enables "remove" button in table
 */
function LoadRemoveButton(id){
$(function() {
	$( "#" + id ).button({
        icons: {
            primary: "ui-icon-minus"
        },
	 text: true
	})
});
}

function RemovePost(value, id)
{
	
	
	alert(value + ' ' + id);
	
}

/*
 * initalize the map's api via an onchange event
 */
function InitializeMapsAPI(address){
  	// load the data 
	
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
	
	LoadTableEntry(address);
}
/*
 * Load the address inside of the table
 */
function LoadTableEntry(address){	
 	
	// create location object
   var location = {
		address_line: address.toString().split(',')[0],
		city		: address.toString().split(',')[1],
		state		: address.toString().split(',')[2],
		zip			: address.toString().split(',')[3],
		board_id	: address.toString().split(',')[4],
		permission	: address.toString().split(',')[5]
	}	

	$("#table_address").html(location.address_line + "<br>" + location.city + ", " + location.state + "<br>" + location.zip);
	$("#table_permission").html(location.permission);
	$("#add_button").val(location.board_id);
	$("#flyers").attr( "disabled", false );		
}

/*
 * Load and Toggle the Menu
 */
function toggleAndLoadBoard(value){
	
	if (value == 'create'){LoadNewBoardPreferences();} 
	else 
	{ 
		$('#tabs').toggleClass('ui-helper-hidden', false); 	 	
		LoadBoardManagerTabs(value);
		$('#tabs').tabs("option","selected",0);
	}

}

/*
 * Load the tab container, and use ajax for each of the tabs
 */
function LoadBoardManagerTabs(value){
	
 		$(function() {
			$( "#tabs" ).tabs({
				ajaxOptions: {
				type: 'get',
				data: {
					board_id: value
				},
				success: function(data){

				},
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
 * Load's modal for new board
 */
function LoadNewBoardPreferences(){
		// render the dialog
		
		RequestBoardByAjaxPost('create');
		$("#modal_board_preferences").dialog({
					autoOpen: false,
					cache: false,
					modal: true,
					height: 565,
					width:  550,
					draggable: false,
					resizable: false,
					title: 'New Board',
					close: function() {
						// probably load the new board here
					}	
		});
		// open the dialog
		$( "#modal_board_preferences" ).dialog( "open" );	
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
 * Load Page using AJAX GET
 */
function RequestPageByAjaxGet(page){	
	$.ajax({
	       url: page + ".php",
		   cache: false,
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
				$("#form_content").unmask();
				$('#status_messages').toggleClass('ui-helper-hidden', false);
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer successfully inserted, go to flyer manager to edit text or remove flyer, or Post Flyer to post to a board.</label>");
	       },
		   error:  function(data){
				$("#form_content").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer insertion failed, please try again later</label>");
		   },
		   complete: function(){
				RequestFormByAjaxPost(page);
				$('#form_content').unmask();

		   }
	});	
	return false;
}

/*
 * Submit Form using AJAX POST
 */
function SubmitBoardByAjaxPost(){	
	
	$.ajax({
	       url: "board_creation.php",
		   type: "post",
		   data: {
				title			: $("#title").val(),
				description		: $("#desc").val(),
				address			: $("#address").val(),
				city   			: $("#city").val(),
				state   		: $("#state").val(),
				zipcode   		: $("#zipcode").val(),
				permissions   	: $('input[name=permissions]:checked').val(),
				flyerexpire	   	: $("#flyerexpire").val(),
				shuffle   		: $("#shuffle").val(),
				interval	   	: $("#interval").val(),
				postperspace	: $("#postpayment option:selected").val(),
				cashmount	   	: $("#cashamount").val(),
				flyerdays	   	: $("#flyerdays").val()
		   },
		   beforeSend: function(){
				$("#new_board").mask("creating...");
		   },
	       success: function(data){
				$("#new_board").unmask();
				$('#status_messages').toggleClass('ui-helper-hidden', false);
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board successfully created</label>");
	       },
		   error:  function(data){
				$("#new_board").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board creation failed, please try again later</label>");
		   },
		   complete: function(data){
				//make this load the preferences screen
				RequestPageByAjaxGet('board_manager');
				$( "#modal_board_preferences" ).dialog( "close" );
				$('#new_board').unmask();

		   }
	});	
	return false;
}

function PreparePurgeBoard(){	
		var id = $('#board_select option:selected').val();		
		// render the dialog to commit flyer removal
		$("#modal_remove").dialog({
				resizable: false,
				autoOpen:  false,
				height:    250,
				cache:     false,
				width:     250,
				modal:     true,
				buttons: {
					Delete: function() {
						if (PurgeBoard(id) == true) {					
								$( this ).dialog( "close" );
								toggleManagerActionsOff();
								$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board removal was a success!</label>");
								RequestPageByAjaxGet('board_manager');
							}
					},
					Cancel: function() {
						$( this ).dialog( "close" );						
				}
			}	
		});
	
		// open the dialog
		$( "#modal_remove" ).dialog( "open" );		
}

/*
 * Purge Board using AJAX POST
 */
function PurgeBoard(id){
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "board_remove.php",
	   	type: 'post',
		cache: false,
	   	data: {
				id	: id
	   	},
		beforeSend: function(){
			$("#modal_remove").mask("Removing...");
		},
		error: function(data)
		{
			$("#modal_remove").html(data);
		},
        success: function(data) {
			$("#modal_remove").unmask();
       }
	});
	return true;
}

function LaunchFlyerPortables(){
	
	$(function() {
		$( ".column" ).sortable({
			connectWith: ".column"
		});

		$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
			.find( ".portlet-header" )
				.addClass( "ui-widget-header ui-corner-all" )
				.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
				.end()
			.find( ".portlet-content" );

		$( ".portlet-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
		});

		$( ".column" ).disableSelection();
	});
	
	
}

/*
 * Update Board using AJAX POST
 */
function UpdateBoardByAjaxPost(board_id, page){	
	var updates = [];
	
	switch(page){
		case "general":
				 updates = {
						id				: $("#id").val(),
						page			: page,
						title			: $("#title").val(),
						description		: $("#desc").val(),
						address			: $("#address").val(),
						city			: $("#city").val(),
						state   		: $("#state").val(),
						zipcode   		: $("#zipcode").val(),
				}
		break;
		case "permission":
				 updates = {
						id				: $("#id").val(),
						page			: page,
						permissions   	: $('input[name=permissions]:checked').val()
				}
		break;
		case "posting":
				 updates = {
						id				: $("#id").val(),
						page			: page,
						flyerexpire	   	: $("#flyerexpire").val(),
						shuffle   		: $("#shuffle").val(),
						interval	   	: $("#interval").val(),
						postperspace	: $("#postpayment option:selected").val(),
						cashamount	   	: $("#cashamount").val(),
						flyerdays	   	: $("#flyerdays").val()
				}
		break;
	}

		$.ajax({
						       url: "board_update.php",
							   type: "post",
							   data: {
							   updates: updates
							   },
							   beforeSend: function(){
									$("#tabs").mask("updating...");
							   },
						       success: function(data){
									$("#tabs").unmask();
									$('#status_messages').toggleClass('ui-helper-hidden', false);
									$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board successfully updated</label>");
						       },
							   error:  function(data){
									$("#tabs").unmask();
									$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board update failed, please try again later</label>");
							   },
							   complete: function(data){
								$("#dialog-message").html("<label style='color: #9BCC60;'>Board successfully updated</label>");
									//make this load the preferences screen
									$( "#dialog-message" ).dialog({
												modal: true,
												resizable: false,
												buttons: {
													ok: function() {
														$( this ).dialog( "close" );
													}
											}
									});
									$('#tabs').unmask();
						
							   }
						});	
	return false;	
}

/*
 * Update the location list when use switches his or her state
 */
function UpdateLocationsByAjaxPost(state_id)
{
		$.ajax({
			url: "post_location_update.php",
			type: "post",
			data: {
					state_id: state_id
			},
			beforeSend: function(){
					$("#locations").mask("updating...");
			},
			success: function(data){
					$("#locations").unmask();
					$("#locations").html(data);
			},
			error:  function(data){
					$("#locations").unmask();
					$("#status_messages").html("<label style='color: #9BCC60;'>Messages: location update failed, please try again later</label>");
			}
		});
}

/*
 * Submit Post by using AJAX POST
 */
function PostToLocation(board_id){
	
	if (board_id == 0) { alert("Please select a board to post to!"); return false; }
	
	if ($("#flyers option:selected").val() == 0) { alert("Please select a flyer to post!"); return false; }
	
	var post_status_desc = $("#table_permission").html();
	var post_status_id = 1;
		
	switch (post_status_desc)
	{
		case "Public":
		 	post_status_id = 1;
		break;
		
		case "By Approval":
			post_status_id = 2;
		break;		
	}

	$.ajax({
		url: "post_to_location.php",
		type: "post",
		data: {
				boardid: 		board_id,
				users_flyer_id: $("#flyers option:selected").val(),
				post_status_id: post_status_id
		},
		beforeSend: function(){
				$("#locations").mask("updating...");
		},
		success: function(data){
				$("#locations").unmask();
				console.log(data);
				// LEFT OFF HERE
		},
		error:  function(data){
				$("#locations").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: location update failed, please try again later</label>");
		}
	});
	
}
/*
 * Populate Portable Flyers
 */



/*
 * Submit Form using AJAX POST
 */
function UpdateFormByAjaxPost(page){	

	$.ajax({
	       url: "flyer_edit.php",
		   cache: false,
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
				flyer_id		: $("#flyer_id").val(),
				flyer_type		: page
		   },
		   beforeSend: function(){
				$("#modal_editor").mask("updating...");
		   },
	       success: function(data){
				$("#modal_editor").unmask();
				$('#status_messages').toggleClass('ui-helper-hidden', false);
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer update was a success!</label>");
	       },
		   error:  function(data){
				$("#modal_editor").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer update was fail, please try again later!</label>");
		   },
		   complete: function(){
				$( "#modal_editor" ).dialog( "close" );
				RequestPageByAjaxGet('flyer_manager');
				$('#modal_editor').unmask();

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
		   cache: false,
		   data: {
				template: page
		   },
	       success: function(data) {
	 	   		$("#form_content").html(data);			
	       }
	});	
	return false;
}


/*
 * Load Page using AJAX post
 */
function RequestBoardByAjaxPost(page){	
	$.ajax({
	       url: "board_constructor.php",
		   type: 'get',
		   data: {
				template: page
		   },
	       success: function(data) {
	 	   		$("#modal_board_preferences").html(data);			
	       }
	});	
	return false;
}

