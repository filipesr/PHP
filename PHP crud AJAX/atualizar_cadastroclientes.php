<?php

$id = intval($_REQUEST['id']);
$nome = $_REQUEST['nome'];
$sobrenome = $_REQUEST['sobrenome'];
$telefone = $_REQUEST['telefone'];
$email = $_REQUEST['email'];

include 'conn.php';

$sql = "update cliente set nome='$nome',sobrenome='$sobrenome',telefone='$telefone',email='$email' where id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Erro ao atualizar dados.'));
}
?>