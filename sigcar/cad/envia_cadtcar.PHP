<?php $modulotab = "tcar"; ?>
<?php require("../loga.php"); ?>
<?php

$idcar = retNULL($_POST['idcar']);
$marca = retNULL($_POST['marca']);
$modelo = retNULL($_POST['modelo']);
$ano_fab = retNULL($_POST['ano_fab']);
$ano_mod = retNULL($_POST['ano_mod']);
$chassi = retNULL($_POST['chassi']);
$cor = retNULL($_POST['cor']);
$portas = retNULL($_POST['portas']);
$placa = retNULL($_POST['placa']);
if ($marca == NULL) {
  $errors .= "Voc� n�o digitou o Marca<br>"; //confere se o campo marca n�o ficou vazio
}
if ($modelo == NULL) {
  $errors .= "Voc� n�o digitou o Modelo<br>"; //confere se o campo modelo n�o ficou vazio
}
if ($ano_fab == NULL) {
  $errors .= "Voc� n�o digitou o ano de fabrica�ao<br>"; //confere se o campo ano_fab n�o ficou vazio
}
if ($ano_mod == NULL) {
  $errors .= "Voc� n�o digitou o ano do modelo<br>"; //confere se o campo ano_mod n�o ficou vazio
}
if ($chassi == NULL) {
  $errors .= "Voc� n�o digitou o chassi<br>"; //confere se o campo chassi n�o ficou vazio
}
if ($cor == NULL) {
  $errors .= "Voc� n�o digitou a cor<br>"; //confere se o campo cor n�o ficou vazio
}
if ($portas == NULL) {
  $errors .= "Voc� n�o digitou o numero de portas<br>"; //confere se o campo portas n�o ficou vazio
}
if ($placa == NULL) {
  $errors .= "Voc� n�o digitou a placa<br>"; //confere se o campo placa n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (marca, modelo, ano_fab, ano_mod, chassi, cor, portas, placa) VALUES ($marca, $modelo, $ano_fab, $ano_mod, $chassi, $cor, $portas, $placa)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET marca = $marca, modelo = $modelo, ano_fab = $ano_fab, ano_mod = $ano_mod, chassi = $chassi, cor = $cor, portas = $portas, placa = $placa WHERE idcar = $idcar"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idcar = $idcar"; //Sql de exclus�o
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
