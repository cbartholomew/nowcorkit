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
							depends: function(element) { return ( $("#contact option:selected").val() == '0' ) ? false : true }
				}
			},
			contact_name: {
   				rangelength: [0,50]
   			}
        }, 
        messages: { 
            title: 
			{
				required: "*",
				rangelength: "Character limit: 50"
			}, 
            description:{
				required: "*",
				rangelength: "Character limit: 300"
			},
			location: 
			{
				required: "*",
				rangelength: "Character limit: 50"
			}, 
			contact_info: 
			{
				required: "*, Contact Type Not none"
			},
			contact_name: {
	   			rangelength: "Character limit: 50"
	   		}
        }, 
        // the errorPlacement has to take the table layout into account 
        errorPlacement: function(error, element) 
		{ 			
            if (element.is(":radio")) 
                error.appendTo(element.parent().next().next()); 
            else if ( element.is(":checkbox") ) 
                error.appendTo ( element.next() ); 
            else 
                error.appendTo( element.parent().next() ); 
        },       
		submitHandler: function() 
		{ 
			var f = new Flyer({param:'1'});
			f.submit();
		}
    });
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
   				required: "*",
   				rangelength: "Character limit: 50"
   			}, 
   	            description:{
   				required: "*",
   				rangelength: "Character limit: 300"
   			},
   			location: {
   				required: "*",
   				rangelength: "Character limit: 50"
   			}, 
   			contact_info: "*, Contact Type Not none",
   			contact_name:{
   				rangelength: "Character limit: 50"
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
   				if ($('#fileselect').val() != "" || $('#fileselect').attr("uploaded") != "")
   				{
   					var f = new Flyer({param:'2'});
					f.submit();
   				}else{
   					$("#messages").html("<label style='color: #9BCC60;'>Image must be accompanied with this flyer type</label>");
   				}
   		}
   	    });
   	    var upload_image_validator = $("#image_form").validate({ 
   		rules: { 
   	            title: 		 {
   				required: true,
   				rangelength: [1,50]
   			}
   	        }, 
   	        messages: { 
   	            title: {
   				required: "*",
   				rangelength: "Character limit: 50"
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
   				if ($('#fileselect').val() != "" || $('#fileselect').attr("uploaded") != "")
   				{
   					var f = new Flyer({param:'3'});
					f.submit();
   				}else{
   					$("#messages").html("<label style='color: #9BCC60;'>Image must be accompanied with this flyer type</label>");
   				}
   		}
   	    });
});