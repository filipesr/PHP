<?php $modulotab = "tuser"; ?>
<?php require("../loga.php"); ?>
<?php

$iduser = retNULL($_POST['iduser']);
$idgrupoacesso = retNULL($_POST['idgrupoacesso']);
$idempresa = retNULL($_POST['idempresa']);
$login = retNULL($_POST['login']);
$pass = retNULL($_POST['pass']);
$active = retNULL($_POST['active']);
if ($login == NULL) {
  $errors .= "Voc� n�o digitou o login<br>"; //confere se o campo login n�o ficou vazio
}
if ($idgrupoacesso == NULL) {
  $errors .= "Voc� n�o selecionou o Grupo de Acesso<br>"; //confere se o campo idgrupoacesso n�o ficou vazio
}
if ($idempresa == NULL) {
  $errors .= "Voc� n�o selecionou a empresa<br>"; //confere se o campo idempresa n�o ficou vazio
}
if ($pass == NULL) {
  $errors .= "Voc� n�o digitou a Senha<br>"; //confere se o campo pass n�o ficou vazio
}
if ($active == NULL) {
  $active = 0;
}
$sqlIns = "INSERT INTO tuser (idgrupoacesso, idempresa, login, pass, active) VALUES ($idgrupoacesso, $idempresa, $login, $pass, $active)"; //Sql de inser��o
$sqlUpd = "UPDATE tuser SET idgrupoacesso = $idgrupoacesso, idempresa = $idempresa, login = $login, pass = $pass, active = $active WHERE iduser = $iduser"; //Sql de edi��o
$sqlDes = "UPDATE tuser SET active = $active WHERE iduser = $iduser"; //Sql de Desativa��o
$sqlDel = "Delete from tuser WHERE iduser = $iduser"; //Sql de exclus�o
if ($errors == "") { //checa se houve ou n�o erros no cadastro
  if ($oper == "Editar") {
    $sql = $sqlUpd;
  };
  if ($oper == "Apagar") {
    $sql = $sqlDel;
  };
  if ($oper == "Desativar") {
    $sql = $sqlDes;
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
