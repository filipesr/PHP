<?php $modulotab = "tempresa"; ?>
<?php require("../loga.php"); ?>
<?php

$idempresa = retNULL($_POST['idempresa']);
$emp = retNULL($_POST['emp']);
$dtvalidade = retNULL($_POST['dtvalidade']);
if ($emp == NULL) {
  $errors .= "Voc� n�o digitou o nome<br>"; //confere se o campo emp n�o ficou vazio
}
if ($dtvalidade == NULL) {
  $errors .= "Voc� n�o digitou a Validade<br>"; //confere se o campo dtvalidade n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (emp, dtvalidade) VALUES ($emp, $dtvalidade)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET emp = $emp, dtvalidade = $dtvalidade WHERE idempresa = $idempresa"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idempresa = $idempresa"; //Sql de exclus�o
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
