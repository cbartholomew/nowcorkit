/***********************************************************************
 * XXX.js
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

$(document).ready(function() { 
    /*
	 * Builds Validation options for text forms
	 */
    var text_validator = $("#text_form").validate({ 
        rules: { 
            title: 		 {
				required: true,
				rangelength: [1,50]
			}, 
            description: {
				required: true,
				rangelength: [1,300]
		
			},
			location:  {
				required: true,
				rangelength: [1, 50]
			},
			contact_info: {
					required: {
						depends: function(element) { return ( $("#contact option:selected").val() == '0' ) ? false : true; }
					}
			},
			contact_name: {
				rangelength: [0,50]
			}
        }, 
        messages: { 
            title: {
				required: "Title is required",
				rangelength: "Maximum character limit: 50"
			}, 
            description:{
				required: "Description is required",
				rangelength: "Maximum character limit: 300"
			},
			location: {
				required: "Location is required",
				rangelength: "Maximum character limit: 50"
			}, 
			contact_info: "Required field if contact type is not none",
			contact_name: {
				rangelength: "Maximum character limit: 50"
			}
        }, 
        // the errorPlacement has to take the table layout into account 
        errorPlacement: function(error, element) { 			
            if ( element.is(":radio") ) 
                error.appendTo( element.parent().next().next() ); 
            else if ( element.is(":checkbox") ) 
                error.appendTo ( element.next() ); 
            else 
                error.appendTo( element.parent().next() ); 
        },       
		submitHandler: function() { 					
			var f = new Flyer({param:'1'});
			f.edit_submit();
	
		}
    });


	/*
	 * Builds Validation options for text forms with Images
	 */
    var text_image_validator = $("#text_image_form").validate({ 
        rules: { 
            title: 		 {
				required: true,
				rangelength: [1,50]
			}, 
            description: {
				required: true,
				rangelength: [1,300]

			},
			location:  {
				required: true,
				rangelength: [1, 50]
			},
			contact_info: {
					required: {
						depends: function(element) { return ( $("#contact option:selected").val() == '0' ) ? false : true; }
					}
			},
			contact_name: {
				rangelength: [0,50]
			}

        }, 
        messages: { 
            title: {
				required: "Title is required",
				rangelength: "Maximum character limit: 50"
			}, 
            description:{
				required: "Description is required",
				rangelength: "Maximum character limit: 300"
			},
			location: {
				required: "Location is required",
				rangelength: "Maximum character limit: 50"
			}, 
			contact_info: "Required field if contact type is not none",
			contact_name:{
				rangelength: "Maximum character limit: 50"
			}
        }, 
        // the errorPlacement has to take the table layout into account 
        errorPlacement: function(error, element) { 			
            if ( element.is(":radio") ) 
                error.appendTo( element.parent().next().next() ); 
            else if ( element.is(":checkbox") ) 
                error.appendTo ( element.next() ); 
            else 
                error.appendTo( element.parent().next() ); 
        },       
		submitHandler: function() { 				
			var f = new Flyer({param:'2'});
			f.edit_submit();
		}
    });

	/*
	 * Builds Validation options for Image upload only
	 */
    var upload_image_validator = $("#image_form").validate({ 
		rules: { 
            title: 		 {
				required: true,
				rangelength: [1,50]
			}
        }, 
        messages: { 
            title: {
				required: "Title is required",
				rangelength: "Maximum character limit: 50"
			}
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
				var f = new Flyer({param:'3'});
				f.edit_submit();
		}
    });
	

});