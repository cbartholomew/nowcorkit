<script src="js/board_edit_validation_hand.js" type="text/javascript" charset="utf-8"></script>

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
		$html = build_general_form($board_id);
	break;
	case "permission":
		$html = build_permission_form($board_id);	
	break;
	case "posting":
		$html = build_posting_form($board_id);
	break;	
	case "post":
		$html = build_post_form($board_id);
	break;
	case "create":
		$html = build_new_form();
	break;
	case "render_posts":
		$html = render_posts_table($board_id, $filter_value);
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

$html = "";
$html .=  "<form id='general' action='' method='POST'>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><input id='id' type='hidden' name='id' value='" . $board->id ."' /></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='title'>Title *</label></td>";
$html .=  "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . str_replace("'","&#39;",$board->title) . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='desc'>Description *</label></td>";
$html .=  "<td><input id='desc' type='desc' class='ui-widget-content template_text'  name='desc'  value='" . $board->description . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='address'>Address (optional)</label></td>";
$html .=  "<td><input id='address' type='desc' class='ui-widget-content template_text'  name='address'  value='" . str_replace("\\", "",$board->address) . "'></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='city'>City *</label></td>";
$html .=  "<td><input id='city' type='text' class='ui-widget-content template_text' name='city'   value='" . str_replace("\\", "",$board->city) . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='state'>Choose State *</label></td>";
$html .=  "<td><select id='state' name='state' class='ui-widget-content'>";
$html .=  "<option value='0'>Please Choose...</option>";

		// load the state to id select box
		$state_array = GetStates();
		for ($i=0; $i<50;$i++)
		{
		$state = new State();
		$state = array_pop($state_array);

		if ($board->state_id != $state->id) { $html .=  "<option value='" . $state->id . "'>" . $state->name . "</option>"; }
		else { $html .=  "<option value='" . $state->id . "'  selected='selected'>" . $state->name . "</option>";}
		}					
					
$html .=  "</select></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='zipcode'>Zip Code *</label></td>";
$html .=  "<td><input id='zipcode' type='text' class='ui-widget-content template_text' name='zipcode' value='" . str_replace("\\", "",$board->zip) . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=   	"<span class='ui-button-text'>Save</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";


return $html;
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

$html = "";

$html .=  "<form id='permission' action='.php' method=''>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><input id='id' type='hidden' name='id' value='" . $board->id ."'/></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
switch($board->permission_type_id)
{
		case 1:
			$html .=  "<tr>";
			$html .=  "<td><label for='approval'>By Approval</label></td>";			
			$html .=  "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' checked='checked' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='private'>Private</label></td>";
			$html .=  "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='public'>Public</label></td>";
			$html .=  "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";			
		break;

		case 2:
			$html .=  "<tr>";
			$html .=  "<td><label for='approval'>By Approval</label></td>";			
			$html .=  "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='private'>Private</label></td>";
			$html .=  "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions' checked='checked'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='public'>Public</label></td>";
			$html .=  "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";			
		break;

		case 3:
			$html .=  "<tr>";
			$html .=  "<td><label for='approval'>By Approval</label></td>";			
			$html .=  "<td><input id='approval' type='radio' value='1' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='private'>Private</label></td>";
			$html .=  "<td><input id='private' type='radio' value='2' class='ui-widget-content template_text' name='permissions'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
			$html .=  "<tr>";
			$html .=  "<td><label for='public'>Public</label></td>";
			$html .=  "<td><input id='public' type='radio' value='3' class='ui-widget-content template_text' name='permissions' checked='checked'></td>";
			$html .=  "<td><label id='status'></label></td>";
			$html .=  "</tr>";
		break;

}

$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=  "<span class='ui-button-text'>Save</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";

//$html .= "<script>initialize_tab_manager();</script>";
return $html;
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

$html = "";
$html .=  "<form id='posting' action='posting_post.php' method='POST'>";
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><input id='id' type='hidden' name='id' value='" . $board->id ."'/></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='flyerexpire'>Flyer Expiration in Days</label></td>";
$html .=  "<td><input id='flyerexpire' type='text' class='ui-widget-content template_text' name='flyerexpire' style='text-align:right'value='" . str_replace("\\", "",$board->expiration_days) ."'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";

