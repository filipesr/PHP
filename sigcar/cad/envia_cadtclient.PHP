<?php $modulotab = "tclient"; ?>
<?php require("../loga.php"); ?>
<?php

$idclient = retNULL($_POST['idclient']);
$iduser = retNULL($_POST['iduser']);
$login = retNULL($_POST['login']);
$nome = retNULL($_POST['nome']);
$tel = retNULL($_POST['tel']);
$rua = retNULL($_POST['rua']);
$cidade = retNULL($_POST['cidade']);
$bairro = retNULL($_POST['bairro']);
$uf = retNULL($_POST['uf']);
$cpfcnpj = retNULL($_POST['cpfcnpj']);
$ciie = retNULL($_POST['ciie']);
if ($nome == NULL) {
  $errors .= "Voc� n�o digitou o nome<br>"; //confere se o campo nome n�o ficou vazio
}
if ($iduser == NULL) {
  $errors .= "Voc� n�o digitou selecionou o Usu�rio<br>"; //confere se o campo iduser n�o ficou vazio
}
if ($tel == NULL) {
  $errors .= "Voc� n�o digitou o telefone<br>"; //confere se o campo tel n�o ficou vazio
}
if ($rua == NULL) {
  $errors .= "Voc� n�o digitou a rua<br>"; //confere se o campo rua n�o ficou vazio
}
if ($cidade == NULL) {
  $errors .= "Voc� n�o digitou a cidade<br>"; //confere se o campo cidade n�o ficou vazio
}
if ($bairro == NULL) {
  $errors .= "Voc� n�o digitou o bairro<br>"; //confere se o campo bairro n�o ficou vazio
}
if ($uf == NULL) {
  $errors .= "Voc� n�o digitou o uf<br>"; //confere se o campo uf n�o ficou vazio
}
if ($cpfcnpj == NULL) {
  $errors .= "Voc� n�o digitou o CPF/CNPJ<br>"; //confere se o campo cpfcnpj n�o ficou vazio
}
if ($ciie == NULL) {
  $errors .= "Voc� n�o digitou o CI/IE<br>"; //confere se o campo ciie n�o ficou vazio
}
$sqlIns = "INSERT INTO $modulotab (iduser, nome, tel, rua, cidade, bairro, uf, cpfcnpj, ciie) VALUES ($iduser, $nome, $tel, $rua, $cidade, $bairro, $uf, $cpfcnpj, $ciie)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET nome = $nome, tel = $tel, rua = $rua, cidade = $cidade, bairro = $bairro, uf = $uf, cpfcnpj = $cpfcnpj, ciie = $ciie WHERE idclient = $idclient"; //Sql de edi��o
$sqlDel = "UPDATE tuser SET active = 0 WHERE iduser = $iduser"; //Sql de exclus�o
if ($errors == "") { //checa se houve ou n�o erros no cadastro
  if ($oper == "Editar") {
    $sql = $sqlUpd;
  };
  if ($oper == "Apagar") {
    $sql = $sqlDel;
  };
  if ($oper == "Inserir") {
    $sql = $sqlIns;
    sqlexec($id, "INSERT INTO tuser (idgrupoacesso, login) VALUES (4, $login)");
  };
  SaidaEnvia_cad(sqlexec($id, $sql, $oper, $modulotab), $home, $modulotab, "id=" . $id);
}
else {
  echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif>Os seguintes erros ocorreram ao tentar realizar essa opera��o:<br><br>$errors</font></div>"; //mostra os erros do usu�rio, caso houver
}
?>
