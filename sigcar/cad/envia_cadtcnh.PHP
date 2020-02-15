<?php $modulotab = "tcnh"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$idcnh = $_POST['idcnh'];
$codcnh = retNULL($_POST['codcnh']);
$dtval = retNULL($_POST['dtval']);
$dtpri = retNULL($_POST['dtpri']);
$dtemissao = retNULL($_POST['dtemissao']);
$org = retNULL($_POST['org']);
$OBS = retNULL($_POST['obs']);
//Testa se os campos tem valor
if ($codcnh == NULL) {
  $errors .= "Voc� n�o digitou o cnh<br>"; //confere se o campo cnh n�o ficou vazio
}
if ($dtval == NULL) {
  $errors .= "Voc� n�o digitou o dtval<br>"; //confere se o campo dtval n�o ficou vazio
}
if ($dtpri == NULL) {
  $errors .= "Voc� n�o digitou o dtpri<br>"; //confere se o campo dtpri n�o ficou vazio
}
if ($dtemissao == NULL) {
  $errors .= "Voc� n�o digitou o dtemissao<br>"; //confere se o campo dtemissao n�o ficou vazio
}
if ($org == NULL) {
  $errors .= "Voc� n�o digitou o org<br>"; //confere se o campo org n�o ficou vazio
}
if ($OBS == NULL) {
  $errors .= "Voc� n�o digitou o OBS<br>"; //confere se o campo OBS n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (cnh, dtval, dtpri, dtemissao, org, OBS) VALUES ($codcnh, $dtval, $dtpri, $dtemissao, $org, $OBS)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET cnh = $codcnh, dtval = $dtval, dtpri = $dtpri, dtemissao = $dtemissao, org = $org, OBS = $OBS WHERE idcnh = $idcnh"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idcnh = $idcnh"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $id);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