if ($board->pps_id == 1)
{
	$html .=  "<tr>";
	$html .=  "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
	$html .=  "<td>";
	$html .=  "<select id='postpayment' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
	$html .=  "<option value='1' selected='selected'>None</option>";
	$html .=  "<option value='2'>By Donation</option>";
	$html .=  "<option value='3'>By Payment</option>";
	$html .=  "</select>";
	$html .=  "</td>";
	$html .=  "<td><label id='status'></label></td>";
	$html .=  "</tr>";
	$html .=  "<tr>";
	$html .=  "<td><label for='cashamount' id='label_cashamount' class='ui-helper-hidden'><i>For this Cash Amount</i></label></td>";
	$html .=  "<td><input id='cashamount' type='text' class='ui-widget-content template_text ui-helper-hidden' name='cashamount'></td>";
	$html .=  "<td><label id='status'></label></td>";
	$html .=  "</tr>";
	$html .=  "<tr>";
	$html .=  "<td><label for='flyerdays' id='label_flyerdays' class='ui-helper-hidden'><i>Flyer won't be covered for this many days</i></label></td>";
	$html .=  "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ui-helper-hidden' name='flyerdays'></td>";
	$html .=  "<td><label id='status'></label></td>";
	$html .=  "</tr>";
}
else
{
	$html .=  "<tr>";
	$html .=  "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
	$html .=  "<td>";
	$html .=  "<select id='postpayment' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";

switch($board->pps_id)
{
	case "1":
		$html .=  "<option value='1' selected='selected'>None</option>";
		$html .=  "<option value='2'>By Donation</option>";
		$html .=  "<option value='3'>By Payment</option>";
	break;

	case "2":
		$html .=  "<option value='1'>None</option>";
		$html .=  "<option value='2'selected='selected'>By Donation</option>";
		$html .=  "<option value='3'>By Payment</option>";
	break;

	case "3":
		$html .=  "<option value='1'>None</option>";
		$html .=  "<option value='2'>By Donation</option>";
		$html .=  "<option value='3' selected='selected'>By Payment</option>";
	break;
}

$html .=  "</select>";
$html .=  "</td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='pps_slots' id='label_cashamount' class=''><i>PPS Slots</i></label></td>";
$html .=  "<td><input id='pps_slots' type='text' disabled='true' class='ui-widget-content ui-state-disable template_text ' name='pps_slots' value='" . $board->pps_count . "/" . MAX_FLYERS . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='cashamount' id='label_cashamount' class=''><i>For this Cash Amount</i></label></td>";
$html .=  "<td><input id='cashamount' type='text' class='ui-widget-content template_text ' name='cashamount' value='" . $board->pps_cashamount . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='flyerdays' id='label_flyerdays' class=''><i>Flyer won't be covered for this many days</i></label></td>";
$html .=  "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ' name='flyerdays' value='" . $board->pps_flyerdays . "'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='pay_handle' id='label_pay_handle' class=''><i>Describe Payment Handling: (paypal, at location, etc)</i></label></td>";
$html .=  "<td><textarea id='pay_handle' class='ui-widget-content template_text ' name='pay_handle' value='' rows='5' cols='5'>" . $board->pps_payment . "</textarea></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";

}
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=   	"<span class='ui-button-text'>Save</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";


