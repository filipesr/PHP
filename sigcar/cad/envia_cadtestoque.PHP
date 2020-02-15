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
$dtcompra = retNULL($_POST['dtcompra']);
$vrcompra = retNULL($_POST['vrcompra']);
$dtvenda = retNULL($_POST['dtvenda']);
$vrvenda = retNULL($_POST['vrvenda']);
$sqlIns = "INSERT INTO $modulotab (marca, modelo, ano_fab, ano_mod, chassi, cor, portas, placa, dtcompra, vrcompra, dtvenda, vrvenda) VALUES ($marca, $modelo, $ano_fab, $ano_mod, $chassi, $cor, $portas, $placa, $dtcompra, $vrcompra, $dtvenda, $vrvenda)"; //Sql de inser��o
$sqlUpd = "UPDATE $modulotab SET marca = $marca, modelo = $modelo, ano_fab = $ano_fab, ano_mod = $ano_mod, chassi = $chassi, cor = $cor, portas = $portas, placa = $placa, dtcompra = $dtcompra, vrcompra = $vrcompra, dtvenda = $dtvenda, vrvenda = $vrvenda WHERE idcar = $idcar"; //Sql de edi��o
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
