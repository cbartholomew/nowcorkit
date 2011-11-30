<?
	// place holder for ajax load
	//$userid = $_POST["USER_ID"]
	
	//add code here to call list of feeds. 
	//Get something
	
	echo "<select id='feed_select' onchange='toggleAndLoadFeed(this.value);' name='feed_select' class='ui-widget-content'>";
	echo "<option value='0' selected='selected'>Select Feed...</option>";
	echo "<option value='create'>Create New Feed</option>";
	echo "<option value='100'>Test Feed</option>";
	echo "</select>";
	
	echo "<div id='tabs' class='ui-helper-hidden'>";
	echo "	<ul>";
	echo "		<li><a href='#tabs-1'>Instructions</a></li>";
	echo "		<li><a href='feed_constructor.php?property=general'>General</a></li>";
	echo "		<li><a href='feed_constructor.php?property=permission'>Permission</a></li>";
	echo "		<li><a href='feed_constructor.php?property=posting'>Posting</a></li>";
	echo "		<li><a href='feed_constructor.php?property=post'>Posts</a></li>";
	echo "	</ul>";
	echo "	<div id='tabs-1'>";
	echo "		<p>Select an existing feed, or create a new feed from the drop down menu</p>";
	echo "	</div>";
	echo "</div>";
	
	echo "<script>LoadFeedManagerTabs()</script>";
	
?>