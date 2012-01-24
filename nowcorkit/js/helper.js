/***********************************************************************
 * helper.js
 * Author		  : Christopher Bartholomew
 * Last Updated  :  12/08/2011
 * Purpose		 : The dreaded and heavy helpers file for the application. 
 * I will probably endup not just combine similar functions in the future,
 * but also I will probably minafy it as it's really heavy.
 **********************************************************************/

// global variable, i know bad, used as a switch
current_selected_value = null;

/*
 * Renders the Corkboard [converted]
 */
function BuildCork(){
	window.location = "corkboard.php?boardid=" + $('#board_select option:selected ').val();
}

/*
 * Builds Toolbar and Checks for which page you are currently on [converted]
 */
function BuildToolbar(page){
	// build tool bar html
	html =	'<span id="span_menu">';
	html +=	'<input type="radio" id="menu" 	   	name="menu" />	<label for="menu">Menu</label>';
	html +=	'<input type="radio" id="help" 		name="menu" />  <label for="help">Help</label>';
	html +=	'<input type="radio" id="user" 		name="menu" />  <label for="user">Preferences</label>';
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
		
		$('#help').click(function() {
			//left off here
			LaunchHelpModal();	
		});
		
		$('#menu').click(function(){			
			cleanContentAndFormFields();		
		});
		
		$('#user').click(function() {
			$.ajax({
			       url: "update_registration.php",
				   type: "post",
				   beforeSend: function(){
						$("#content").mask("pulling...");
				   },
			       success: function(data){
						$("#content").unmask();
						$('#content').html(data);
			       },
				   error:  function(data){
						$("#content").unmask();
						$("#content").html(data);
				   }
			});
		});	
	});
}

/*
 * Used to toggle description fields on [converted]
 */
function toggleDescriptionOn(div_id){
	 toggleDescriptionOff();
	 RequestFormByAjaxPost(div_id);
	 $('#' + div_id).toggleClass('ui-helper-hidden', false);
	 current_selected_value = div_id;
}

/*
 * Used to toggle description fields off [converted]
 */
function toggleDescriptionOff(){
	if (current_selected_value != null) { $('#' + current_selected_value).toggleClass('ui-helper-hidden', true) ; }
}

/*
 * used for contact type screen [converted]
 */
function toggleContactType(value){
	if (value != ('0')) { $('#contact_info').toggleClass('ui-helper-hidden', false);} 
	else { $('#contact_info').toggleClass('ui-helper-hidden', true); }
}

/*
 * used for feed permissions settings [dead]
 */
function toggleShuffleFeature(value){
	$('#interval').toggleClass('ui-helper-hidden', value); 
	$('#label_interval').toggleClass('ui-helper-hidden', value); 
}

/*
 * used for feed permissions settings [converted]
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
 * used as a toggler for pay per space [converted]
 */
function togglePayPerSpaceFeature(value){
	if (value != ('1')){ 
		$('#cashamount').toggleClass('ui-helper-hidden', false);
		$('#label_cashamount').toggleClass('ui-helper-hidden', false);
		$('#flyerdays').toggleClass('ui-helper-hidden', false);
		$('#label_flyerdays').toggleClass('ui-helper-hidden', false);
		$('#pay_handle').toggleClass('ui-helper-hidden', false);
		$('#label_pay_handle').toggleClass('ui-helper-hidden',false);
	} 
	else 
	{ 
		$('#cashamount').toggleClass('ui-helper-hidden', true);
		$('#label_cashamount').toggleClass('ui-helper-hidden', true);
		$('#flyerdays').toggleClass('ui-helper-hidden',  true);
		$('#label_flyerdays').toggleClass('ui-helper-hidden',  true);
		$('#pay_handle').toggleClass('ui-helper-hidden', true);
		$('#label_pay_handle').toggleClass('ui-helper-hidden',true);
	}
}


/*
 * Previews the flyer based on the users cork id [Converted]
 */
