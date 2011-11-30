<?
// use this to make a link nowcorkit.com?generate_flyer.php?flyerid=12345 would be the QR link
require_once("qrcode.php");

$qr = new SocialQrCode();
$qr->setType ( SocialQrCode::QRCODE_TYPE_PNG );
$qr->generate ( "http://qrcodescript.com" );
$qr->store("../test_code/","testqr.png");

?>