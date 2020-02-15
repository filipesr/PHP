<?php $modulotab = "tservice"; ?>
<?php require("../loga.php"); ?>
<?php

$idservice = retNULL($_POST['idservice']);
$servicedesc = retNULL($_POST['servicedesc']);
$price = retNULL($_POST['price']);
if ($servicedesc == NULL) {
  $errors .= "Voc� n�o digitou o Servi�o<br>"; //confere se o campo servicedesc n�o ficou vazio
}
if ($price == NULL) {
  $errors .= "Voc� n�o digitou o pre�o<br>"; //confere se o campo price n�o ficou vazio
}
$sqlIns = "INSERT INTO tservice (servicedesc, price) VALUES ($servicedesc, $price)"; //Sql de inser��o
$sqlUpd = "UPDATE tservice SET servicedesc = $servicedesc, price = $price WHERE idservice = $idservice"; //Sql de edi��o
$sqlDel = "Delete from tservice WHERE idservice = $idservice"; //Sql de exclus�o
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
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "iditemos=" . $_POST['iditemos']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Ocorreu os seguintes erros ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
