function Effects(config) {
	var divs = [];
	divs = config.divs;
		
	// run the currently selected effect for each div in config
	function runEffect() {
		// run the effect
		for (var i=0;i<divs.length;i++)
			$( "#" + divs[i] ).removeAttr( "style" ).hide().fadeIn("slow");  
	};  
	
	runEffect();
}