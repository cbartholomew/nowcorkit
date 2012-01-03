<?
/***********************************************************************
 * board_constructor.php
 * Author		   : Christopher Bartholomew
 * Last Updated    : 12/8/2011
 * Purpose		   :  Based on an ajax get request parameter, this will render 
 * the relevant html code to build a specific board
 **********************************************************************/

require_once('includes/common.php');

// based on the query string, obtain the property. 
// Although the request is registered as POST, the variable will be in $_GET
$template 	  = $_GET["template"];
$board_id 	  = $_GET["board_id"];
$filter_value = $_GET["filter_value"];

// based on the property, we'll load that specific form.
switch($template)
{
	case "general":
		build_general_form($board_id);
		break;
	case "permission":
		build_permission_form($board_id);	
		break;
	case "posting":
		build_posting_form($board_id);
		break;	
	case "post":
		build_post_form($board_id);
		break;
	case "create":
		build_new_form();
		break;
	case "render_posts":
		render_posts_table($board_id, $filter_value);
		break;	
}
/* build_general_form($board_id)
 *
 * The general tab
 */
function build_general_form($board_id)
{
	
	// create the board object
	$board = new Board(null);
	// based on the board id, build a board object
	$board = get_specific_board($board_id);
	
	echo "<form id='general' action='' method='POST'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
	echo "<tbody>";
		
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input id='id' type='hidden' name='id' value='" . $board->id ."' /></td>";
	echo "<td></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='title'>Title *</label></td>";
	echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $board->title . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='desc'>Description *</label></td>";
	echo "<td><input id='desc' type='desc' class='ui-widget-content template_text'  name='desc'  value='" . $board->description . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='address'>Address (optional)</label></td>";
	echo "<td><input id='address' type='desc' class='ui-widget-content template_text'  name='address'  value='" . $board->address . "'></td>";
	echo "<td></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='city'>City *</label></td>";
	echo "<td><input id='city' type='text' class='ui-widget-content template_text' name='city'   value='" . $board->city . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='state'>Choose State *</label></td>";
	echo "<td><select id='state' name='state' class='ui-widget-content'>";
	echo "<option value='0'>Please Choose...</option>";
	
	// load the state to id select box
	$state_array = GetStates();
	for ($i=0; $i<50;$i++)
	{
		$state = new State();
		$state = array_pop($state_array);
							
		if ($board->state_id != $state->id) { echo "<option value='" . $state->id . "'>" . $state->name . "</option>"; }
		else { echo "<option value='" . $state->id . "'  selected='selected'>" . $state->name . "</option>";}
	}								
	echo "</select></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td><label for='zipcode'>Zip Code *</label></td>";
	echo "<td><input id='zipcode' type='text' class='ui-widget-content template_text' name='zipcode' value='" . $board->zip . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>";
	echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo  	"<span class='ui-button-text'>Save</span>";
	echo "</button>";
	echo "</td>";
	echo "</tr>";
	echo "</tbody>";
	echo "</table>";
	echo "</form>";
	
	echo"<script src='js/board_edit_validation_hand.js' type='text/javascript' charset='utf-8'></script>";

}
/*  build_permission_form($board_id)
 *
 *  The permissions tab
 */
function build_permission_form($board_id)
{
	
	
	// create the board object
	$board = new Board(null);
	$board = get_specific_board($board_id);
	
	echo "<form id='permission' action='.php' method=''>";
	echo "<table class='ui-widget-content ui-corner-all'>";
	echo "<tbody>";
		
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input id='id' type='hidden' name='id' value='" . $board->id ."'/></td>";
	echo "<td></td>";
	echo "</tr>";

		switch($board->permission_type_id)
		{
			case 1:
				echo "<tr>";
				echo "<td><label for='approval'>By Approval</label></td>";			
				echo "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' checked='checked' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='private'>Private</label></td>";
				echo "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='public'>Public</label></td>";
				echo "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";			
			break;
			
			case 2:
				echo "<tr>";
				echo "<td><label for='approval'>By Approval</label></td>";			
				echo "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='private'>Private</label></td>";
				echo "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions' checked='checked'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='public'>Public</label></td>";
				echo "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";			
			break;
			
			case 3:
				echo "<tr>";
				echo "<td><label for='approval'>By Approval</label></td>";			
				echo "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='private'>Private</label></td>";
				echo "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><label for='public'>Public</label></td>";
				echo "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions' checked='checked'></td>";
				echo "<td><label id='status'></label></td>";
				echo "</tr>";
			break;
			
		}
		
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>";
	echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo "<span class='ui-button-text'>Save</span>";
	echo "</button>";
	echo "</td>";
	echo "</tr>";
		
	echo "</tbody>";
	echo "</table>";
	echo "</form>";
	
	echo"<script src='js/board_edit_validation_hand.js' type='text/javascript' charset='utf-8'></script>";

}
/* build_posting_form($board_id)
 * 
 * The posting tab
 */
