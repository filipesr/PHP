<?php $modulotab = "titemos"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$iditemos = retNULL($_POST['iditemos']);
$idos = retNULL($_POST['idos']);
$idservice = retNULL($_POST['idservice']);
$vrItemOS = retNULL($_POST['vritemos']);
$oper = $_POST['oper'];
//Testa se os campos tem valor
if ($idos == NULL) {
  $errors .= "Voc� n�o selecionou a OS<br>"; //confere se o campo idos n�o ficou vazio
}
if ($idservice == NULL) {
  $errors .= "Voc� n�o selecionou o Servi�o<br>"; //confere se o campo idservice n�o ficou vazio
}
if ($vrItemOS == NULL) {
  $errors .= "Voc� n�o digitou o valor<br>"; //confere se o campo vrItemOS n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idos, idservice, vrItemOS) VALUES ($idos, $idservice, $vrItemOS)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idos = $idos, idservice = $idservice, vrItemOS = $vrItemOS WHERE iditemos = $iditemos"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE iditemos = $iditemos"; //Sql de exclus�o
if ($errors == "") { //checa se houve ou n�o erros no cadastro
  if ($oper == "Editar") {
    $sql = $sqlUpd;
  };
  if ($oper == "Apagar") {
    $sql = $sqlDel;
  };
  if ($oper == "Inserir") {
    $sql = $sqlIns;
  };
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idos=" . $_POST['idos']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Ocorreu os seguintes erros ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
