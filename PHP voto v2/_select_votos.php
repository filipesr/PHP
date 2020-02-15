<?php

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$idEleicao = intval($_REQUEST['idEleicao']);
	$offset = ($page-1)*$rows;

	include 'conn.php';

	$rs = mysql_query("select count(*) from CargoCandidato where idEleicao = $idEleicao ");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("Select ele.descricao deleicao, car.descricao dcargo, can.nome nome, count(vot.idVoto) qtde
  from CargoCandidato cc 
 inner join Eleicao ele
 	 on ele.idEleicao = cc.idEleicao
 inner join Cargo car
 	 on car.idCargo = cc.idCargo
 inner join Candidato can
 	 on can.idCandidato = cc.idCandidato
  left join Voto vot
 	 on vot.idCargoCandidato = cc.idCargoCandidato
 where ele.idEleicao = $idEleicao
 group by ele.descricao, car.descricao, can.nome
 order by car.idCargo, qtde desc
 limit $offset,$rows");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>