return $html;
}
/* build_post_form($board_id)
*
* Post tab, used to display who has posted to you.
*/
function build_post_form($board_id)
{
$html = "";
$html .=  "<script src='js/date.js' type='text/javascript' charset='utf-8'></script>";
$html .=  "<input type='hidden' id='board_id' value='" . $board_id . "'/>";
$html .=  "<form id='filters' method='' action=''>";
$html .=  "<legend style='color:#FFF'>Filter Posts</legend>";
$html .=  "<fieldset class='ui-widget-content ui-corner-all'>";
$html .=  "<table class='ui-widget'>";
$html .=  "<tr>";
$html .=  "<td><label for='all'>All</label></td>";
$html .=  "<td><input id='all' type='radio' name='filter' checked='true' value='0'/></td>";
$html .=  "<td><label for='pending'>Pending</label></td>";
$html .=  "<td><input id='pending' type='radio' name='filter' value='2'/></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='posted'>Posted</label></td>";
$html .=  "<td><input id='posted' type='radio' name='filter' value='1'/></td>";
$html .=  "<td><label for='pps_posted'>PPS Posted</label></td>";
$html .=  "<td><input id='pps_posted' type='radio' name='filter' value='4'/></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='notapproved'>Not Approved</label></td>";
$html .=  "<td><input id='notapproved' type='radio' name='filter' value='3'/></td>";
$html .=  "</tr>";
$html .=  "</table>";
$html .=  "</fieldset>";
$html .=  "</form>";
$html .=  "<br>";	
$html .=  "<div id='post_content'>";

// recursive function to render the posts in the table
$html = render_posts_table($board_id,0,$html);
$html .= "</div>";
$html .= "<script>initialize_tab_manager();</script>";
return $html;
}

/*
* render_posts_table($board_id,$filter_value)
* I render the posts depending on the post value
*/

function render_posts_table($board_id, $filter_value, $tempHtml)
{

$tempHtml .= "<table class='ui-widget ui-corner-all' style='border-spacing:0;'>";
$tempHtml .= "<thead>";
$tempHtml .= "<tr>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>ID</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Title</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Status</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Expires</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Preview</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Remove</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Approve</th>";
$tempHtml .= "<th class='ui-widget-content ui-widget-header table_data'>Begin PPS</th>";
$tempHtml .= "</tr>";
$tempHtml .= "</thead>";
$tempHtml .= "<tbody class='ui-widget-content'>";

// load the flyers to id select box
$posts = get_all_posts_by_board_id($board_id);

// build the table rows based on the filter id
$tempHtml = recurse_table_fields($posts,$filter_value,$tempHtml);

$tempHtml .=  "</tbody>";
$tempHtml .=  "</table>";
$tempHtml .=  "</form>";

return $tempHtml;

}

/* recurse_table_fields($posts, $filter_value)
*
* renders the table fields
*/
function recurse_table_fields($posts,$filter_value, $tempHtml)
{

// return if there is nothing left in the array
if (count($posts) == 0) { return $tempHtml; }

// pop post off array
$post = array_pop($posts);

if ($post->flyer->post_status_id == $filter_value || $filter_value == 0)
{

$tempHtml .=  "<tr>";
$tempHtml .=  "<td class='ui-widget-content table_data'>" . $post->flyer->board_post_id    . "</td>";
$tempHtml .=  "<td class='ui-widget-content table_data'>" . $post->flyer->title 		   . "</td>";
$tempHtml .=  "<td class='ui-widget-content table_data'>" . $post->flyer->post_status_desc . "</td>";
$tempHtml .=  "<td class='ui-widget-content table_data'>" . $post->flyer->post_expiration  . "</td>";
$tempHtml .=  "<td class='ui-widget-content table_data'><center><button type='button' name='" . $post->flyer->users_flyers_id . "' id='preview_" . $post->flyer->board_post_id  . "'>Preview</button></center></td>";
$tempHtml .=   "<td class='ui-widget-content table_data'><center><button type='button' id='remove_"  . $post->flyer->board_post_id . "'>Remove</button></center></td>";
$tempHtml .=   "<td class='ui-widget-content table_data'><center><button type='button' id='approve_" . $post->flyer->board_post_id . "'>Approve</button></center></td>";
$tempHtml .=   "<td class='ui-widget-content table_data'><center><button type='button' flyerdays='"  . $post->flyer->post_flyerdays ."' expire='". $post->flyer->post_expiration  ."' id='pps_" . $post->flyer->board_post_id . "'>Enable PPS</button></center></td>";
$tempHtml .=  "</tr>";
$tempHtml .=  "<script>render_action_buttons(" . $post->flyer->board_post_id . ");</script>";
}


// unset post since we don't need any more
unset($post);

// continue with the html write
return recurse_table_fields($posts,$filter_value, $tempHtml);

}


