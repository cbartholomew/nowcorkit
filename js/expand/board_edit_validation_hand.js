/***********************************************************************
 * Board_Edit_Validation_Handler.js
 * Author		  : Christopher Bartholomew
 * Last Updated  : 12/08/2011 
 * Purpose		 : When a board is being edited, based on the form ID - 
 * this is the method, client side validation, that i'm using to validate the user.
 * once all validation has passed below, this file will override the submit handler
 * thus, allowing me to easily call my own ajax helper
 **********************************************************************/

$(document).ready(function() { 
    /*
	 * Builds Validation options for General
	 */
    var general_board_validator = $("#general").validate({ 
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
			var b = new Board({param: $('#id').val(), page: 'general'});
			b.board_manager('update');
		}
    });
    /*
	 * Builds Validation options for Permissions
	 */
	var permission_board_validator = $("#permission").validate({ 
        rules: { 
        }, 
        messages: { 
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
			var b = new Board({param: $('#id').val(), page: 'permission'});
			b.board_manager('update');
		}
    });

    /*
	 * Builds Validation options for posting
	 */
	var posting_board_validator = $("#posting").validate({ 
        rules: { 
			flyerexpire: 		 {
				required: true,
				digits: true,
				min: 1,
				max: 365
			},	
			cashamount: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == 'none' ) ? false : true; }
					},
					min: 1,
					number: true
			},
			flyerdays: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == 'none' ) ? false : true; }
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
			flyerexpire: {
				required: "Must have a valid expire date on flyers",
				digits: "Expire Days should only contain numbers",
				max: "Must have a range from 1 to 365 days",
				min: "Must have a range from 1 to 365 days"
				
			},
			cashamount: {
				required: "The cash amount is required if PPS is not none",
				number: "The value must be a currency value",
				min:    "Must be a positive number" 
			},
			flyerdays: {
				required: "The flyer day amount is required if PPS is not none",
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
 			else 
			{ 
				var b = new Board({param: $('#id').val(), page: 'posting'}); 
				b.board_manager('update'); 
			}
	
		}
    });
});