<?
	/***********************************************************************
	 * XXX.php
	 * Author		  : Christopher Bartholomew
	 * Last Updated  : 
	 * Purpose		  : 
	 **********************************************************************/

	
	echo "<select id='board_select' onchange='toggleAndLoadBoard(this.value);' name='board_select' class='ui-widget-content'>";
	echo "<option value='0' selected='selected'>Select Board...</option>";
	echo "<option value='create'>New Board</option>";
	echo "</select>";
	
	echo "<div id='modal_board_preferences' class='ui-helper-hidden'></div>";
	
?>