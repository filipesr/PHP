<?php $modulotab = "taud"; ?>
<?php require("../loga.php"); ?>
<?php

$idAud = retNULL($_POST['idaud']);
$idmodulo = retNULL($_POST['idmodulo']);
$aler = retNULL($_POST['aler']);
$aeditar = retNULL($_POST['aeditar']);
$ainserir = retNULL($_POST['ainserir']);
$aapagar = retNULL($_POST['aapagar']);
$active = retNULL($_POST['active']);
//Testa se os campos tem valor
if ($idAud == NULL) {
  $errors .= "Erro de integridade<br>"; //confere se o campo idAud n�o ficou vazio
}
if ($idmodulo == NULL) {
  $errors .= "Voc� n�o selecionou o Modulo<br>"; //confere se o campo idmodulo n�o ficou vazio
}
if ($dtaud == NULL) {
  $errors .= "Voc� n�o digitou a data<br>"; //confere se o campo dtaud n�o ficou vazio
}
if ($aler == NULL) {
  $errors .= "Voc� n�o selecionou se registrar� quando LER<br>"; //confere se o campo aler n�o ficou vazio
}
if ($aeditar == NULL) {
  $errors .= "Voc� n�o selecionou se registrar� quando EDITAR<br>"; //confere se o campo aeditar n�o ficou vazio
}
if ($ainserir == NULL) {
  $errors .= "Voc� n�o selecionou se registrar� quando INSERIR<br>"; //confere se o campo ainserir n�o ficou vazio
}
if ($aapagar == NULL) {
  $errors .= "Voc� n�o selecionou se registrar� quando APAGAR<br>"; //confere se o campo aapagar n�o ficou vazio
}
if ($active == NULL) {
  $errors .= "Voc� n�o selecionou se est� ATIVO<br>"; //confere se o campo active n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idmodulo, dtaud, aler, aeditar, ainserir, aapagar, active) VALUES ($idmodulo, Now(), $aler, $aeditar, $ainserir, $aapagar, $active)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idmodulo = $idmodulo, dtaud = Now(), aler = $aler, aeditar = $aeditar, ainserir = $ainserir, aapagar = $aapagar, active = $active WHERE idAud = $idAud"; //Sql de edi��o
$sqlDel = "UPDATE $modulotab SET active = 0 WHERE idAud = $idAud"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $_POST['id']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
