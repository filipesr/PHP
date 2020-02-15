<?php

$nome = $_REQUEST['nome'];
$sobrenome = $_REQUEST['sobrenome'];
$telefone = $_REQUEST['telefone'];
$email = $_REQUEST['email'];

include 'conn.php';

$sql = "insert into cadastroclientes(nome,sobrenome,telefone,email) values('$nome','$sobrenome','$telefone','$email')";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Erro ao inserir dados.'));
}
?>