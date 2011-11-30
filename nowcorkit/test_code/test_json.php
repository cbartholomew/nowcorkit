<?
$sample = array(
	'name'  => $_POST['name_field'],
	'email' => $_POST['email_field']
);

header('Content-Type: application/json');
echo json_encode($sample);
?>