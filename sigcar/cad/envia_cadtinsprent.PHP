<?php $modulotab = "tinsprent"; ?>
<?php require("../loga.php"); ?>
<?php

$pesq = $_POST['pesq'];
$id = $_POST['id'];
$idinsprent = retNULL($_POST['idinsprent']);
$inspetor = retNULL($_POST['inspetor']);
$idrent = retNULL($_POST['idrent']);
$dtinsprent = retNULL($_POST['dtinsprent']);
$inspdesc = retNULL($_POST['inspdesc']);
//Testa se os campos tem valor
if ($idinsprent == NULL) {
  $errors .= "Voc� n�o digitou o idinsprent<br>"; //confere se o campo idinsprent n�o ficou vazio
}
if ($inspetor == NULL) {
  $errors .= "Voc� n�o digitou o inspetor<br>"; //confere se o campo inspetor n�o ficou vazio
}
if ($idrent == NULL) {
  $errors .= "Voc� n�o digitou o idrent<br>"; //confere se o campo idrent n�o ficou vazio
}
if ($dtinsprent == NULL) {
  $errors .= "Voc� n�o digitou o dtinsprent<br>"; //confere se o campo dtinsprent n�o ficou vazio
}
if ($inspdesc == NULL) {
  $errors .= "Voc� n�o digitou o inspdesc<br>"; //confere se o campo inspdesc n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (inspetor, idrent, dtinsprent, inspdesc) VALUES ($inspetor, $idrent, $dtinsprent, $inspdesc)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET inspetor = $inspetor, idrent = $idrent, dtinsprent = $dtinsprent, inspdesc = $inspdesc WHERE idinsprent = $idinsprent"; //Sql de edi��o
$sqlDel = "Delete from $modulotab WHERE idinsprent = $idinsprent"; //Sql de exclus�o
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
