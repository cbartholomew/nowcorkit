function Board(config)
{
	var param = config.param;
	var page  = config.page;
	var that  = this;
	
	var board_div_list = 
						 [
						  "cashamount", 
						  "label_cashamount", 
						  "flyerdays", 
						  "label_flyerdays",
						  "pay_handle",
						  "label_pay_handle"
						];
						
	var tabs_div_list = 
						[
						"tabs"
						];

	function set_board()
	{
		// left off here....put code here to decide what request to make, populate from there.
		// remove populate calls from ajax request below.
		param = $("#board_select").val();		
		return populate_tabs();
	};
	
	function set_create() 
	{
		param = "create";
		populate_create(); 
	}
	// problem with execution. expecting tabs - tabs needs ot be in form_content; however.
	function populate_tabs()
	{	
		$(function() {
			$( "#tabs" ).tabs({
				ajaxOptions: {
				type: 'get',
				data: {
					board_id: param
				},
				beforeSend: function()
				{
					$("#tabs").mask("loading...");
				},
				success: function(data){
					
					$("#postpayment").change(function(){
						var val = ($(this).val() > 1 ) ? 'on' : 'off';		
						that.toggle_features(board_div_list,val,0);
					});
					$("#tabs").unmask();					
					
				},
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			 }
			});
		});
		$("#bhead").html($("#board_select option:selected").html());	
		$('#middleContainer').toggleClass('ui-helper-hidden', false); 
		$('#tabs').toggleClass('ui-helper-hidden', false); 
		$('#tabs').tabs("option","selected",0);					
		//var mydivs = ["tabs"];
		//var fx = new Effects({divs: mydivs});
	};
	
	function populate_create()
	{
		$.ajax({
		       url: "board_constructor.php",
			   type: 'get',
			   data: {
					template: param
			   },
				beforeSend: function(){
					$("#form_content").mask("loading...");
			   },
		       success: function(data) {
					$("#form_content").unmask();
					$("#form_content").html(data);
					
			
					$("#postpayment").change(function(){
						var val = ($(this).val() > 1 ) ? 'on' : 'off';		
						that.toggle_features(board_div_list,val,0);
					});
		       }
		});	
		return false;		
	};
	
	function check_pps(id)
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
	};
	
	function review_pps(id)
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
								enable_pps(id);
								$( this ).dialog( "close" );
							},
							cancel: function() {
								$( this ).dialog( "close" );
							}
					}
		});	
		return false;
		
	};
	
	function enable_pps(id)
	{
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
				Board.prototype.update_post_filter(filter_id);
	       },
		});
		return false;
	};
	
	function approve(id)	
	{
		$.ajax({
	       	url:  "post_approve.php",
		   	type: 'post',
			cache: false,
		   	data: {
					id			: id,
					is_approve  : true
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
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been <i>approved</i> for this board</label>");				
				refresh_posts();
	       },
		});
		return true;
	};
	
	function not_approve(id)
	{
		$.ajax({
	       	url:  "post_approve.php",
		   	type: 'post',
			cache: false,
		   	data: {
					id			: id,
					is_approve  : false
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
				$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Post has been <i>approved</i> for this board</label>");				
				refresh_posts();
	       },
		});
		return true;
	};
	
	function refresh_posts()
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
	};
	
	function request_create()
	{
		$.ajax({
		       url: "board_creation.php",
			   type: "post",
			   cache: false,
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
					cashamount	   	: $("#cashamount").val(),
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
					//make this load the preferences screen
					$.getScript('js/menu.js', function(){
						var menu = new Menu({param: '3'});
						menu.get_menu_page('3');
					});
					
					$( "#modal_board_preferences" ).dialog( "close" );
					$('#new_board').unmask();
		       },
			   error:  function(data){
					$("#new_board").unmask();
					$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board creation failed, please try again later</label>");
			   }
		});	
		return false;
	};
	
	function request_update()
	{
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
		};
	
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
	};
	
	function request_remove()
	{
		var id = $('#board_select option:selected').val();	
		var title = $('#board_select option:selected').html();
				
		html =  "<p><span class='ui-icon ui-icon-alert'></span>"; 
		html += "Once committed, this board cannot be recovered.</p>";
		html += "<b>Remove? </b>";
		html += "<br>";
		
		var modal_remove_config = 
		{
			div: 	"modal_remove",
			title:  "Remove Board -> " + title,
			height: 200,
			width: 	600,
			text: 	html
		};
		
		var modal_button_config = {
									Delete: function() {
									if (remove_board(id) == true){					
										$( this ).dialog( "close" );
										$("#status_messages").html("<label style='color: #9BCC60;'>Messages: Board removal was a success!</label>");										
											$.getScript('js/menu.js', function(){
												var menu = new Menu({param: '3'});
												menu.get_menu_page('3');
											});
										};
									},
									Cancel: function() {
										$( this ).dialog( "close" );	
									}					
		};
						
		var m = new ModalDialog(modal_remove_config);
		m.set_button(modal_button_config);
		m.open();
	}
	
	function remove_board(id)
	{
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
				return false;
			},
	        success: function(data) {
				$("#modal_remove").unmask();
	        },
			completed: function(data) {
				$("#modal_remove").unmask();
			}
		});
		return true;
	};
	
	function request_board(id)
	{
		console.log(id);
		var board_id = (id == null) ? $('#board_select option:selected ').val() : id ;
		$.ajax({
			url: "corkboard.php",
			type: "POST",
			data:{
				board_id: board_id
			},
			success: function(data)
			{
				$("body").html(data);
			}
		});		
	};
		
	this.load_board = function()
	{
		set_board();	
	};
	
	this.load_create = function()
	{
		set_create();
	};
	
	this.toggle = function(val)
	{
		Board.prototype.toggle_features(board_div_list,val,0);
	};
	
	this.post_manager = function(val, id)
	{
		switch(val)
		{
			case 'approve':
				return approve(id);
			break;
			
			case 'not_approve':
				return not_approve(id);
			break;		
			
			case 'check_pps':
				return check_pps(id);
			break;
			
			case 'enable_pps':
				return review_pps(id);
			break;
				
		};
	};
	
	this.board_manager = function(val)
	{
		switch(val)
		{
			case 'create': 
				return request_create();
			break;
			
			case  'update':
				return request_update();
			break;
			
			case 'remove':
				return request_remove();
			break;
			
			case 'corkboard':
				return request_board(null);
			break;
		};
	};
	
	this.load_corkboard = function(id)
	{		
		return request_board(id);
	};

};


Board.prototype.toggle_features = function(div_list, val, count)
{
	if (count > div_list.length) { return; }
	
	switch(val)
	{
		case 'on':
			$('#' + div_list[count]).toggleClass('ui-helper-hidden',false);
		break;
		
		case 'off':
			$('#' + div_list[count]).toggleClass('ui-helper-hidden',true);
		break;
	};
	
	/* recurse */
	this.toggle_features(div_list, val, count + 1);
};

Board.prototype.update_post_filter = function(filter_type)
{
	$.ajax({
	       url: "board_constructor.php",
		   type: 'get',
		   data: {
				template	: "render_posts",
				board_id	: $("#board_id").val(),
				filter_value: filter_type
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
};