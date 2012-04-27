function Image(config) {
		this.id 	 =      config.id;
		this.cork_id =		config.cork_id;
		this.type    = 		config.type;
		this.size 	 = 		config.size;
		this.name 	 =		config.name;
		this.location =   	config.location;
		
		this.output = new Array();
		
}

Image.prototype.init = function() {
		if(this.name != "") { this.name = this.name.replace(' ', '_')};
}

Image.prototype.set_properties = function(config) {
	
	this.id 		=   config.id;
	this.cork_id	=	config.cork_id;
	this.type		= 	config.type;
	this.size		= 	config.size;
	this.name		= 	config.name;
	this.location	=   config.location
	
	this.init();

}

Image.prototype.create_output = function(){	
	this.output = {
		id : 			this.id,
		cork_id : 		this.cork_id,
		type :		 	this.type,
		size :		 	this.size,
		name :		 	this.name,
		location :	    this.location
	}
	
	return this.output;
}
