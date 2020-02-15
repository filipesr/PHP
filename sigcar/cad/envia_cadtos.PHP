<?php $modulotab = "tos"; ?>
<?php require("../loga.php"); ?>
<?php

$idos = retNULL($_POST['idos']);
$idcar = retNULL($_POST['idcar']);
$dtos = retNULL($_POST['dtos']);
if ($dtos == NULL) {
  $errors .= "Voc� n�o digitou a data<br>"; //confere se o campo dtos n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o selecionou o carro<br>"; //confere se o campo idcar n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idcar, dtos) VALUES ($idcar, $dtos)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idcar = $idcar, dtos = $dtos WHERE idos = $idos"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idos = $idos"; //Sql de exclus�o
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
