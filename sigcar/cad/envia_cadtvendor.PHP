<?php $modulotab = "tvendor"; ?>
<?php require("../loga.php"); ?>
<?php

$idvendor = retNULL($_POST['idvendor']);
$iduser = retNULL($_POST['iduser']);
$login = retNULL($_POST['login']);
$pass = retNULL($_POST['pass']);
$vendordesc = retNULL($_POST['vendordesc']);
//Testa se os campos tem valor
if ($vendordesc == NULL) {
  $errors .= "Voc� n�o digitou o Vendedor<br>"; //confere se o campo vendordesc n�o ficou vazio
}
if ($vendordesc == NULL) {
  $errors .= "Voc� n�o digitou a Descri�ao do Vendedor<br>"; //confere se o campo vendordesc n�o ficou vazio
}
$sqlIns = "INSERT INTO tvendor (iduser, vendordesc) VALUES ($iduser, $vendordesc)"; //Sql de inser��o
$sqlUpd = "UPDATE tvendor SET vendordesc = $vendordesc WHERE idvendor = $idvendor"; //Sql de edi��o
$sqlDel = "UPDATE tuser SET active = 0 WHERE iduser = $iduser"; //Sql de exclus�o
if ($errors == "") { //checa se houve ou n�o erros no cadastro
  if ($oper == "Editar") {
    $sql = $sqlUpd;
    if ($pass != NULL) {
      sqlexec($id, "UPDATE tuser SET pass = $pass WHERE iduser = $iduser"); // Sql de atualiza��o da senha do usu�rio
    };
  };
  if ($oper == "Apagar") {
    $sql = $sqlDel;
  };
  if ($oper == "Inserir") {
    $sql = $sqlIns;
    sqlexec($id, "INSERT INTO tuser (idgrupoacesso, login, pass) VALUES (3, $login, $pass)");
  };
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $_POST['id']);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
