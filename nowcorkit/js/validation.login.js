$(document).ready(function() { 
    // validate signup form on keyup and submit 
    var validator = $("#signupform").validate({ 
        rules: 
		{ 
            firstname: 
			{	
					required: true,
					maxlength: 50				
			}, 
            lastname: 
			{
					required: true,
				 	maxlength: 50
			}, 
            email: 
			{ 
                	required: true, 
                	email: 	  true,
					maxlength: 	  100, 
                	remote: {
							url: "#!/emails.php", 
							type: "post",
							data: {
									email: function() { 
										return $("#email").val();
									}
							}
					}
            },
            password: 
			{ 
                required: true, 
                minlength: 5, 
				maxlength: 255
            }, 
            password_confirm: { 
                required: true, 
                minlength: 5, 
				maxlength: 255,
                equalTo: "#password" 
            },
			state:
			{
				required: true,
				min: 1
			}
        }, 
        messages: 
		{ 
            firstname: 
			{ 
				required: "Please enter your first name.",
				maxlength: jQuery.format("Can not enter more than {0} characters")
			}, 
            lastname: 
			{
				required: "Enter your lastname",
				maxlength: jQuery.format("Can not enter more than {0} characters")
			}, 
            email: 
			{ 
                required: "Please enter a valid email address, youremail@domain.com", 
                minlength: jQuery.format("Enter at least {0} characters"), 
				maxlength: jQuery.format("Can not enter more than {0} characters"),
                remote: jQuery.format("{0} is already in use") 
            },
            password: 
			{ 
                required: "Please provide a password that is greater than 5 characters long", 
                minlength: jQuery.format("Enter at least {0} characters") ,
			    maxlength: jQuery.format("Can not enter more than {0} characters")
            }, 
            password_confirm: { 
                required: "Please confirm your password", 
                minlength: jQuery.format("Enter at least {0} characters"), 
				maxlength: jQuery.format("Can not enter more than {0} characters"),
                equalTo: "Enter the same password as above" 
            }, 
 		    state: { 
                required: "Your State is required", 
                min: jQuery.format("Choose from list")
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
        // specifying a submitHandler prevents the default submit, good for the demo 
        submitHandler: function() { 
            console.log("submit?");
        }, 
        // set this class to error-labels to indicate valid fields 
        success: function(label) { 
            // set   as text for IE 
            label.html(" ").addClass("checked"); 
        } 

	    });
	
    }); 
     