function preview_flyer(id)
{
	window.open('generate.php?flyerid=' + id,null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no'); 
	self.close();
}

/*
 * used to reset the form divs on ajax get [Converted]
 */
function cleanContentAndFormFields(){
	$('#content').html("");
	$('#form_content').html("");
}
/*
 * Using these button sets, users will be able to edit/remove/preview flyers [Converted]
 * so large because it's rendering using jquery that builds thebutton sets
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
 * used for rendering buttons specific to post menu [TODO]
 */
function RenderPostActionButtons(id)
{
	//var flyer_id = id.split('_')[1];
	$(function() {
		// preview
		$( "#preview_" + id ).button({
	        icons: {
	            primary: "ui-icon-search"
	        },
		 label: "Preview",
		 text: false
		}),
		$("#preview_" + id ).click(function() {
			window.open('generate.php?flyerid=' + $('#preview_' + id).attr('name'),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no');
		}),
		$( "#approve_" + id ).button({
	        icons: {
	            primary: "ui-icon-check"
	        },
		 label: "Approve",
		 text: false
		}),
		$("#approve_" + id).click(function() {
				ApprovePost(id, true);
				var filter_id = $('input[name=filter]:checked', '#filters').val();
				UpdatePostFilterByAjaxPost(filter_id);
		}),
		$( "#remove_" + id ).button({
	        icons: {
	            primary: "ui-icon-minus"
	        },
		 label: "Remove",
		 text: false
		}),
		$("#remove_" + id).click(function() {			
				
				var m = new ModalDialog({
					div: "modal_dialog",
					title: "Problem Removing",
					height: "300",
					width: "300",
					text: "Can't remove flyer because its status is 'PPS - Posted'. Only the poster may remove."
				});
				
				var pps = CheckPPS(id);			
				if (pps["is_pps"] == true) {m.open();}
				else 
				{
					ApprovePost(id, false);
					var filter_id = $('input[name=filter]:checked', '#filters').val();
					UpdatePostFilterByAjaxPost(filter_id);
				}
		}),
		$( "#pps_" + id ).button({
	        icons: {
	            primary: "ui-icon-pin-s"
	        },
		 label: "Begin PPS",
		 text: false
		}),
		$("#pps_" + id ).click(function() {
				// make request to begin pps			
				var pps = CheckPPS(id);	
				
				// prepare dialog
				var m = new ModalDialog({
					div: "modal_dialog",
					title: "Problem Adding PPS",
					height: "300",
					width: "300",
					text: "Can't enable PPS because you have no more slots avaliable. Please wait until a PPS Posted Flyer expires!"
				});	
				
				if (pps["is_max"] == true) { m.open(); }
				else if (pps["is_pps"] == true)
				{
					// reset the modal info
					m.setInfo({
						title: "Already PPS",
						text: "This post is already in PPS Status"
					});					
					m.open();					
				}
				else 
				{		
					BeginPPS(id);
				}
		});
	});
}

/*
 * used to check pps [converted]
 */
function CheckPPS(id)
{
	var result = [];
	$.ajax({
		async: false,
		url: "pps_check.php",
		type: 'POST',
		data:{
			board_id: 	$('#board_select option:selected').val(),
			board_post_id: id,
		},
		success: function(data){
			result = data;
		},
		error: function(data){
			console.log("problem");
		}
	});
	return result
}
/*
 *
 * Updates the post field cotent with filtered data [converted]
 */
function UpdatePostFilterByAjaxPost(filter_id)
{
	$.ajax({
	       url: "board_constructor.php",
		   type: 'get',
		   data: {
				template	: "render_posts",
				board_id	: $("#board_id").val(),
				filter_value: filter_id
		   },
			beforeSend: function(){
				$("#post_content").mask("loading...");
			},
	       success: function(data) {
				$("#post_content").unmask();
	 	   		$("#post_content").html(data);			
	       }
	});	
	return false;
	
	
}

/* 
 * Launches and Renders Modal for Help [Converted]
 */ 
function LaunchHelpModal(){	
	
	$(function(){
		$.ajax({
			url: 'help.php',
			type: 'GET',
			success: function(data){
				$('#modal_help').html(data);	
			},
			failure: function(){
				$('#modal_help').html("Problem loading content");
			}
		});
	});
	// render the dialog
	$("#modal_help").dialog({
				autoOpen: false,
				cache: false,
				modal: true,
				height: 600,
				width:  550,
				draggable: false,
				resizable: false,
				title: 'Help Menu',
	});
	// open the dialog
	$( "#modal_help" ).dialog( "open" );	
}
/*
 * Launches Modal Window to edit or remove flyers [Converted]
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
 * Prepares the deletion dialog for removal [Converted]
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
 *  It may actually remove the flyer [Converted]
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
 * Enables "add" button in table [TODO]
 */
function LoadAddButton(){
	$(function() {
		$( "#add_button" ).button({
	        icons: {
	            primary: "ui-icon-plus"
	        },
		 text: false
		}),
		$( "#pps_button" ).button({
	        icons: {
	            primary: "ui-icon-notice"
	        },
		 text: false
		})
	});
}

/*
 * Enables "remove" button in table [TODO]
 */
function LoadRemoveButton(id){ 
$(function() {
	$( "#" + id ).button({
        icons: {
            primary: "ui-icon-minus"
        },
	 text: false
	})
});
}
/*
 * Removes post from board [TODO]
 */
function RemovePost(id)
{
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "post_remove.php",
	   	type: 'post',
		cache: false,
	   	data: {
				id	: id
	   	},
		beforeSend: function(){
			$("#column").mask("Removing...");
		},
		error: function(data)
		{
			$("#column").html(data);
		},
        success: function(data) {
	 		$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been removed from this board</label>");
			RefreshPostList();
			$("#column").unmask();
       },
	});
	return true;	
}
/*
 * Will not-approve post or approve post [converted]
 */
