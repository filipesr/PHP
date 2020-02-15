<?php $modulotab = "tvenda"; ?>
<?php require("../loga.php"); ?>
<?php

$idvenda = retNULL($_POST['idvenda']);
$idclient = retNULL($_POST['idclient']);
$idcar = retNULL($_POST['idcar']);
$idvendor = retNULL($_POST['idvendor']);
$dtvenda = retNULL($_POST['dtvenda']);
$vrvenda = retNULL($_POST['vrvenda']);
//Testa se os campos tem valor
if ($idvenda == NULL) {
  $errors .= "Erro de integridade<br>"; //confere se o campo idvenda n�o ficou vazio
}
if ($idclient == NULL) {
  $errors .= "Voc� n�o selecionou o comprador<br>"; //confere se o campo idclient n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o selecionou o carro<br>"; //confere se o campo idcar n�o ficou vazio
}
if ($idvendor == NULL) {
  $errors .= "Voc� n�o selecionou o vendedor<br>"; //confere se o campo idvendor n�o ficou vazio
}
if ($dtvenda == NULL) {
  $errors .= "Voc� n�o digitou a data<br>"; //confere se o campo dtvenda n�o ficou vazio
}
if ($vrvenda == NULL) {
  $errors .= "Voc� n�o digitou o valor<br>"; //confere se o campo vrvenda n�o ficou vazio
}
$sqlIns = "INSERT INTO tvenda (idclient, idcar, idvendor, dtvenda, vrvenda) VALUES ($idclient, $idcar, $idvendor, $dtvenda, $vrvenda)"; //Sql de inser��o
$sqlUpd = "UPDATE tvenda SET idclient = $idclient, idcar = $idcar, idvendor = $idvendor, dtvenda = $dtvenda, vrvenda = $vrvenda WHERE idvenda = $idvenda"; //Sql de edi��o
$sqlDel = "Delete from tvenda WHERE idvenda = $idvenda"; //Sql de exclus�o
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
