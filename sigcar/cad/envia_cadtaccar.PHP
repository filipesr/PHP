<?php $modulotab = "taccar"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$idaccar = retNULL($_POST['idaccar']);
$idac = retNULL($_POST['idac']);
$idcar = retNULL($_POST['idcar']);
$oper = $_POST['oper'];
//Testa se os campos tem valor
if ($idaccar == NULL) {
  $errors .= "Voc� n�o digitou o idaccar<br>"; //confere se o campo idaccar n�o ficou vazio
}
if ($idac == NULL) {
  $errors .= "Voc� n�o digitou o idac<br>"; //confere se o campo idac n�o ficou vazio
}
if ($idcar == NULL) {
  $errors .= "Voc� n�o digitou o idcar<br>"; //confere se o campo idcar n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idac, idcar) VALUES ($idac, $idcar)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idac = $idac, idcar = $idcar WHERE idaccar = $idaccar"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idaccar = $idaccar"; //Sql de exclus�o
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
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
