<?php $modulotab = "trelcol"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$oper = $_POST['oper'];
$idrelcol = retNULL($_POST['idrelcol']);
$relcoltit = retNULL($_POST['relcoltit']);
$idrelfunc = retNULL($_POST['idrelfunc']);
$idrel = retNULL($_POST['idrel']);
$relcol = retNULL($_POST['relcol']);
$agrup = retNULL($_POST['agrup']);
$Ord = retNULL($_POST['ord']);
$Mostrar = retNULL($_POST['mostrar']);
//Testa se os campos tem valor
if ($idrelcol == NULL) {
  $errors .= "Voc� n�o digitou o idrelcol<br>"; //confere se o campo idrelcol n�o ficou vazio
}
if ($relcoltit == NULL) {
  $errors .= "Voc� n�o digitou o relcoltit<br>"; //confere se o campo relcoltit n�o ficou vazio
}
if ($idrel == NULL) {
  $errors .= "Voc� n�o digitou o idrel<br>"; //confere se o campo idrel n�o ficou vazio
}
if ($relcol == NULL) {
  $errors .= "Voc� n�o digitou o relcol<br>"; //confere se o campo relcol n�o ficou vazio
}
if ($agrup == NULL) {
  $errors .= "Voc� n�o digitou o agrup<br>"; //confere se o campo agrup n�o ficou vazio
}
if ($Ord == NULL) {
  $errors .= "Voc� n�o digitou o Ord<br>"; //confere se o campo Ord n�o ficou vazio
}
if ($Mostrar == NULL) {
  $errors .= "Voc� n�o digitou o Mostrar<br>"; //confere se o campo Mostrar n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (relcoltit, idrelfunc, idrel, relcol, agrup, Ord, Mostrar) VALUES ($relcoltit, $idrelfunc, $idrel, $relcol, $agrup, $Ord, $Mostrar)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET relcoltit = $relcoltit, idrelfunc = $idrelfunc, idrel = $idrel, relcol = $relcol, agrup = $agrup, Ord = $Ord, Mostrar = $Mostrar WHERE idrelcol = $idrelcol"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idrelcol = $idrelcol"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idrel=" . $_POST['idrel']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
