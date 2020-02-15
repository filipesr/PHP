<?php $modulotab = "taudreg"; ?>
<?php require("../loga.php"); ?>
<?php

$idaudreg = retNULL($_POST['idaudreg']);
$idmodulo = retNULL($_POST['idmodulo']);
$iduser = retNULL($_POST['iduser']);
$dtreg = retNULL($_POST['dtreg']);
$sqlReg = retNULL($_POST['sqlreg']);
//Testa se os campos tem valor
if ($idaudreg == NULL) {
  $errors .= "Voc� n�o digitou o idaudreg<br>"; //confere se o campo idaudreg n�o ficou vazio
}
if ($idmodulo == NULL) {
  $errors .= "Voc� n�o digitou o idmodulo<br>"; //confere se o campo idmodulo n�o ficou vazio
}
if ($iduser == NULL) {
  $errors .= "Voc� n�o digitou o iduser<br>"; //confere se o campo iduser n�o ficou vazio
}
if ($dtreg == NULL) {
  $errors .= "Voc� n�o digitou o dtreg<br>"; //confere se o campo dtreg n�o ficou vazio
}
if ($sqlReg == NULL) {
  $errors .= "Voc� n�o digitou o sqlReg<br>"; //confere se o campo sqlReg n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idmodulo, iduser, dtreg, sqlReg) VALUES ($idmodulo, $iduser, $dtreg, $sqlReg)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idmodulo = $idmodulo, iduser = $iduser, dtreg = $dtreg, sqlReg = $sqlReg WHERE idaudreg = $idaudreg"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idaudreg = $idaudreg"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idAud=" . $_POST['idaud']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
