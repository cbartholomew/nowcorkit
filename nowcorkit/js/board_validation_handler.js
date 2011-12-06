/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
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
			SubmitBoardByAjaxPost();
		}
    });


});