<?php $modulotab = "tcompra"; ?>
<?php require("../loga.php"); ?>
<?php

$idcompra = retNULL($_POST['idcompra']);
$idclient = retNULL($_POST['idclient']);
$idcar = retNULL($_POST['idcar']);
$dtcompra = retNULL($_POST['dtcompra']);
$vrcompra = retNULL($_POST['vrcompra']);
//Testa se os campos tem valor
if ($idcompra == NULL) {
  $errors .= "Erro de integridade<br>"; //confere se o campo idcompra n�o ficou vazio
}
if ($idclient == NULL) {
  $errors .= "Erro de integridade<br>"; //confere se o campo idclient n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o selecionou o carro<br>"; //confere se o campo idcar n�o ficou vazio
}
if ($dtcompra == NULL) {
  $errors .= "Voc� n�o digitou a data<br>"; //confere se o campo dtcompra n�o ficou vazio
}
if ($vrcompra == NULL) {
  $errors .= "Voc� n�o digitou o valor<br>"; //confere se o campo vrcompra n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idclient, idcar, dtcompra, vrcompra) VALUES ($idclient, $idcar, $dtcompra, $vrcompra)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idclient = $idclient, idcar = $idcar, dtcompra = $dtcompra, vrcompra = $vrcompra WHERE idcompra = $idcompra"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idcompra = $idcompra"; //Sql de exclus�o
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
