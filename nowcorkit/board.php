

<?
/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/
	//require_once("#!/oauth_facebook.php");
	//$user = Validate("http://nowcorkit.com/board.php");
?>

<!DOCTYPE HTML>
<html>
<head>


<!--CSS Files -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/le-frog/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" charset="utf-8"/>
<!--JS Library Files -->
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>
<!--JS Helper Files -->
<script src='js/helper.js' type='text/javascript' charset='utf-8'></script>
<script>
function load(first_name, last_name) { BuildCork(first_name, last_name);  console.log(first_name);}
</script>
</head>

<?
echo "<html>";
echo "<body onload=" . "\"" . "load(". "'" . $user->first_name . "'" . "," . "'" . $user->last_name . "'" . ")" . "\"" . ">";
echo "</body>";
echo "</html>";
?>