<?php $modulotab = "tacesso"; ?>
<?php require("../loga.php"); ?>
<?php

$idacesso = retNULL($_POST['idacesso']);
$idgrupoacesso = retNULL($_POST['idgrupoacesso']);
$idmodulo = retNULL($_POST['idmodulo']);
$dtvalidade = retNULL($_POST['dtvalidade']);
$menu = retNULL($_POST['menu']);
$aler = retNULL($_POST['aler']);
$ainserir = retNULL($_POST['ainserir']);
$aeditar = retNULL($_POST['aeditar']);
$aapagar = retNULL($_POST['aapagar']);
if ($idgrupoacesso == NULL) {
  $errors .= "Voc� n�o selecionou o Grupo de Acesso<br>"; //confere se o campo idgrupoacesso n�o ficou vazio
}
if ($idmodulo == NULL) {
  $errors .= "Voc� n�o selecionou o Modulo<br>"; //confere se o campo idmodulo n�o ficou vazio
}
if ($dtvalidade == NULL) {
  $errors .= "Voc� n�o digitou o data de Validade<br>"; //confere se o campo dtvalidade n�o ficou vazio
}
if ($menu == NULL) {
  $errors .= "Voc� n�o selecinou se exibe menu<br>"; //confere se o campo menu n�o ficou vazio
}
if ($aler == NULL) {
  $errors .= "Voc� n�o selecinou se pode Ler<br>"; //confere se o campo aler n�o ficou vazio
}
if ($ainserir == NULL) {
  $errors .= "Voc� n�o selecinou se pode Inserir<br>"; //confere se o campo ainserir n�o ficou vazio
}
if ($aeditar == NULL) {
  $errors .= "Voc� n�o selecinou se pode Editar<br>"; //confere se o campo aeditar n�o ficou vazio
}
if ($aapagar == NULL) {
  $errors .= "Voc� n�o digitou o aapagar<br>"; //confere se o campo aapagar n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (idgrupoacesso, idmodulo, dtvalidade, menu, aler, ainserir, aeditar, aapagar) VALUES ($idgrupoacesso, $idmodulo, $dtvalidade, $menu, $aler, $ainserir, $aeditar, $aapagar)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET idgrupoacesso = $idgrupoacesso, idmodulo = $idmodulo, dtvalidade = $dtvalidade, menu = $menu, aler = $aler, ainserir = $ainserir, aeditar = $aeditar, aapagar = $aapagar WHERE idacesso = $idacesso"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idacesso = $idacesso"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "idgrupoacesso=" . $_POST['idgrupoacesso']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
