function ModalDialog(config)
{

	this.div 	= config.div,
	this.title 	= config.title,
	this.height = config.height,
	this.width 	= config.width,
	this.text   = config.text,
	
	this.buttons =	{ ok: function() { $( this ).dialog( "close" ); } };
	
	this.init();
}

ModalDialog.prototype.init = function()
{
	this.modal = $( "#" + this.div).dialog({
					modal:    true,
					cache:    false,
					autoOpen: false,
					height: this.height,
					width:  this.width,
					title:  this.title,
					resizable: false,
					draggable: false,
					buttons: this.buttons
				});
	
	$("#" + this.div).html(this.text);
}

ModalDialog.prototype.set_info = function(config){
	this.title = config.title;
	this.text  = config.text;
	this.height = config.height,
	this.width 	= config.width,
	
	this.init();
}
ModalDialog.prototype.set_button = function(config){
	this.buttons = config;
	this.init();
}

ModalDialog.prototype.open = function(){
	this.modal.dialog("open");
}

ModalDialog.prototype.close = function(){
	this.modal.dialog("close");
}