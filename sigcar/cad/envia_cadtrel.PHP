<?php $modulotab = "trel"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$oper = $_POST['oper'];
$idrel = retNULL($_POST['idrel']);
$reltit = retNULL($_POST['reltit']);
$idrelcab = retNULL($_POST['idrelcab']);
$reltab = retNULL($_POST['reltab']);
$relwhere = retNULL($_POST['relwhere']);
//Testa se os campos tem valor
if ($idrel == NULL) {
  $errors .= "Voc� n�o digitou o idrel<br>"; //confere se o campo idrel n�o ficou vazio
}
if ($reltit == NULL) {
  $errors .= "Voc� n�o digitou o reltit<br>"; //confere se o campo reltit n�o ficou vazio
}
if ($reltab == NULL) {
  $errors .= "Voc� n�o digitou o reltab<br>"; //confere se o campo reltab n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (reltit, idrelcab, reltab, relwhere) VALUES ($reltit, $idrelcab, $reltab, $relwhere)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET reltit = $reltit, idrelcab = $idrelcab, reltab = $reltab, relwhere = $relwhere WHERE idrel = $idrel"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idrel = $idrel"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idrelcab=" . $idrelcab);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
