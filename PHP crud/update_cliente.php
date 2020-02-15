<?php

$id = intval($_REQUEST['id']);
$firstname = $_REQUEST['nome'];
$lastname = $_REQUEST['sobrenome'];
$phone = $_REQUEST['telefone'];
$email = $_REQUEST['email'];

include 'conn.php';

$sql = "update cliente set nome='$firstname',sobrenome='$lastname',telefone='$phone',email='$email' where id=$id";
@mysql_query($sql);
echo json_encode(array(
	'id' => $id,
	'firstname' => $firstname,
	'lastname' => $lastname,
	'phone' => $phone,
	'email' => $email
));
?>