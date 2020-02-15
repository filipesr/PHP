<?php $modulotabela = "tmodulo"; ?>
<?php require("../loga.php"); ?>
<?php

$idmodulo = retNULL($_POST['idmodulo']);
$modulotab = retNULL($_POST['modulotab']);
$modulodesc = retNULL($_POST['modulodesc']);
$ord = retNULL($_POST['ord']);
if ($modulodesc == NULL) {
  $errors .= "Voc� n�o digitou o nome<br>"; //confere se o campo modulodesc n�o ficou vazio
}
if ($modulotab == NULL) {
  $errors .= "Voc� n�o digitou a Tabela<br>"; //confere se o campo modulotab n�o ficou vazio
}
if ($ord == NULL) {
  $errors .= "Voc� n�o digitou a ordem<br>"; //confere se o campo ord n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotabela (modulotab, modulodesc, ord) VALUES ($modulotab, $modulodesc, $ord)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotabela SET modulotab = $modulotab, modulodesc = $modulodesc, ord = $ord WHERE idmodulo = $idmodulo"; //Sql de edi��o
$sqlDel = "Delete from $modulotabela WHERE idmodulo = $idmodulo"; //Sql de exclus�o
if ($errors == "") { //checa se houve ou n�o erros no cadastro
  if ($oper == "Editar") {
    $sql = $sqlUpd;
    if (Ajustaord($ord, $idmodulo) != 0) {
      sqlexec($id, "UPDATE tmodulo SET ord = ord+1 WHERE idmodulo <> $idmodulo and ord >= $ord");
    };
  };
  if ($oper == "Apagar") {
    $sql = $sqlDel;
  };
  if ($oper == "Inserir") {
    $sql = $sqlIns;
    if (Ajustaord($ord, "") != 0) {
      sqlexec($id, "UPDATE tmodulo SET ord = ord+1 WHERE ord >= $ord");
    };
  };
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $id);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
