<?php

$idEleicao = intval($_REQUEST['idEleicao']);
$nrCedula = intval($_REQUEST['nrCedula']);
$idVice1 = intval($_REQUEST['idVice1']);
$idVice2 = intval($_REQUEST['idVice2']);
$idSec1 = intval($_REQUEST['idSec1']);
$idSec2 = intval($_REQUEST['idSec2']);
$idTes1 = intval($_REQUEST['idTes1']);
$idTes2 = intval($_REQUEST['idTes2']);
$idExa1 = intval($_REQUEST['idExa1']);
$idExa2 = intval($_REQUEST['idExa2']);
$idExa3 = intval($_REQUEST['idExa3']);
$idExa4 = intval($_REQUEST['idExa4']);
$idExa5 = intval($_REQUEST['idExa5']);

include 'conn.php';

// Cédula
$rs = mysql_query("select idCedula from cedula where nrCedula = $nrCedula order by idCedula desc");
$row = mysql_fetch_row($rs);
if($row){
	$result["RETORNO"] = 1;
	$result["MENSAGEM"] = "Este numero de cedula ja existe!";
	echo json_encode($result);
	exit();
}

$sql = "insert into cedula(nrCedula, idEleicao) values('$nrCedula','$idEleicao')";
try {@mysql_query($sql);} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}

$rs = mysql_query("select idCedula from cedula where nrCedula = $nrCedula order by idCedula desc");
$row = mysql_fetch_row($rs);
$idCedula = $row[0];

try {if($idVice1) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idVice1')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idVice2) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idVice2')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idSec1) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idSec1')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idSec2) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idSec2')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idTes1) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idTes1')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idTes2) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idTes2')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idExa1) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idExa1')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idExa2) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idExa2')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idExa3) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idExa3')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idExa4) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idExa4')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}
try {if($idExa5) {$sql = "insert into voto(idCedula,idCargoCandidato) values('$idCedula','$idExa5')"; @mysql_query($sql);}} catch (Exception $e) {echo 'Exceção capturada: ',  $e->getMessage(), "\n";}

$result["DADOS"] = array(
						'idCedula' => $idCedula,
						'idVice1' => $idVice1,
						'idVice2' => $idVice2,
						'idSec1' => $idSec1,
						'idSec2' => $idSec2,
						'idTes1' => $idTes1,
						'idTes2' => $idTes2,
						'idExa1' => $idExa1,
						'idExa2' => $idExa2,
						'idExa3' => $idExa3,
						'idExa4' => $idExa4,
						'idExa5' => $idExa5
					);
$result["RETORNO"] = 0;
echo json_encode($result);

?>