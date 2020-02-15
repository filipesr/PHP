<?php $modulotab = "tdoc"; ?>
<?php require("../loga.php"); ?>
<?php

$iddoc = retNULL($_POST['iddoc']);
$doc = retNULL($_POST['doc']);
if ($doc == NULL) {
  $errors .= "Voc� n�o digitou o documento<br>"; //confere se o campo doc n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (doc) VALUES ($doc)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET doc = $doc WHERE iddoc = $iddoc"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE iddoc = $iddoc"; //Sql de exclus�o
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
