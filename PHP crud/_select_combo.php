<?php

	$table = $_REQUEST['class'];
	$valor = $_REQUEST['valor'];
	$texto = $_REQUEST['texto'];
	$offset = ($page-1)*$rows;

	include 'conn.php';

	$rs = mysql_query("select $valor as valor, $texto as texto from $table ");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}

	echo json_encode($items);

?>