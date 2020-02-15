<?php
	//header
	//header("Content-type: image/png");
	include "functions.php"; // Conecta ao banco de dados
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OrlaOnline</title>
<link href="adm/css/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Topo -->
<?php include "partes/menuacessivel.php"; 		// Menu Acessível ?>
<?php include "partes/topo.php"; 				// Topo ?>

<!-- Barra lateral esquerda -->
<?php include "partes/menu.php"; 				// Menu ?>
<?php include "partes/revistaonline.php";		// Revista online ?>
<?php include "partes/servicos.php";			// Servicos ?>

<!-- Conteúdo -->
<div id="Contrucao"><img src="img/underconstruction.gif" alt="Em Constru&ccedil;&atilde;o" /></div>

<!-- Rodapé -->
<?php include "partes/rodape.php";				// Rodape ?>

<!-- Banners de propaganda -->
<?php include "partes/propaganda.php";			// Propaganda ?>

</body>
</html>
