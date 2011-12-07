<?

/***********************************************************************
* XXX.php
* Author		  : Christopher Bartholomew
* Last Updated  : 
* Purpose		  : 
**********************************************************************/


	require_once("includes/constants.php");
	require_once("includes/DAL.php");
	require_once("includes/class_objects.php");
	require_once("includes/helpers.php");


// populate types from get request
$board_id = mysql_real_escape_string($_GET["boardid"]);


$posts = get_all_posts_by_board_id($board_id);

// return the object back as a json request
header('Content-Type: application/json');
echo json_encode($posts);



?>