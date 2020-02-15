<?php $modulotab = "tinsp"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$oper = $_POST['oper'];
$id = $_POST['id'];
$idinsp = retNULL($_POST['idinsp']);
$inspdesc = retNULL($_POST['inspdesc']);
//Testa se os campos tem valor
if ($idinsp == NULL) {
  $errors .= "Voc� n�o digitou o idinsp<br>"; //confere se o campo idinsp n�o ficou vazio
}
if ($inspdesc == NULL) {
  $errors .= "Voc� n�o digitou o inspdesc<br>"; //confere se o campo inspdesc n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (inspdesc) VALUES ($inspdesc)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET inspdesc = $inspdesc WHERE idinsp = $idinsp"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idinsp = $idinsp"; //Sql de exclus�o
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