/* build_new_form()
*
* This is a combonation of the above that is returned to a single modal window
*/
function build_new_form()
{

$html = "";
$html .=  "<form id='new_board' action='' method=''>";	
$html .=  "<table class='ui-widget-content ui-corner-all'>";
$html .=  "<tbody>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><label><b>General</b></label></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='title'>Title *</label></td>";
$html .=  "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='desc'>Description *</label></td>";
$html .=  "<td><input id='desc' type='desc' class='ui-widget-content template_text' name='desc'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='address'>Address (optional)</label></td>";
$html .=  "<td><input id='address' type='text' class='ui-widget-content template_text' name='address'></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='city'>City *</label></td>";
$html .=  "<td><input id='city' type='text' class='ui-widget-content template_text' name='city'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='state'>Choose State *</label></td>";
$html .=  "<td><select id='state' name='state' class='ui-widget-content'>";
$html .=  "<option value='0' selected='selected'>Please Choose...</option>";
		// load the state to id select box
		$state_array = GetStates();
		for ($i=0; $i<50;$i++)
		{
		$state = new State();
		$state = array_pop($state_array);
		$html .=  "<option value='" . $state->id . "'>" . $state->name . "</option>";
		}								
$html .=  "</select></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='zipcode'>Zip Code *</label></td>";
$html .=  "<td><input id='zipcode' type='text' class='ui-widget-content template_text' name='zipcode'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><label><b>Permissions</b></label></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='approval'>By Approval</label></td>";	
$html .=  "<td><input id='approval' type='radio' checked='true' value='1' class='ui-widget-content template_text' name='permissions'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='private'>Private</label></td>";
$html .=  "<td><input id='private' type='radio' class='ui-widget-content template_text' value='2' name='permissions'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='public'>Public</label></td>";
$html .=  "<td><input id='public' type='radio' class='ui-widget-content template_text' value='3' name='permissions'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td><label><b>Posting</b></label></td>";
$html .=  "<td></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='flyerexpire'>Flyer Expiration in Days</label></td>";
$html .=  "<td><input id='flyerexpire' type='text' class='ui-widget-content template_text' name='flyerexpire' style='text-align:right'value=30></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
$html .=  "<td>";
$html .=  "<select id='postpayment' name='postpayment' class='ui-widget-content' style='color: rgb(155, 204, 96);'>";
$html .=  "<option value='1' selected='selected'>None</option>";
$html .=  "<option value='2'>By Donation</option>";
$html .=  "<option value='3'>By Payment</option>";
$html .=  "</select>";
$html .=  "</td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='cashamount' id='label_cashamount' class='ui-helper-hidden'><i>Cash Amount</i></label></td>";
$html .=  "<td><input id='cashamount' type='text' class='ui-widget-content template_text ui-helper-hidden' name='cashamount'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='flyerdays' id='label_flyerdays' class='ui-helper-hidden'><i>Number of Days</i></label></td>";
$html .=  "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ui-helper-hidden' name='flyerdays'></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td><label for='pay_handle' id='label_pay_handle' class='ui-helper-hidden'><i>Describe Payment Handling: (paypal, at location, etc)</i></label></td>";
$html .=  "<td><textarea id='pay_handle' class='ui-widget-content template_text ui-helper-hidden' name='pay_handle' value='' rows='5' cols='5'></textarea></td>";
$html .=  "<td><label id='status'></label></td>";
$html .=  "</tr>";
$html .=  "<tr>";
$html .=  "<td></td>";
$html .=  "<td></td>";
$html .=  "<td>";
$html .=  "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=  "<span class='ui-button-text'>Create</span>";
$html .=  "</button>";
$html .=  "</td>";
$html .=  "</tr>";
$html .=  "</tbody>";
$html .=  "</table>";
$html .=  "</form>";
$html .=  "<script src='js/board_validation_handler.js' type='text/javascript' charset='utf-8'></script>";

return $html;

}

?>
<? print $html; ?>    
