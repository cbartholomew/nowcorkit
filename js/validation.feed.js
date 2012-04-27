/***********************************************************************
 * validation_feed.js
 * Author		  : Christopher Bartholomew
 * Last Updated   : 12/08/2011
 * Purpose		  : The fileds, which are necessary in order to create a new board
 **********************************************************************/

$(document).ready(function() { 
    // validate signup form on keyup and submit 
    var validator = $("#general").validate({ 
        rules: { 
            title: 		 "required", 
            description: "required"
        }, 
        messages: { 
            title: "Title is required", 
            description: "Description is Required"
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
           
        }, 
        // set this class to error-labels to indicate valid fields 
        success: function(label) { 
            // set   as text for IE 
            label.html(" ").addClass("checked"); 
        } 
    });

});