function build_posting_form($board_id)
{
	
	// create the board object
	$board = new Board(null);
	$board = get_specific_board($board_id);
	
	
	echo "<form id='posting' action='posting_post.php' method='POST'>";
	echo "<table class='ui-widget-content ui-corner-all'>";
	echo "<tbody>";
	
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input id='id' type='hidden' name='id' value='" . $board->id ."'/></td>";
	echo "<td></td>";
	echo "</tr>";
		
	echo "<tr>";
	echo "<td><label for='flyerexpire'>Flyer Expiration in Days</label></td>";
    echo "<td><input id='flyerexpire' type='text' class='ui-widget-content template_text' name='flyerexpire' style='text-align:right'value='" . $board->expiration_days ."'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
		
	if ($board->pps_id == 1)
	{
	echo "<tr>";
	echo "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
	echo "<td>";
	echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
	echo "<option value='1' selected='selected'>None</option>";
    echo "<option value='2'>By Donation</option>";
	echo "<option value='3'>By Payment</option>";
	echo "</select>";
	echo "</td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td><label for='cashamount' id='label_cashamount' class='ui-helper-hidden'><i>For this Cash Amount</i></label></td>";
	echo "<td><input id='cashamount' type='text' class='ui-widget-content template_text ui-helper-hidden' name='cashamount'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td><label for='flyerdays' id='label_flyerdays' class='ui-helper-hidden'><i>Flyer won't be covered for this many days</i></label></td>";
	echo "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ui-helper-hidden' name='flyerdays'></td>";
	echo "<td><label id='status'></label></td>";
    echo "</tr>";
	}
	else
	{
	echo "<tr>";
	echo "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
	echo "<td>";
	echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
					
	switch($board->pps_id)
	{
		case "1":
		echo "<option value='1' selected='selected'>None</option>";
	    echo "<option value='2'>By Donation</option>";
		echo "<option value='3'>By Payment</option>";
		break;
					
		case "2":
		echo "<option value='1'>None</option>";
	    echo "<option value='2'selected='selected'>By Donation</option>";
		echo "<option value='3'>By Payment</option>";
		break;
					
		case "3":
		echo "<option value='1'>None</option>";
	    echo "<option value='2'>By Donation</option>";
		echo "<option value='3' selected='selected'>By Payment</option>";
		break;
	}
		
	echo "</select>";
	echo "</td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td><label for='pps_slots' id='label_cashamount' class=''><i>PPS Slots</i></label></td>";
	echo "<td><input id='pps_slots' type='text' disabled='true' class='ui-widget-content ui-state-disable template_text ' name='pps_slots' value='" . $board->pps_count . "/" . MAX_FLYERS . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td><label for='cashamount' id='label_cashamount' class=''><i>For this Cash Amount</i></label></td>";
	echo "<td><input id='cashamount' type='text' class='ui-widget-content template_text ' name='cashamount' value='" . $board->pps_cashamount . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td><label for='flyerdays' id='label_flyerdays' class=''><i>Flyer won't be covered for this many days</i></label></td>";
	echo "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ' name='flyerdays' value='" . $board->pps_flyerdays . "'></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
				
	echo "<tr>";
	echo "<td><label for='pay_handle' id='label_pay_handle' class=''><i>Describe Payment Handling: (paypal, at location, etc)</i></label></td>";
	echo "<td><textarea id='pay_handle' class='ui-widget-content template_text ' name='pay_handle' value='' rows='5' cols='5'>" . $board->pps_payment . "</textarea></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";

	}
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>";
		echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
		echo  	"<span class='ui-button-text'>Save</span>";
		echo "</button>";
		echo "</td>";
		echo "</tr>";
		echo "</tbody>";
		echo "</table>";
		echo "</form>";
	echo "<script>function toggleShuffleCheckBox(){ if ($('#shuffle').val() == 'off'){ $('#shuffle').val('on');} else { $('#shuffle').val('off'); } }</script>";
	echo"<script src='js/board_edit_validation_hand.js' type='text/javascript' charset='utf-8'></script>";

}
/* build_post_form($board_id)
 *
 * Post tab, used to display who has posted to you.
 */
