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
			UpdateBoardByAjaxPost($('#id').val(), 'general');
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
			UpdateBoardByAjaxPost($('#id').val(), 'permission');
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
			interval:{
				required: {
					depends: function(element) { return ( $("#shuffle").val() == 'off' ) ? false : true; }
				},
				max: 60,
				min: 5
			},
			cashamount: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == 'none' ) ? false : true; }
					},
					number: true
			},
			flyerdays: {
					required: {
						depends: function(element) { return ( $("#postpayment option:selected").val() == 'none' ) ? false : true; }
					},
					min: 1,
					max: 365
			}
        }, 
        messages: { 
			flyerexpire: {
				required: "Must have a valid expire date on flyers",
				digits: "Expire Days should only contain numbers",
				max: "Must have a range from 1 to 365 days",
				min: "Must have a range from 1 to 365 days"
				
			},
			interval: {
				required: "The interval is required if shuffle enabled",
				max: "Must have a range from 5-60 seconds",
				min: "Must have a range from 5-60 seconds"
			},
			cashamount: {
				required: "The cash amount is required if PPS is not none",
				number: "The value must be a currency value" 
			},
			flyerdays: {
				required: "The flyer day amount is required if PPS is not none",
				min: "Must have a range from 1 to 365 days",
				max: "Must have a range from 1 to 365 days"
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
			UpdateBoardByAjaxPost($('#id').val(), 'posting');
		}
    });
});