<?php $modulotab = "tac"; ?>
<?php require("../loga.php"); ?>
<?php

$oper = $_POST['oper'];
$idac = retNULL($_POST['idac']);
$acdesc = retNULL($_POST['acdesc']);
$acabrev = retNULL($_POST['acabrev']);
//Testa se os campos tem valor
if ($idac == NULL) {
  $errors .= "Voc� n�o digitou o idac<br>"; //confere se o campo idac n�o ficou vazio
}
if ($acdesc == NULL) {
  $errors .= "Voc� n�o digitou o acdesc<br>"; //confere se o campo acdesc n�o ficou vazio
}
if ($acabrev == NULL) {
  $errors .= "Voc� n�o digitou o acabrev<br>"; //confere se o campo acabrev n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (acdesc, acabrev) VALUES ($acdesc, $acabrev)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET acdesc = $acdesc, acabrev = $acabrev WHERE idac = $idac"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idac = $idac"; //Sql de exclus�o
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
