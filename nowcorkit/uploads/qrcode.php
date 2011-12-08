<?

/***********************************************************************
 * XXX.php
 * Author		  : Christopher Bartholomew
 * Last Updated  : 
 * Purpose		  : 
 **********************************************************************/

	header('content-type: image/png');
	$url = 'https://chart.googleapis.com/chart?chid=' . md5(uniqid(rand(), true));
	$chd = "http://nowcorkit.com/generate.php?flyerid=12345";

	// Add image type, image size, and data to params.
	$qrcode = array(
	  'cht' => 'qr',
	  'chs' => '300x300',
	  'chl' => $chd);

	// Send the request, and print out the returned bytes.
	$context = stream_context_create(
	  array('http' => array(
	    'method' => 'POST',
	    'content' => http_build_query($qrcode))));
	fpassthru(fopen($url, 'r', false, $context));

?>