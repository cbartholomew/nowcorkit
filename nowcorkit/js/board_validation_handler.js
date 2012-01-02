/***********************************************************************
 * Board_Validation Handler
 * Author		  : Christopher Bartholomew
 * Last Updated  : 12/08/2011 
 * Purpose		 : When a board is being created, based on the form ID - 
 * this is the method, client side validation, that i'm using to validate the user.
 * once all validation has passed below, this file will override the submit handler
 * thus, allowing me to easily call my own ajax helper
 **********************************************************************/


$(document).ready(function() { 
    /*
	 * Builds Validation options for text forms
	 */
    var new_board_validator = $("#new_board").validate({ 
        rules: { 
            title: 		 {
				required: true,
				rangelength: [1,50]
			}, 
            desc: {
				required: true,
				rangelength: [1,200]
		
			},
			city:  {
				required: true,
				rangelength: [1, 50]
			},
			state: {
					required: true, 
					min: 1
			},
			zipcode: {
				required: true,
				rangelength: [1,10],
				digits: true
			},
			flyerexpire: 		 {
				required: true,
				digits: true,
				min: 1,
				max: 365
			},
			cashamount: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == '1' ) ? false : true; }
					},
					number: true,
					min: 1
			},
			flyerdays: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == '1' ) ? false : true; }
					},
					min: 1,
					max: 365
			},
			pay_handle: {
				required: {
					depends: function(element) { return ( $("#postpayment option:selected").val() == '1' ) ? false : true; }
				},
				rangelength: [1,255]
			}
			
        }, 
        messages: { 
            title: {
				required: "Required",
				rangelength: "Maximum character limit: 50"
			}, 
            desc:{
				required: "Required",
				rangelength: "Maximum character limit: 200"
			},
			city: {
				required: "Required",
				rangelength: "Maximum character limit: 50"
			}, 
			state: {
				required: "Required",
				min: "Required"
 			},
			zipcode: {
				required: "Required",
				rangelength: "Maximum character limit: 10",
				digits: "A valid zip code is numbers only"
			},
			flyerexpire: {
				required: "Must have a valid expire date on flyers",
				digits: "Expire Days should only contain numbers",
				max: "Must have a range from 1 to 365 days",
				min: "Must have a range from 1 to 365 days"
				
			},
			cashamount: {
				required: "Required, PPS Enabled",
				number: "The value must be a currency value",
				min: "Must be a positive number."  
			},
			flyerdays: {
				required: "Required, PPS Enabled",
				min: "Must have a range from 1 to 365 days",
				max: "Must have a range from 1 to 365 days"
			},
			pay_handle: {
				required: "Required, PPS Enabled",
				rangelength: "Maximum character limit: 255"
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
			if ($("#flyerexpire").val() < $("#flyerdays").val()) { alert("Flyer PPS day amount must be less than the Flyer expiration day amount!");}
 			else {SubmitBoardByAjaxPost();}			
		}
    });


});