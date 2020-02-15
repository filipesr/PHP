<?php
if(in_array($_SERVER['HTTP_HOST'], array('localhost', '127.0.0.1'))){
	// Variaveis do sistema para localhost
	$home = "http://localhost/sigcar";
	
	// Este arquivo conecta um banco de dados MySQL - Servidor = localhost
	//$dbname="dbmargel20110522"; // Indique o nome do banco de dados que ser� aberto
	$dbname = "sigcar"; // Indique o nome do banco de dados que ser� aberto
	$usuario = "root"; // Indique o nome do usu�rio que tem acesso
	$password = ""; // Indique a senha do usu�rio
} else if(in_array($_SERVER['HTTP_HOST'], array('connectconsulting.com.br'))) {
	// Variaveis do sistema para connectconsulting
	$home = "http://connectconsulting.com.br/sigcar";
	
	// Este arquivo conecta um banco de dados MySQL - Servidor = localhost
	$dbname = "connectc_sigcar"; // Indique o nome do banco de dados que ser� aberto
	$usuario = "connectc_siguser"; // Indique o nome do usu�rio que tem acesso
	$password = "master123"; // Indique a senha do usu�rio
} else 
{
	echo "erro de configura&ccedil;&atilde;o";
	exit;
}

//1� passo - Conecta ao servidor MySQL
if (!($id = mysql_connect("localhost", $usuario, $password))) {
  echo "N&atilde;o foi poss&iacute;vel estabelecer uma conex�o com o gerenciador MySQL. Favor Contactar o Administrador.";
  exit;
}
//2� passo - Seleciona o Banco de Dados
if (!($con = mysql_select_db($dbname, $id))) {
  echo "N&atilde;o foi poss&iacute;vel estabelecer uma conex�o com o banco MySQL. Favor Contactar o Administrador.";
  exit;
}
?>