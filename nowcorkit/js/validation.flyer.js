$(document).ready(function() { 
    // validate signup form on keyup and submit 
    var text_validator = $("#text_form").validate({ 
        rules: { 
            title: 		 "required", 
            description: "required",
			location:    "required",
			type: {
					required: {
						depends: function(element) { return ( $("#contact option:selected").val() == 'none' ) ? false : true; }
					}
			}

        }, 
        messages: { 
            title: "Title is required", 
            description: "Description is required",
			location: "Location is required", 
			type: "Required field if contact type is not none"
        }, 
        // the errorPlacement has to take the table layout into account 
        errorPlacement: function(error, element) { 			
            if ( element.is(":radio") ) 
                error.appendTo( element.parent().next().next() ); 
            else if ( element.is(":checkbox") ) 
                error.appendTo ( element.next() ); 
            else 
                error.appendTo( element.parent().next() ); 
        },         // specifying a submitHandler prevents the default submit, good for the demo 
		submitHandler: function() { 
			console.log("submitted");
			 SubmitFormByAjaxPost();
		}
    });

});