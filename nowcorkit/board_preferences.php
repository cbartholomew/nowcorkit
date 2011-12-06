<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

echo "<div id='tabs' class='ui-helper-hidden'>";
echo "	<ul>";
echo "		<li><a href='#tabs-1'>Instructions</a></li>";
echo "		<li><a href='feed_constructor.php?template=general'>General</a></li>";
echo "		<li><a href='feed_constructor.php?template=permission'>Permission</a></li>";
echo "		<li><a href='feed_constructor.php?template=posting'>Posting</a></li>";
echo "		<li><a href='feed_constructor.php?template=post'>Posts</a></li>";
echo "	</ul>";
echo "	<div id='tabs-1'>";
echo "		<p>Select an existing feed, or create a new feed from the drop down menu</p>";
echo "	</div>";
echo "</div>";

echo "<script>LoadFeedManagerTabs()</script>";

?>