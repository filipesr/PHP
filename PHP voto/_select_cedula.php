<?php

	$nrCedula = intval($_REQUEST['nrCedula']);

	include 'conn.php';

	$rs = mysql_query("select ced.nrcedula nr, ele.descricao deleicao, car.descricao dcargo, can.nome nome
  from cargocandidato cc 
 inner join eleicao ele
 	 on ele.ideleicao = cc.ideleicao
 inner join cargo car
 	 on car.idcargo = cc.idcargo
 inner join candidato can
 	 on can.idcandidato = cc.idcandidato
 inner join voto vot
 	 on vot.idcargocandidato = cc.idcargocandidato
 inner join cedula ced
 	 on ced.idcedula = vot.idcedula
 where ced.nrcedula = $nrCedula
 order by car.idcargo");
	
	$i = 0;
	while($row = mysql_fetch_row($rs)){
		if($i++ = 0){
			echo "Cédula: " . $row[0] . " (" . $row[1] . ")<BR>";
		}
		echo "Cargo: " . $row[2] . ": " . $row[3] . "<BR>";
	}
?>