<?php

$nrCedula = intval($_REQUEST['nrCedula']);

include 'conn.php';

$sql = "delete from voto where idCedula in ( select idCedula from cedula where nrCedula = $nrCedula)";
@mysql_query($sql);
$sql = "delete from cedula where nrCedula = $nrCedula";
@mysql_query($sql);
echo json_encode(array('success'=>true));
?>