function ApprovePost(id, is_approve)
{
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "post_approve.php",
	   	type: 'post',
		cache: false,
	   	data: {
				id			: id,
				is_approve  : is_approve
	   	},
		beforeSend: function(){
			$("#tabs").mask("updating...");
		},
		error: function(data)
		{
			$("#tabs").html(data);
		},
        success: function(data) {
			$("#tabs").unmask();
			if (is_approve == true)
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been <i>approved</i> for this board</label>");
			else
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post is set to <i>not approved</i> for this board</label>");
				
			
			RefreshPostList();

       },
	});
	return true;	
}

/*
 * Execute the modal to begin pps mobile [converted]
 */
function BeginPPS(id)
{	
	var now 		=  new Date();
	var expire_date =  new Date($("#pps_" + id ).attr("expire"));
	
	expire_date.add('d',1);
	now.add('d',1);
	
	var flyerdays   =  $("#pps_" + id ).attr("flyerdays");	
	var diff		=  expire_date.getDate() - now.getDate();
	
	if 	(flyerdays > diff) { expire_date.add("d", (flyerdays - diff)); }
		
	$("#dialog-message").html("<label style='color: #9BCC60;'>Enabling PPS will keep this flyer visable until " + expire_date.toDateString() + ". Once posted, it can only be removed by the person who posted it.<br><br>Continue?</label>");
		//make this load the preferences screen
	$( "#dialog-message" ).dialog({
					modal: true,
					title: "Enabling PPS",
					resizable: false,
					buttons: {
						ok: function() {
							RequestPPSEnabled(id);
							$( this ).dialog( "close" );
						},
						cancel: function() {
							$( this ).dialog( "close" );
						}
				}
	});	
	return false;
}

/* 
 * Makes ajax request to enable pps [converted]
 */
function RequestPPSEnabled(id)
{
		// make an ajax call to render a form window screen
		$.ajax({
	       	url:  "post_pps.php",
		   	type: 'post',
			cache: false,
		   	data: {
					board_id	   : $('#board_select option:selected').val(),
					board_post_id  : id
		   	},
				beforeSend: function(){
				$("#tabs").mask("updating...");
			},
			error: function(data)
			{
				$("#tabs").html(data);
			},
	        success: function(data) {
			    console.log(data);
				$("#tabs").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been set to <i>PPS - Posted</i> for this board</label>");
				var filter_id = $('input[name=filter]:checked', '#filters').val();
				UpdatePostFilterByAjaxPost(filter_id);
	       },
		});
		return false;	
}

/*
 * Remove post from manager screen [converted]
 */
