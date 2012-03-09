function Flyer(config)
{
	var param = config.param;
	var that  = this;
	
	var manager_div_list = 
						 [
						  "ltext_preview", 
						  "ltext_edit", 
						  "ltext_remove", 
						  "ltext_image_preview",
						  "ltext_image_edit",
						  "ltext_image_remove",
						  "limage_preview",
						  "limage_edit",
						  "limage_remove"
						];
	
	var flyer = 
	{
		'0': {id: 'none'},
		'1': {id: 'text'},
		'2': {id: 'text_image'},
		'3': {id: 'image'}	
	};

	function set_flyer(fid)
	{
		param = fid;
	};
	
	function request_flyer_template()
	{
		$.ajax({
		       url: "flyer_constructor.php",
			   type: 'post',
			   cache: false,
			   data: {
					template: flyer[param].id
			   },
				beforeSend: function(){
					$("#form_content").mask("loading...");
				},
		       success: function(data) {
					$("#form_content").unmask();
		 	   		$("#form_content").html(data);	
					
					/* enable only for text and text image*/
					( flyer[param].id != 'image' ) ? that.enable_datepicker() : null;
					/* enable form features*/
					that.enable_checkbox();
					that.enable_contacttype();
					
		       }
		});	
		
		return false;
	}
	
	function submit_flyer_template()
	{
		var modal = new ModalDialog({
				div    : "modal_dialog",
				title  : "",
				height : 350,
				width  : 350,
				text   : ""	
		});
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
					flyer_type		: flyer[param].id
			   },
			   beforeSend: function(){
					$("#form_content").mask("creating...");
			   },
		       success: function(data){
					$("#form_content").unmask();
					
					var info = {
						title:"Flyer Submit",
						text: "Flyer successfully inserted, go to flyer manager to edit text or remove flyer, or Post Flyer to post to a board.",
						height: 350,
						width: 350
					};
					
					modal.set_info(info);
					modal.open();
		       },
			   error:  function(data){
					$("#form_content").unmask();
					
					var error_info = {
						title: "Flyer Failed",
						text:  "Flyer insertion failed, please try again later."
					};
					
					modal.set_info(error_info);
					modal.open();
			   },
			   complete: function(){
					request_flyer_template();
					$('#form_content').unmask();
			   }
		});	
		
		return false;	
	}
	
	function edit_flyer()
	{
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
					flyer_type		: flyer[param].id
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
					$.getScript('js/menu.js', function(){
						var menu = new Menu({param: '1'});
						menu.get_menu_page('1');
					});					
					$('#modal_editor').unmask();

			   }
		});	
		return false;
	};

	function request_flyer_edit()
	{
		$.ajax({
	       	url:  "flyer_editor.php",
		   	type: 'post',
		   	data: {
					template: flyer[param].id,
					users_flyer_id: $('#' + flyer[param].id +'_flyer_select option:selected').val()
		   	},
	        success: function(data) {
				var modal_editor_config = 
				{
					div: 	"modal_editor",
					title:  'Updating Flyer: ' + $('#' + flyer[param].id +'_flyer_select option:selected').html(),
					height: 565,
					width: 	550,
					text: 	data
				};						
				var modal_button_config = {};
				var m = new ModalDialog(modal_editor_config);				
				m.set_button(modal_button_config);
				m.open();
	       }
		});			
		return false;
	};
	
	function request_flyer_remove()
	{
		$.ajax({
	      	url:  "flyer_remove.php",
		   	type: 'post',
		   	data: {
					template: flyer[param].id,
					users_flyer_id: $('#' +  flyer[param].id +'_flyer_select option:selected').val(),
					is_purge: 'false'
		   	},
	        success: function(data) {
					_flyer = data;
					_flyer['type'] = flyer[param].id;		
					$('#ltitle').html(_flyer['title']);	
					
					html =  "<p><span class='ui-icon ui-icon-alert'></span>"; 
					html += "Once committed, this flyer cannot be recovered.</p>";
					html += "<b>Remove? </b>";
					html += "<br>";
					
					var modal_remove_config = 
					{
						div: 	"modal_remove",
						title:  "Remove Flyer -> " + _flyer['title'],
						height: 200,
						width: 	600,
						text: 	html
					};				
	
					var modal_button_config = {
												Delete: function() {
												if (remove_flyer(_flyer) == true){					
													$( this ).dialog( "close" );
													Flyer.prototype.toggle_actions(manager_div_list, 'off', 0);
													$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Flyer removal was a success!</label>");										
														$.getScript('js/menu.js', function(){
															var menu = new Menu({param: '1'});
															menu.get_menu_page('1');
														});
													};
												},
												Cancel: function() {
													Flyer.prototype.toggle_actions(manager_div_list, 'off', 0);
													$( this ).dialog( "close" );	
												}					
					};
					
					var m = new ModalDialog(modal_remove_config);
					m.set_button(modal_button_config);
					m.open();
		    }
		});
	}
	
	function remove_flyer(_flyer)
	{
		// make an ajax call to render a form window screen
		$.ajax({
	       	url:  "flyer_remove.php",
		   	type: 'post',
		   	data: {
					template	: flyer[param].id,
					flyer		: _flyer,
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
	
	function toggle_flyer_description(val)
	{
		switch(val)
		{
			case 'on':
				$('#' + flyer[param].id).toggleClass('ui-helper-hidden', false);
			break;

			case 'off':
				$('#' + flyer[param].id).toggleClass('ui-helper-hidden', true) ; 
			break;
		}	
	}
	/* privledged*/
	this.load_template = function(param)
	{
		toggle_flyer_description('off');
		set_flyer(param);
		toggle_flyer_description('on');
		request_flyer_template();
 	}
	
	this.load_editor = function()
	{
		Flyer.prototype.toggle_actions(manager_div_list, 'off', 0);
		return request_flyer_edit();	
	}
	
	this.load_remover = function()
	{
		Flyer.prototype.toggle_actions(manager_div_list, 'off', 0);
		return request_flyer_remove();
	}
	
	this.edit_submit = function()
	{
		return edit_flyer();
	}
	
	this.submit = function()
	{
		return submit_flyer_template();	
	}
	
}
Flyer.prototype.enable_checkbox = function()
{
	$(function(){		
		$("#enable_qr").click(function(){
			( $(this).val() == 'off' ) ? $(this).val('on') : $(this).val('off');
		});					
	});
}
Flyer.prototype.enable_datepicker = function()
{
	$(function(){
		$("#event_date").datepicker();		
	});
}
Flyer.prototype.enable_contacttype = function()
{
	$(function(){
		$("#contact").change(function(){
			( $(this).val() != 0 ) ? Flyer.prototype.toggle('on','contact_info') : Flyer.prototype.toggle('off','contact_info');
		});
	});	
}
Flyer.prototype.toggle = function(val, div)
{
	switch(val)
	{
		case 'on':
			$('#' + div).toggleClass('ui-helper-hidden', false);
		break;
		
		case 'off':
			$('#' + div).toggleClass('ui-helper-hidden', true); 
		break;
	}
}
Flyer.prototype.toggle_actions = function(div_list, val, count)
{
	if (count > div_list.length) { return; }
	
	switch(val)
	{
		case 'on':
			$('#' + div_list[count]).toggleClass('ui-state-active',true);
		break;
		
		case 'off':
			$('#' + div_list[count]).toggleClass('ui-state-active',false);
		break;
	}
	
	/* recurse */
	this.toggle_actions(div_list, val, count + 1);
	
}
Flyer.prototype.preview_flyer = function(id)
{
	window.open('generate.php?flyerid=' + id,null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no'); 
	self.close();
}
Flyer.prototype.destroy = function()
{
	this = null;
}