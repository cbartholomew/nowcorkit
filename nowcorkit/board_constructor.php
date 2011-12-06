<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

require_once('includes/common.php');

// based on the query string, obtain the property. 
// Although the request is registered as POST, the variable will be in $_GET
$template = $_GET["template"];
$board_id = $_GET["board_id"];

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
		build_post_form();
		break;
	case "create":
		build_new_form();
}

function build_general_form($board_id)
{
	
	// create the board object
	$board = new Board(null);
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
				echo "<td><label for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title' value='" . $board->title . "'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='desc'>Description</label></td>";
				echo "<td><input id='desc' type='desc' class='ui-widget-content template_text'  name='desc'  value='" . $board->description . "'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='address'>Address (optional)</label></td>";
				echo "<td><input id='desc' type='desc' class='ui-widget-content template_text'  name='desc'  value='" . $board->address . "'></td>";
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
							
							if ($board->state_id != $state->id) 
							{
								echo "<option value='" . $state->id . "'>" . $state->name . "</option>";
							}
							else 
							{
								echo "<option value='" . $state->id . "'  selected='selected'>" . $state->name . "</option>";
							}
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
			echo  	"<span class='ui-button-text'>Save</span>";
			echo "</button>";
			echo "</td>";
		echo "</tr>";
		
		echo "</tbody>";
	echo "</table>";
	echo "</form>";
	
	echo"<script src='js/board_edit_validation_hand.js' type='text/javascript' charset='utf-8'></script>";
}

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
			
			if ($board->enable_shuffle != 'on')
			{
			echo "<tr>";
				echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
			echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' class='ui-widget-content template_text' name='shuffle'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><label id='label_interval' class='ui-helper-hidden'><i>Interval (in seconds)</i></label></td>";
				echo "<td><input id='interval' type='text' class='ui-widget-content template_text ui-helper-hidden' name='interval'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";
			} 
			else 
			{
				echo "<tr>";
					echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
				echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' class='ui-widget-content template_text' name='shuffle' value='on' checked='checked'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td><label id='label_interval' class='ui-helper-hidden'><i>Interval (in seconds)</i></label></td>";
					echo "<td><input id='interval' type='text' class='ui-widget-content template_text' name='interval' value='". $board->shuffle_interval . "'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";
			
			}
			
			if ($board->pps_id == 1)
			{
				echo "<tr>";
					echo "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
					echo "<td>";
						echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content'>";
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
						echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content'>";
					
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
					echo "<td><label for='cashamount' id='label_cashamount' class=''><i>For this Cash Amount</i></label></td>";
					echo "<td><input id='cashamount' type='text' class='ui-widget-content template_text ' name='cashamount' value='" . $board->pps_cashmount . "'></td>";
					echo "<td><label id='status'></label></td>";
				echo "</tr>";
			
				echo "<tr>";
					echo "<td><label for='flyerdays' id='label_flyerdays' class=''><i>Flyer won't be covered for this many days</i></label></td>";
					echo "<td><input id='flyerdays' type='text' class='ui-widget-content template_text ' name='flyerdays' value='" . $board->pps_flyerdays . "'></td>";
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
	
	echo"<script src='js/board_edit_validation_hand.js' type='text/javascript' charset='utf-8'></script>";
	
}

function build_post_form()
{
	echo "<form id='post' action='post_post.php' method='POST'>";	
	echo "<table class='ui-widget-content ui-corner-all'>";
		echo "<tbody>";

			echo "<tr>";
				echo "<td><label for='pending_approval'>Posts Pending Approval</label></td>";
				echo "<td><input id='pending_approval' type='radio' checked='true'  class='ui-widget-content template_text' name='post_selection'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='all_posts'>All Posts</label></td>";
				echo "<td><input id='all_posts' type='radio' class='ui-widget-content template_text' name='post_selection'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

		echo "</tbody>";
	echo "</table>";
	echo "<br>";
	echo "<table id='table_content' class='ui-corner-all table_data'>";
		echo "<tbody>";

			echo "<tr>";
				echo "<th class='ui-widget-content table_data'><label>Post ID</label></th>";
				echo "<th class='ui-widget-content table_data'><label>Posted By</label></th>";
				echo "<th class='ui-widget-content table_data'><label>Flyer Title</label></th>";
				echo "<th class='ui-widget-content table_data'><label>Flyer Preview</label></th>";
				echo "<th class='ui-widget-content table_data'><label>Approve</label></th>";
				echo "<th class='ui-widget-content table_data'><label>Remove</label></th>";
			echo "</tr>";
			
			for ($i=0;$i<100;$i++)
			{
				echo "<tr>";
					echo "<td class='ui-widget-content table_data'>100</td>";
					echo "<td class='ui-widget-content table_data'>Bartholomew, Christopher</td>";
					echo "<td class='ui-widget-content table_data'>Test Flyer</td>";
					echo "<td class='ui-widget-content table_data'><a href='google.com'>View</a></td>";
					echo "<td class='ui-widget-content table_data'><input id='approve' type='checkbox'  class='ui-widget' name='approve'></td>";
					echo "<td class='ui-widget-content table_data'><input id='remove' type='checkbox'   class='ui-widget' name='remove'></td>";
				echo "</tr>";
			}
			
	echo "</tbody>";
	echo "</table>";	
	echo "</form>";
}


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
				echo "<td><label for='title'>Title</label></td>";
				echo "<td><input id='title' type='text' class='ui-widget-content template_text' name='title'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label for='desc'>Description</label></td>";
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
				echo "<td><label for='shuffle'>Enable Flyer Shuffle</label></td>";
				echo "<td><input id='shuffle' type='checkbox' onchange='toggleShuffleFeature(this.value);' onclick='toggleShuffleCheckBox();' value='off' class='ui-widget-content template_text' name='shuffle'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label id='label_interval' class='ui-helper-hidden'><i>Interval (in seconds)</i></label></td>";
				echo "<td><input id='interval' type='text' class='ui-widget-content template_text ui-helper-hidden' name='interval'></td>";
				echo "<td><label id='status'></label></td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td><label id='lpostpayment'>Pay Per Space Features</label></td>";
				echo "<td>";
					echo "<select id='postpayment' onchange='togglePayPerSpaceFeature(this.value);' class='ui-widget-content'>";
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
				echo "<td></td>";
				echo "<td></td>";
				echo "<td>";
				echo "<button type='submit' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
				echo  	"<span class='ui-button-text'>Create</span>";
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