function RemoveManagerPost(id) 
{
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "post_remove.php",
	   	type: 'post',
		cache: false,
	   	data: {
				id	: id
	   	},
		beforeSend: function(){
			$("#tabs").mask("Removing...");
		},
		error: function(data)
		{
			$("#tabs").html(data);
		},
        success: function(data) {
	 		$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been removed from this board</label>");
			$("#tabs").tabs( "load" , 4 );
			$("#tabs").unmask();
       },
	});
	return true;	
}
/*
 * initalize the map's api via an onchange event [TODO]
 */
function RefreshPostList()
{
	
	// make an ajax call to render a form window screen
	$.ajax({
       	url:  "post_refresh.php",
	   	type: 'post',
		cache: false,
		beforeSend: function(){
			$("#posting").mask("Updating...");
		},
		error: function(data)
		{
			$("#posting").html(data);
		},
        success: function(data) {
			$("#posting").html(data);
			$("#posting").unmask();
       }
	});
	return true;
		
}

/*
 * initalize the map's api via an onchange event
 */
function InitializeMapsAPI(address){
  		
		// load the data 
		
		var a = address.split(',');
		var map_address = "";
		for (i=0;i<4;i++) { map_address += a[i].toString() + ",";  }
		
	  	var latlng = new google.maps.LatLng();
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( {'address': map_address },
		function(data, status) { 
			try
			{
			 	latlng = data[0].geometry.location;
			}
		  	catch(ex)
			{
				console.log(ex);
			}
			
			 var myOptions = {
			    zoom: 10,
			    center: latlng,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			  };

			  var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
			  var marker = new google.maps.Marker({
			  	    position: latlng,
			  		animation: google.maps.Animation.DROP,
			  	    title:""
			  });

			  marker.setMap(map);
		});

	LoadTableEntry(address);
}
/*
 * Load the address inside of the table [TODO]
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
 * Load and Toggle the Menu [converted]
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
 * Load the tab container, and use ajax for each of the tabs [converted]
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
 * Loads modal for new board  [converted]
 */
