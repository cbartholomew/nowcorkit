<?

/***********************************************************************
* generate_board.php
* Author		  : Christopher Bartholomew
* Last Updated   :  12/08/2011  
* Purpose		 : This will generate an entire post object for any board, 
* every post object contains a list of flyers. This is returned back to the user
* in the form of a json object
**********************************************************************/


	require_once("includes/constants.php");
	require_once("includes/DAL.php");
	require_once("includes/class_objects.php");
	require_once("includes/helpers.php");


// populate types from get request
$board_id = mysql_real_escape_string($_POST["boardid"]);


$posts = get_all_approved_posts_by_board_id($board_id);

// return the object back as a json request
header('Content-Type: application/json');
echo json_encode($posts);



?>