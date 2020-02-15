<?php $modulotab = "trent"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$id = $_POST['id'];
$idrent = retNULL($_POST['idrent']);
$vrdiaria = retNULL($_POST['vrdiaria']);
$idcar = retNULL($_POST['idcar']);
$idclient = retNULL($_POST['idclient']);
$dtdiaria = retNULL($_POST['dtdiaria']);
$qtdeDiaria = retNULL($_POST['qtdediaria']);
//Testa se os campos tem valor
if ($idrent == NULL) {
  $errors .= "Voc� n�o digitou o idrent<br>"; //confere se o campo idrent n�o ficou vazio
}
if ($vrdiaria == NULL) {
  $errors .= "Voc� n�o digitou o vrdiaria<br>"; //confere se o campo vrdiaria n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o digitou o idcar<br>"; //confere se o campo idcar n�o ficou vazio
}
if ($idclient == NULL) {
  $errors .= "Voc� n�o digitou o idclient<br>"; //confere se o campo idclient n�o ficou vazio
}
if ($dtdiaria == NULL) {
  $errors .= "Voc� n�o digitou o dtdiaria<br>"; //confere se o campo dtdiaria n�o ficou vazio
}
if ($qtdeDiaria == NULL) {
  $errors .= "Voc� n�o digitou o qtdeDiaria<br>"; //confere se o campo qtdeDiaria n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (vrdiaria, idcar, idclient, dtdiaria, qtdeDiaria) VALUES ($vrdiaria, $idcar, $idclient, $dtdiaria, $qtdeDiaria)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET vrdiaria = $vrdiaria, idcar = $idcar, idclient = $idclient, dtdiaria = $dtdiaria, qtdeDiaria = $qtdeDiaria WHERE idrent = $idrent"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idrent = $idrent"; //Sql de exclus�o
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
