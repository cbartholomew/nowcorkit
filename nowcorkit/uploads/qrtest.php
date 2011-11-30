<?

require_once("../#!/qrcode.php");

$qr = new SocialQrCode ();
$qr->setType ( SocialQrCode::QRCODE_TYPE_PNG );
$qr->generate ( "http://qrcodescript.com" );
$qr->store ( ".uploads/", "mycode1.bin" );

?>