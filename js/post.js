function Post()
{
	var that = this;
	var param;
	
	function set_param()
	{
		
		param = $("#add_button").val();
	
	}
	
	function update_location(state_id)
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
	
	function post_to_location()
	{
		var m = new ModalDialog({
			div: "modal_dialog",
			title: "No Board",
			height: "200",
			width: "600",
			text: "Please select a board to post to!"
		});

		if (param == 0) { m.open(); return false; }

		m.set_info({
			title: "No Flyer",
			text:  "Please select a flyer to post!",
			height: "200",
			width: "600"
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
					boardid: 		param,
					users_flyer_id: $("#flyers option:selected").val(),
					post_status_id: post_status_id
			},
			beforeSend: function(){
					$("#locations").mask("updating...");
			},
			success: function(data){
					$("#locations").unmask();
					refresh();
			},
			error:  function(data){
					$("#locations").unmask();
					$("#status_messages").html("<label style='color: #9BCC60;'>Messages: location update failed, please try again later</label>");
			}
		});
	}
	
	function remove_post(id)
	{
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
				refresh();
				$("#column").unmask();
	       },
		});
		return true;
	}
	
	function refresh()
	{
		console.log("refresh");
		// make an ajax call to render a form window screen
		$.ajax({
	       	url:  "post_refresh.php",
		   	type: 'post',
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
	
	function insert_table_entry(address)
	{		
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
	
	this.actions = function(val)
	{
		set_param();
		
		switch(val)
		{
			case 'update_location':
				update_location();
			break;
			
			case 'post_to_location':
				post_to_location();
			break;

		}
	}
	
	this.location_update = function(state_id)
	{
		update_location(state_id);
	}
	
	this.load_table_entry = function(address)
	{
		insert_table_entry(address);
	}
	
	this.post_remove = function(id)
	{
		remove_post(id);
	}
}
Post.prototype.maps_api = function(address)
{
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
}
Post.prototype.show_pps_info = function()
{
	$("#pps_modal").dialog({
				autoOpen: false,
				cache: false,
				modal: true,
				height: 350,
				width:  350,
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
		height: "150",
		width: "600",
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
			pps_html += "<tr><td><i>Slots:</td><td></i>"					   		   + pps.pps_slots   + "/4</td></tr>";		
		 	pps_html += "<tr><td colspan='2'><i>Paymenet Handling:</i><br><br>"        + pps.pps_payment + "</td></tr>";	 
		 	pps_html += "</table>";
		break;
		
	}
			 
	$('#pps_modal').html(pps_html);
		
	// open the dialog
	$( "#pps_modal" ).dialog( "open" );	
}