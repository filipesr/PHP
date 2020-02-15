<?php $modulotab = "trelfunc"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$oper = $_POST['oper'];
$id = $_POST['id'];
$idrelfunc = retNULL($_POST['idrelfunc']);
$funcdesc = retNULL($_POST['funcdesc']);
$funcpre = retNULL($_POST['funcpre']);
$funcpos = retNULL($_POST['funcpos']);
//Testa se os campos tem valor
if ($idrelfunc == NULL) {
  $errors .= "Voc� n�o digitou o idrelfunc<br>"; //confere se o campo idrelfunc n�o ficou vazio
}
if ($funcdesc == NULL) {
  $errors .= "Voc� n�o digitou o funcdesc<br>"; //confere se o campo funcdesc n�o ficou vazio
}
if ($funcpre == NULL) {
  $errors .= "Voc� n�o digitou o funcpre<br>"; //confere se o campo funcpre n�o ficou vazio
}
if ($funcpos == NULL) {
  $errors .= "Voc� n�o digitou o funcpos<br>"; //confere se o campo funcpos n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (funcdesc, funcpre, funcpos) VALUES ($funcdesc, $funcpre, $funcpos)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET funcdesc = $funcdesc, funcpre = $funcpre, funcpos = $funcpos WHERE idrelfunc = $idrelfunc"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idrelfunc = $idrelfunc"; //Sql de exclus�o
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