function build_post_form($board_id)
{
	echo "<script src='js/helper.js' type='text/javascript' charset='utf-8'></script>";
	echo "<script src='js/date.js' type='text/javascript' charset='utf-8'></script>";
	echo "<link rel='stylesheet' href='css/main.css' type='text/css' media='screen' title='no title' charset='utf-8'>";
	echo "<input type='hidden' id='board_id' value='" . $board_id . "'/>";
	echo "<form id='filters' method='' action=''>";
	echo "<legend style='color:#FFF'>Filter Posts</legend>";
	echo "<fieldset class='ui-widget-content ui-corner-all'>";
	echo "<table class='ui-widget'>";
	echo "<tr>";
	echo "<td><label for='all'>All</label></td>";
	echo "<td><input id='all' type='radio' name='filter' onclick='UpdatePostFilterByAjaxPost(this.value);' checked='true' value='0'/></td>";
	echo "<td><label for='pending'>Pending</label></td>";
	echo "<td><input id='pending' type='radio' name='filter' onclick='UpdatePostFilterByAjaxPost(this.value);' value='2'/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><label for='posted'>Posted</label></td>";
	echo "<td><input id='posted' type='radio' name='filter' onclick='UpdatePostFilterByAjaxPost(this.value);' value='1'/></td>";
	echo "<td><label for='pps_posted'>PPS Posted</label></td>";
	echo "<td><input id='pps_posted' type='radio' name='filter' onclick='UpdatePostFilterByAjaxPost(this.value);' value='4'/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><label for='notapproved'>Not Approved</label></td>";
	echo "<td><input id='notapproved' type='radio' name='filter' onclick='UpdatePostFilterByAjaxPost(this.value);' value='3'/></td>";
	echo "</tr>";
	echo "</table>";
	echo "</fieldset>";
	echo "</form>";
	echo "<br>";	
	echo "<div id='post_content'>";

	// recursive function to render the posts in the table
	render_posts_table($board_id,0);
	
	echo "</div>";
}

/*
 * render_posts_table($board_id,$filter_value)
 * I render the posts depending on the post value
 */

function render_posts_table($board_id, $filter_value)
{
	echo "<table class='ui-widget ui-corner-all' style='border-spacing:0;'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>ID</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Title</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Status</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Expires</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Preview</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Remove</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Approve</th>";
	echo "<th class='ui-widget-content ui-widget-header table_data'>Begin PPS</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody class='ui-widget-content'>";
	
	// load the flyers to id select box
	$posts = get_all_posts_by_board_id($board_id);
	
	// build the table rows based on the filter id
	recurse_table_fields($posts,$filter_value);
	
	echo "</tbody>";
	echo "</table>";
	echo "</form>";

}

/* recurse_table_fields($posts, $filter_value)
 *
 * renders the table fields
 */
function recurse_table_fields($posts,$filter_value)
{
// return if there is nothing left in the array
if (count($posts) == 0) { return; }

// pop post off array
$post = array_pop($posts);

if ($post->flyer->post_status_id == $filter_value || $filter_value == 0)
{
echo "<tr>";
echo "<td class='ui-widget-content table_data'>" . $post->flyer->board_post_id    . "</td>";
echo "<td class='ui-widget-content table_data'>" . $post->flyer->title 		   . "</td>";
echo "<td class='ui-widget-content table_data'>" . $post->flyer->post_status_desc . "</td>";
echo "<td class='ui-widget-content table_data'>" . $post->flyer->post_expiration  . "</td>";
echo "<td class='ui-widget-content table_data'><center><button type='button' name='" . $post->flyer->users_flyers_id . "' id='preview_" . $post->flyer->board_post_id  . "'>Preview</button></center></td>";
echo "<td class='ui-widget-content table_data'><center><button type='button' id='remove_"  . $post->flyer->board_post_id . "'>Remove</button></center></td>";
echo "<td class='ui-widget-content table_data'><center><button type='button' id='approve_" . $post->flyer->board_post_id . "'>Approve</button></center></td>";
echo "<td class='ui-widget-content table_data'><center><button type='button' flyerdays='"  . $post->flyer->post_flyerdays ."' expire='". $post->flyer->post_expiration  ."' id='pps_" . $post->flyer->board_post_id . "'>Enable PPS</button></center></td>";
echo "</tr>";
echo "<script>RenderPostActionButtons(" . $post->flyer->board_post_id . ");</script>";
}

	
// unset post since we don't need any more
unset($post);
	
// continue with the html write
recurse_table_fields($posts,$filter_value);
}


