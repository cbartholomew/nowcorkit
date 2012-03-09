<?
/***********************************************************************
* board_manager.php
* Author		  : Christopher Bartholomew
* Last Updated   : 12/08/2011
* Purpose		  : This will render the board manager screen, which contains various tabs and hidden modals
**********************************************************************/

require_once("includes/common.php");
$html = "";
$html .=  "<select id='board_select' name='board_select' style='color: rgb(155, 204, 96);' class='ui-widget-content'>";
$html .=  "<option value='0' selected='selected'>Select Board...</option>";
$html .=  "<option value='create'>Create Board</option>";
	// load the state to id select box
	$board_array = get_users_boards($_SESSION['users_cork_id']);
	for ($i=0, $n = count($board_array); $i<$n;$i++)
	{
	$board = new Board(null);			
	$board = array_pop($board_array);
	$html .=  "<option value='" . $board->id . "'>" . $board->title . "</option>";
	}
$html .=  "</select>";	
$html .=  "<div id='tabs' class='ui-helper-hidden'>";
$html .=  "	<ul>";
$html .=  "		<li><a href='#tabs-1'>Instructions</a></li>";
$html .=  "		<li><a href='board_constructor.php?template=general'>General</a></li>";
$html .=  "		<li><a href='board_constructor.php?template=permission'>Permission</a></li>";
$html .=  "		<li><a href='board_constructor.php?template=posting'>Posting</a></li>";
$html .=  "		<li><a href='board_constructor.php?template=post'>Posts</a></li>";
$html .=  "	</ul>";
$html .=  "	<div id='tabs-1'>";
$html .=  "		<p>Select an existing feed, or create a new feed from the drop down menu</p>";
$html .=  "		<p>To display your board, click the display button below. </p>";
$html .=  "		<button type='submit' id='display_board' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=  "		<span class='ui-button-text'>Display Board</span>";
$html .=  "		</button>";
$html .=  "		<p>To remove a board, click the remove button below. </p>";
$html .=  "      <p>Note: Once you remove a board, all flyers that are associated to this board will be unlinked.</p>";
$html .=  "		<button type='submit' id='remove_board' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
$html .=  "		<span class='ui-button-text'>Remove Board</span>";
$html .=  "		</button>";
$html .=  "	</div>";
$html .=  "	</div>";
$html .=  "	<div id='dialog-message' class='ui-helper-hidden' title='Update Completed'>";
$html .=  "	<p>";
$html .=  "		<span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span>";
$html .=  "		Update Successful!";
$html .=  "	</p>";
$html .=  "</div>";
$html .=  "<div id='modal_board_preferences' class='ui-helper-hidden'></div>";
$html .=  "<div id='modal_remove' class='ui-helper-hidden' title='Remove Board'>";
$html .=  "<p><span class='ui-icon ui-icon-alert'></span>"; 
$html .=  "Once committed, this board cannot be recovered.</p>";
$html .=  "<b>Remove? </b>";
$html .=  "<br>";
$html .=  "<label id='ltitle'></label>";
$html .=  "</div>";
$html .= "<script>initalize_board_manager();</script>";
echo $html;
?>