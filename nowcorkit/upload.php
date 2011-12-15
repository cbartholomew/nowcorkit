<?php
/*
Server-side PHP file upload code for HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net

Original Author above, I've modified this file slightly to edit the file name based on the users's session id before uploading
Modifiy Date: 12/08/2011
*/

require_once("includes/common.php");

$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SESSION["users_cork_id"] . "_" . $_SERVER['HTTP_X_FILENAME'] : false);

if ($fn) {

	// AJAX call
	file_put_contents(
		'flyers/images/' . $fn,
		file_get_contents('php://input')
	);
	echo "$fn uploaded";
	exit();

} else {

			// form submit
			$files = $_FILES['fileselect'];
			$fn = $files['name'];
			$fn = $_SESSION["users_cork_id"] . "_" . $fn;
			move_uploaded_file(
				$files['tmp_name'],
				'flyers/images/' . $fn
			);
			echo "<p>File $fn uploaded.</p>";
}