/* build_new_form()
 *
 * This is a combonation of the above that is returned to a single modal window
 */
function build_new_form()
{
		echo "<form id='new_board' action='' method=''>";	
		echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";
			
		echo "<tr>";
		echo "<td></td>";
		echo "<td><label><b>General</b></label></td>";
		echo "<td></td>";
		echo "</tr>";
			
		echo "<tr>";
		echo "<td><label for='title'>Title *</label></td>";
		echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='desc'>Description *</label></td>";
		echo "<td><input id='desc' type='desc' class='ui-widget-content template_text' name='desc'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='address'>Address (optional)</label></td>";
		echo "<td><input id='address' type='text' class='ui-widget-content template_text' name='address'></td>";
		echo "<td></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='city'>City *</label></td>";
		echo "<td><input id='city' type='text' class='ui-widget-content template_text' name='city'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='state'>Choose State *</label></td>";
		echo "<td><select id='state' name='state' class='ui-widget-content'>";
		echo "<option value='0' selected='selected'>Please Choose...</option>";
		// load the state to id select box
		$state_array = GetStates();
		for ($i=0; $i<50;$i++)
		{
			$state = new State();
			$state = array_pop($state_array);
			echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
		}								
		echo "</select></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='zipcode'>Zip Code *</label></td>";
		echo "<td><input id='zipcode' type='text' class='ui-widget-content template_text' name='zipcode'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td></td>";
		echo "<td><label><b>Permissions</b></label></td>";
		echo "<td></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='approval'>By Approval</label></td>";	
		echo "<td><input id='approval' type='radio' checked='true' value='1' class='ui-widget-content template_text' name='permissions'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='private'>Private</label></td>";
		echo "<td><input id='private' type='radio' class='ui-widget-content template_text' value='2' name='permissions'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='public'>Public</label></td>";
		echo "<td><input id='public' type='radio' class='ui-widget-content template_text' value='3' name='permissions'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td></td>";
		echo "<td><label><b>Posting</b></label></td>";
		echo "<td></td>";
		echo "</tr>";
				
		echo "<tr>";
		echo "<td><label for='flyerexpire'>Flyer Expiration in Days</label></td>";
		echo "<td><input id='flyerexpire' type='text' class='ui-widget-content template_text' name='flyerexpire' style='text-align:right'value=30></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
		echo "<td>";
		echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
		echo "<option value='1' selected='selected'>None</option>";
	    echo "<option value='2'>By Donation</option>";
		echo "<option value='3'>By Payment</option>";
		echo "</select>";
		echo "</td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='cashamount' id='label_cashamount' class='ui-helper-hidden'><i>For this Cash Amount</i></label></td>";
		echo "<td><input id='cashamount' type='text' class='ui-widget-content template_text ui-helper-hidden' name='cashamount'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td><label for='flyerdays' id='label_flyerdays' class='ui-helper-hidden'><i>Flyer won't be covered for this many days</i></label></td>";
		echo "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ui-helper-hidden' name='flyerdays'></td>";
		echo "<td><label id='status'></label></td>";
		echo "</tr>";
			
	echo "<tr>";
	echo "<td><label for='pay_handle' id='label_pay_handle' class='ui-helper-hidden'><i>Describe Payment Handling: (paypal, at location, etc)</i></label></td>";
	echo "<td><textarea id='pay_handle' class='ui-widget-content template_text ui-helper-hidden' name='pay_handle' value='' rows='5' cols='5'></textarea></td>";
	echo "<td><label id='status'></label></td>";
	echo "</tr>";
			
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>";
	echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo "<span class='ui-button-text'>Create</span>";
	echo "</button>";
	echo "</td>";
	echo "</tr>";
	echo "</tbody>";
	echo "</table>";
	echo "</form>";
		
	echo "<script>function toggleShuffleCheckBox(){ if ($('#shuffle').val() == 'off'){ $('#shuffle').val('on');} else { $('#shuffle').val('off'); } }</script>";
	echo "<script src='js/board_validation_handler.js' type='text/javascript' charset='utf-8'></script>";

}


?>