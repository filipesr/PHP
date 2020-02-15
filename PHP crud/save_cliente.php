<?php

$firstname = $_REQUEST['nome'];
$lastname = $_REQUEST['sobrenome'];
$phone = $_REQUEST['telefone'];
$email = $_REQUEST['email'];

include 'conn.php';

$sql = "insert into cliente(nome,sobrenome,telefone,email) values('$firstname','$lastname','$phone','$email')";
@mysql_query($sql);
echo json_encode(array(
	'id' => mysql_insert_id(),
	'firstname' => $firstname,
	'lastname' => $lastname,
	'phone' => $phone,
	'email' => $email
));

?>