function LoadNewBoardPreferences(){
		// render the dialog
		
		RequestBoardByAjaxPost('create');
		$("#modal_board_preferences").dialog({
					autoOpen: false,
					cache: false,
					modal: true,
					//height: 500,
					width:  550,
					draggable: true,
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
 * Shows the PPS Information about this location  [TODO]
 */ 
function LoadModalPPSInformation()
{
	
	$("#pps_modal").dialog({
				autoOpen: false,
				cache: false,
				modal: true,
				height: 200,
				width:  600,
				draggable: false,
				resizable: false,
				title: 'PPS Information',
				close: function() {
					// nothing
				}	
	});
		
	var pps_info = $('#location option:selected').val();
	
	var m = new ModalDialog({
		div: "modal_dialog",
		title: "No Location",
		height: "300",
		width: "300",
		text: "Please select a location first!"
	});
	
	if (pps_info == "0") { return m.open(); }
	
	var pps = 
	{
		pps_id 	   : pps_info.toString().split(',')[6].split('|')[0],
		pps_cash   : pps_info.toString().split(',')[6].split('|')[1],
		pps_flyer  : pps_info.toString().split(',')[6].split('|')[2],
		pps_payment: pps_info.toString().split(',')[6].split('|')[3],
		pps_slots  : pps_info.toString().split(',')[6].split('|')[4]
	};
		
	var pps_html = "";	
	
	switch(pps.pps_id)
	{
		case "1":
			pps_html += "This board does not have PPS enabled.";
		break;
		default:
			var type_desc = (pps.pps_id == "2") ? "By Donation" : "By Payment";
			 
			pps_html += "<table>";
		 	pps_html += "<tr><td><i>Type:</i></td><td>"    	             		       + type_desc       + "</td></tr>";
		 	pps_html += "<tr><td><i>This Amount:</td><td></i>"  			     	   + pps.pps_cash    + "</td></tr>";
		 	pps_html += "<tr><td><i>For Days:</td><td></i>" 	 		     	 	   + pps.pps_flyer   + "</td></tr>";
			pps_html += "<tr><td><i>Slots:</td><td></i>"					   		   + pps.pps_slots   + "</td></tr>";		
		 	pps_html += "<tr><td colspan='2'><i>Paymenet Handling:</i><br><br>"        + pps.pps_payment + "</td></tr>";	 
		 	pps_html += "</table>";
		break;
		
	}
			 
	$('#pps_modal').html(pps_html);
		
	// open the dialog
	$( "#pps_modal" ).dialog( "open" );
	
}

/*
 * Called by flyer constructor, loads date picker [CONVERTED]
 */
function loadDatePicker(){
	$(function(){
		$('#event_date').datepicker();
	});
}

/*
* Load Page using AJAX GET [CONVERTED]
*/
function RequestPageByAjaxGet(page){	
			$.ajax({
			       url: page + ".php",
				   cache: false,
					beforeSend: function(){
					$("#content").mask("loading...");
				   },
			       success: function(data) {
						$("#content").unmask();
						cleanContentAndFormFields();
			 	   		$("#content").html(data);			
			       }
			});	
			return false;
		}

/*
 * Submit Form using AJAX POST [Converted]
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
				image_meta_data	: image_meta_data.create_output(),
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
 * Submit Board using AJAX POST [converted]
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
				flyerdays	   	: $("#flyerdays").val(),
				pay_handle		: $("#pay_handle").val()
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

/*
 * Prepare Purge Board using AJAX POST [converted]
 */
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
						if (PurgeBoard() == true) {					
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
 * Purge Board using AJAX POST [converted]
 */
function PurgeBoard(){
	var id = $('#board_select option:selected').val();	
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
        },
		completed: function(data) {
			$("#modal_remove").unmask();
		}
	});
	return true;
}

/*
 * Rendres the portables for the flyers [Taken Out]
 */
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
 * Update Board using AJAX POST  [converted]
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
						flyerdays	   	: $("#flyerdays").val(),
						pay_handle		: $("#pay_handle").val()		
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
 * Update the location list when use switches his or her state  [TODO]
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
 * Submit Post by using AJAX POST  [TODO]
 */
function PostToLocation(board_id){
	
	var m = new ModalDialog({
		div: "modal_dialog",
		title: "No Board",
		height: "200",
		width: "600",
		text: "Please select a board to post to!"
	});
	
	if (board_id == 0) { m.open(); return false; }
	
	m.setInfo({
		title: "No Flyer",
		text:  "Please select a flyer to post!"
	});
	
	if ($("#flyers option:selected").val() == 0) { m.open(); return false; }
	
	var post_status_desc = $("#table_permission").html();
	var post_status_id = 1;
		
	switch (post_status_desc)
	{
		case "Public":
		 	post_status_id = 1;
		break;
		
		case "By Approval ":
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
				RefreshPostList();
		},
		error:  function(data){
				$("#locations").unmask();
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: location update failed, please try again later</label>");
		}
	});
	
}

/*
 * Submit Form using AJAX POST [CONVERTED]
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
 * Load Page using AJAX post [CONVERTED]
 */
function RequestFormByAjaxPost(page){	
	$.ajax({
	       url: "flyer_constructor.php",
		   type: 'post',
		   cache: false,
		   data: {
				template: page
		   },
			beforeSend: function(){
				$("#form_content").mask("loading...");
			},
	       success: function(data) {
				$("#form_content").unmask();
	 	   		$("#form_content").html(data);			
	       }
	});	
	return false;
}

/*
 * Load Page using AJAX post  [converted]
 */
function RequestBoardByAjaxPost(page){	
	$.ajax({
	       url: "board_constructor.php",
		   type: 'get',
		   data: {
				template: page
		   },
			beforeSend: function(){
				$("#modal_board_preferences").mask("loading...");
			},
	       success: function(data) {
				$("#form_content").unmask();
	 	   		$("#modal_board_preferences").html(data);			
	       }
	});	
	return false;
}

/*
 * Called from the manager menu allows the rendering
 * of the actual corkboard. Will be modifying this to
 * post after demo  [TODO]
 */
function GenerateBoard(board_id)
{	
	$.ajax({
	       url: "generate_board.php",
		   type: 'post',
		   data: {
				board_id: board_id
		   },
			beforeSend: function(){
			
			},
	       success: function(data) {
				console.log(data);
	       }
	});
}
