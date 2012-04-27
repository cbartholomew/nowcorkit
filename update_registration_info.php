<?	
	require_once("includes/common.php");
	$didchange = update_user_info($_POST);
	echo "<div id='updateCompleted' style='padding:50px' class='ui-widget-content ui-corner-all'><center>User Update Completed</center></div>";
?>	
