<?php $modulotab = "tcar"; ?>
<?php require("../loga.php"); ?>
<?php

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'uploads/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if (($_FILES['foto1']['error'] != 0) or
	($_FILES['foto2']['error'] != 0) or
	($_FILES['foto3']['error'] != 0) or
	($_FILES['foto4']['error'] != 0) or
	($_FILES['foto5']['error'] != 0) ) {
die("Não foi possível fazer o upload, erro:"
	 . "<br />foto1: " . $_UP['erros'][$_FILES['foto1']['error']]
	 . "<br />foto2: " . $_UP['erros'][$_FILES['foto2']['error']]
	 . "<br />foto3: " . $_UP['erros'][$_FILES['foto3']['error']]
	 . "<br />foto4: " . $_UP['erros'][$_FILES['foto4']['error']]
	 . "<br />foto5: " . $_UP['erros'][$_FILES['foto5']['error']]
);
exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
$extensao1 = strtolower(end(explode('.', $_FILES['foto1']['name'])));
$extensao2 = strtolower(end(explode('.', $_FILES['foto2']['name'])));
$extensao3 = strtolower(end(explode('.', $_FILES['foto3']['name'])));
$extensao4 = strtolower(end(explode('.', $_FILES['foto4']['name'])));
$extensao5 = strtolower(end(explode('.', $_FILES['foto5']['name'])));

if (array_search($extensao1, $_UP['extensoes']) === false) {
echo "Erro foto 1: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}
else if (array_search($extensao2, $_UP['extensoes']) === false) {
echo "Erro foto 2: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}
else if (array_search($extensao3, $_UP['extensoes']) === false) {
echo "Erro foto 3: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}
else if (array_search($extensao4, $_UP['extensoes']) === false) {
echo "Erro foto 4: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}
else if (array_search($extensao5, $_UP['extensoes']) === false) {
echo "Erro foto 5: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['foto1']['size']) {
echo "Erro foto 1: O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
else if ($_UP['tamanho'] < $_FILES['foto2']['size']) {
echo "Erro foto 2: O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
else if ($_UP['tamanho'] < $_FILES['foto3']['size']) {
echo "Erro foto 3: O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
else if ($_UP['tamanho'] < $_FILES['foto4']['size']) {
echo "Erro foto 4: O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
else if ($_UP['tamanho'] < $_FILES['foto5']['size']) {
echo "Erro foto 5: O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
	$nome_final1 = time().'.'.$extensao1;
	$nome_final2 = time().'.'.$extensao2;
	$nome_final3 = time().'.'.$extensao3;
	$nome_final4 = time().'.'.$extensao4;
	$nome_final5 = time().'.'.$extensao5;
	} else {
	// Mantém o nome original do arquivo
	$nome_final1 = $_FILES['foto1']['name'];
	$nome_final2 = $_FILES['foto2']['name'];
	$nome_final3 = $_FILES['foto3']['name'];
	$nome_final4 = $_FILES['foto4']['name'];
	$nome_final5 = $_FILES['foto5']['name'];
	}
	
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	if (move_uploaded_file($_FILES['foto1']['tmp_name'], $_UP['pasta'] . $nome_final1)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	echo "Upload efetuado com sucesso!";
	echo '<br /><img src="' . $_UP['pasta'] . $nome_final1 . '">';
	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}
	if (move_uploaded_file($_FILES['foto2']['tmp_name'], $_UP['pasta'] . $nome_final2)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	echo "Upload efetuado com sucesso!";
	echo '<br /><img src="' . $_UP['pasta'] . $nome_final2 . '">';
	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}
	if (move_uploaded_file($_FILES['foto3']['tmp_name'], $_UP['pasta'] . $nome_final3)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	echo "Upload efetuado com sucesso!";
	echo '<br /><img src="' . $_UP['pasta'] . $nome_final3 . '">';
	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}
	if (move_uploaded_file($_FILES['foto4']['tmp_name'], $_UP['pasta'] . $nome_final4)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	echo "Upload efetuado com sucesso!";
	echo '<br /><img src="' . $_UP['pasta'] . $nome_final4 . '">';
	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}
	if (move_uploaded_file($_FILES['foto5']['tmp_name'], $_UP['pasta'] . $nome_final5)) {
	// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	echo "Upload efetuado com sucesso!";
	echo '<br /><img src="' . $_UP['pasta'] . $nome_final5 . '">';
	} else {
	// Não foi possível fazer o upload, provavelmente a pasta está incorreta
	echo "Não foi possível enviar o arquivo, tente novamente";
	}


}

/* SIG CAR */
$idcar = retNULL($_POST['idcar']);

$sql = "UPDATE $modulotab SET foto1 = $nome_final1, foto2 = $nome_final2, foto3 = $nome_final3, foto4 = $nome_final4, foto5 = $nome_final5 WHERE idcar = $idcar"; //Sql de edi��o
SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $id);
?>
