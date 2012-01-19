function Menu(config)
{
		var page = config.page	
				
		function request_page()
		{	
			$.ajax({
			       url: page + ".php",
				   cache: false,
					beforeSend: function(){
						$("#content").mask("loading...");
				   },
			       success: function(data) {
						$("#content").unmask();
						clean();
			 	   		$("#content").html(data);			
			       }
			});	
			return false;
		}
				
		this.get_menu_page = function()
		{
			return request_page();	
		};
}
Menu.prototype.clean = function()
{
	$('#content').html("");
	$('#form_content').html("");
}
