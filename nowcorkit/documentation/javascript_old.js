/*
This file is used to hold all the javascript code, which is not being used.
*/


/*
 * Activate Board Version of flyer management that allows a button set to be created
 */
function ActivateBoardSelectableContent(id)
{
	$(function() {		
		// render button sets
		$('#flyer_radio').buttonset();		
	});
	// flyer menu click listeners
	$('#flyer_preview').click(function() {
		if ($('#flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
		window.open('generate.php?flyerid=' + $('#flyer_select option:selected').val(),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no');
	});	
	$('#flyer_approve').click(function() {
			if ($('#flyer_select option:selected').val() == '0') { 
					$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
					return false;
			}
			ApprovePost(($('#flyer_select option:selected').attr('id')), true);
	});
	$('#flyer_remove').click(function() {
		if ($('#flyer_select option:selected').val() == '0') { 
				$('#status_messages').html("<label style='color: #9BCC60;'>Messages: Please select a flyer first!</label>"); 
				return false;
		}
			ApprovePost(($('#flyer_select option:selected').attr('id')), false);
	});
	
}