<?php

	$idCargo = intval($_REQUEST['idCargo']);

	include 'conn.php';

	$rs = mysql_query("SELECT idCandidato as valor, nome as texto FROM `candidato` WHERE idCandidato in (SELECT idCandidato FROM `cargocandidato` WHERE idCargo = $idCargo)");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}

	echo json_encode($items);

?>