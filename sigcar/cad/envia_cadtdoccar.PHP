<?php $modulotab = "tdoccar"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$iddocCar = retNULL($_POST['iddoccar']);
$iddoc = retNULL($_POST['iddoc']);
$idcar = retNULL($_POST['idcar']);
$dtdoccar = retNULL($_POST['dtdoccar']);
$oper = $_POST['oper'];
//Testa se os campos tem valor
if ($iddoc == NULL) {
  $errors .= "Voc� n�o selecionou o documento<br>"; //confere se o campo iddoc n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o selecionou o carro<br>"; //confere se o campo idcar n�o ficou vazio
}
if ($dtdoccar == NULL) {
  $errors .= "Voc� n�o digitou a data<br>"; //confere se o campo dtdoccar n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (iddoc, idcar, dtdoccar) VALUES ($iddoc, $idcar, $dtdoccar)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET iddoc = $iddoc, idcar = $idcar, dtdoccar = $dtdoccar WHERE iddocCar = $iddocCar"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE iddocCar = $iddocCar"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idcar=" . $_POST['idcar']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Ocorreu os seguintes erros ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
