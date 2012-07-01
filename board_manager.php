<?
/***********************************************************************
* board_manager.php
* Author		  : Christopher Bartholomew
* Last Updated   : 12/08/2011
* Purpose		  : This will render the board manager screen, which contains various tabs and hidden modals
**********************************************************************/

require_once("includes/common.php");

function load(){
	$html = "";
	$html .=  "<select id='board_select' name='board_select' style='color: rgb(155, 204, 96);' class='ui-widget-content'>";
	$html .=  "<option value='0' selected='selected'>Select Board...</option>";
	// load the state to id select box
	$board_array = get_users_boards($_SESSION['users_cork_id']);
	for ($i=0, $n = count($board_array); $i<$n;$i++)
	{
		$board = new Board(null);			
		$board = array_pop($board_array);
		$html .=  "<option value='" . $board->id . "'>" . $board->title . "</option>";
	}	
	
	return $html;
}


?>


<?
$html .=  "<div id='middleContainer' class='ui-widget-content ui-corner-all middleContainer ui-helper-hidden'>";
$html .=  "<h3 id='bhead' class='ui-widget-header ui-corner-all middleContainerHead'>Testing</h3>";
$html .=  "<div id='tabs' class='ui-helper-hidden' class=''>";
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
$html .=  "</div>";


$htmlBuilder = '<script>$("#form_content").html("' . $html . '");</script>';

echo $htmlBuilder;

?>
<div id='container' class='ui-widget-content ui-corner-all leftContainer'>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Board Manager</h3>       
    <div id="manager_info" class="ui-widget-content" style="width:320;padding:5px;margin-bottom:5px;">
    You can create, edit preferences, and display your board in this menu.
    </div>
	<br>
	<div id="board_create">
		<button id='create_board' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all buttonMenus'>
		<span class='ui-button-text'>Create Board</span>
		</button>
	</div>
	<br>
	<h3 class="ui-widget-header ui-corner-all leftContainerHead">Your Boards</h3>      
    <div id="board_list" class="ui-widget">
	<? echo load(); ?>
    </div>
</div>	
<script type='text/javascript'>initialize_board_manager();</script>