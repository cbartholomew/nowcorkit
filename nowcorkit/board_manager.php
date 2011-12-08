<?
	/***********************************************************************
	 * XXX.php
	 * Author		  : Christopher Bartholomew
	 * Last Updated  : 
	 * Purpose		  : 
	 **********************************************************************/

	require_once("includes/common.php");
	
	echo "<select id='board_select' onchange='toggleAndLoadBoard(this.value);' name='board_select' class='ui-widget-content'>";
	echo "<option value='0' selected='selected'>Select Board...</option>";
	echo "<option value='create'>Create Board</option>";
			// load the state to id select box
			$board_array = get_users_boards($_SESSION['users_cork_id']);
			for ($i=0, $n = count($board_array); $i<$n;$i++)
			{
				$board = new Board(null);			
				$board = array_pop($board_array);
				echo "<option value='" . $board->id . "'>" . $board->title . "</option>";
			}
	echo "</select>";	
	
	echo "<div id='tabs' class='ui-helper-hidden'>";
	echo "	<ul>";
	echo "		<li><a href='#tabs-1'>Instructions</a></li>";
	echo "		<li><a href='board_constructor.php?template=general'>General</a></li>";
	echo "		<li><a href='board_constructor.php?template=permission'>Permission</a></li>";
	echo "		<li><a href='board_constructor.php?template=posting'>Posting</a></li>";
	echo "		<li><a href='board_constructor.php?template=post'>Posts</a></li>";
	echo "	</ul>";
	echo "	<div id='tabs-1'>";
	echo "		<p>Select an existing feed, or create a new feed from the drop down menu</p>";
	echo "		<p>To display your board, click the display button below. </p>";
	echo "		<button type='submit' onclick='BuildCork();' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo "		<span class='ui-button-text'>Display Board</span>";
	echo "		</button>";
	echo "		<p>To remove a board, click the remove button below. </p>";
	echo "      <p>Note: Once you remove a board, all flyers that are associated to this board will be unlinked.</p>";
	echo "		<button type='submit' onclick='PreparePurgeBoard();' class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' value='submit'>";
	echo "		<span class='ui-button-text'>Remove Board</span>";
	echo "		</button>";
	echo "	</div>";
	echo "	</div>";
	echo "	<div id='modal_board_preferences' class='ui-helper-hidden'></div>";
	echo "	<div id='dialog-message' class='ui-helper-hidden' title='Update Completed'>";
	echo "	<p>";
	echo "		<span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span>";
	echo "		Update Successful!";
	echo "	</p>";
	echo "</div>";
	echo "<div id='modal_remove' class='ui-helper-hidden' title='Remove Board'>";
	echo "<p><span class='ui-icon ui-icon-alert'></span>"; 
	echo "Once committed, this board cannot be recovered.</p>";
	echo "<b>Remove? </b>";
	echo "<br>";
	echo "<label id='ltitle'></label>";
	echo "</div>";
	
?>