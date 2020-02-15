<?php $modulotab = "tcar"; ?>
<?php require("../loga.php"); ?>
<?php

$sqlFoto = array();
// Confirma os arquivos enviados
if ($_FILES['foto1']['name'] != "" && trataFoto($_FILES['foto1'], $nome_final1))
{ $sqlFoto[] = "foto1 = '" . $nome_final1 . "'";}
if ($_FILES['foto2']['name'] != "" && trataFoto($_FILES['foto2'], $nome_final2))
{ $sqlFoto[] = "foto2 = '" . $nome_final2 . "'";}
if ($_FILES['foto3']['name'] != "" && trataFoto($_FILES['foto3'], $nome_final3))
{ $sqlFoto[] = "foto3 = '" . $nome_final3 . "'";}
if ($_FILES['foto4']['name'] != "" && trataFoto($_FILES['foto4'], $nome_final4))
{ $sqlFoto[] = "foto4 = '" . $nome_final4 . "'";}
if ($_FILES['foto5']['name'] != "" && trataFoto($_FILES['foto5'], $nome_final5))
{ $sqlFoto[] = "foto5 = '" . $nome_final5 . "'";}



/* SIG CAR */
$idcar = retNULL($_POST['idcar']);
if (count($sqlFoto) > 0){
  $sql = "UPDATE $modulotab SET " . implode(", ", $sqlFoto) . " WHERE idcar = $idcar"; //Sql de edi��o
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $id);
}
?>
