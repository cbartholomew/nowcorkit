function ModalDialog(config)
{

	this.div 	= config.div,
	this.title 	= config.title,
	this.height = config.height,
	this.width 	= config.width,
	this.text   = config.text	
	
	this.init();
}

ModalDialog.prototype.init = function()
{
	this.modal = $( "#" + this.div).dialog({
					modal: true,
					autoOpen: false,
					title: this.title,
					resizable: false,
					draggable: false,
					buttons: {
						ok: function() {
							$( this ).dialog( "close" );
						}
					}
				});
	
	$("#" + this.div).html(this.text);
}

ModalDialog.prototype.setInfo = function(config){
	this.title = config.title;
	this.text  = config.text;
	
	this.init();
}

ModalDialog.prototype.open = function(){
	this.modal.dialog("open");
}

ModalDialog.prototype.close = function(){
	this.modal.dialog("close");
}