<?
/*
 * Loads the user's flyers from the database
 */
//$flyers = LoadUserFlyers();
echo "<div id='manager'>";
echo "<ol id='selectable_content'>";
echo "	<li id='item_one' class='ui-state-default'>1</li>";
echo "</ol>";
echo "</div>";

echo "<div id='modal_editor' class='ui-helper-hidden'>";
echo "</div>";
echo "<div id='modal_remove' class='ui-helper-hidden' title='Remove flyer?'>";
echo "<p><span class='ui-icon ui-icon-alert'></span>"; 
echo "Once committed, this flyer cannot be recovered.</p>";
echo "<b>Are you sure?</b>";
echo "</div>";
echo "<div id='droppable_editor'  style='text-align:center;' class='ui-widget-header ui-corner-all'>";
echo "<p>Drop here to edit flyer</p>";
echo "</div>";
echo "<div id='droppable_remover'  style='text-align:center;' class='ui-widget-header ui-corner-all'>";
echo "<p>Drop here to remove flyer</p>";
echo "</div>";
echo "<script>ActivateSelectableContent()</script>";
?>