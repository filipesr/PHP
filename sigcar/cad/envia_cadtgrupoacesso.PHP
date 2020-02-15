<?php $modulotab = "tgrupoacesso"; ?>
<?php require("../loga.php"); ?>
<?php

$idgrupoacesso = retNULL($_POST['idgrupoacesso']);
$grupodesc = retNULL($_POST['grupodesc']);
if ($grupodesc == NULL) {
  $errors .= "Voc� n�o digitou o nome do grupo<br>"; //confere se o campo grupodesc n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (grupodesc) VALUES ($grupodesc)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET grupodesc = $grupodesc WHERE idgrupoacesso = $idgrupoacesso"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idgrupoacesso = $idgrupoacesso"; //Sql de exclus�o
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
