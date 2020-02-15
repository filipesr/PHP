<?php $modulotab = "tvenda"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:block"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idcar', "AND v.idcar = '", "'"); ?>
        <td >&nbsp;carro
        <?php selComb("idcar", retRequest('idcar'), "select idcar,concat(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?>
        </td>
        <?php $w .= retRequest('nome', "AND cl.nome LIKE '%", "%'"); ?>
        <td >&nbsp;Cliente</td><td ><input class="campodata" name="nome" value="<?php echo retRequest('nome'); ?>" type="text"></td>
          <?php $w .= retRequest('idvendor', "AND ve.idvendor = '", "'"); ?>
        <td >&nbsp;Vendedor&nbsp;
          <?php selComb("idvendor", retRequest('idvendor'), "select idvendor,vendordesc from tvendor Order by vendordesc"); ?></td></tr><tr>
          <?php $dtC = 'dtvenda'; ?>
          <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
          <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          <td  nowrap>&nbsp;Data da venda entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
          <?php $w .= retRequest('vrvenda', "AND vrvenda = '", "'"); ?>
          <td >&nbsp;Valor de Venda</td><td ><input class="campoData" name="vrvenda" value="<?php echo retRequest('vrvenda'); ?>" type="text"></td></tr><tr>
<?php $dtC = 'dtcompra'; ?>
<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          <td  nowrap>&nbsp;Data da compra entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
<?php $w .= retRequest('vrcompra', "AND vrcompra = '", "'"); ?>
          <td >&nbsp;Valor da Compra</td><td ><input class="campoData" name="vrcompra" value="<?php echo retRequest('vrcompra'); ?>" type="text"></td>
          <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("carro", "carro"); ?></td>
      <td>&nbsp;<?php aTit("nome", "Comprador"); ?></td>
      <td>&nbsp;<?php aTit("vendordesc", "Vendedor"); ?></td>
      <td>&nbsp;<?php aTit("dtcompra", "Data da Compra"); ?></td>
      <td>&nbsp;<?php aTit("dtvenda", "Data da Venda"); ?></td>
      <td>&nbsp;<?php aTit("vrcompra", "Valor da Compra"); ?></td>
      <td>&nbsp;<?php aTit("vrc", "Servi&ccedil;os"); ?></td>
      <td>&nbsp;<strong>Custo</strong></td>
      <td>&nbsp;<?php aTit("vrvenda", "Valor da Venda"); ?></td>
      <td>&nbsp;<strong>Balan&ccedil;o</strong></td>
      <td nowrap >&nbsp;</td>
<?php
$colspan = 9;
//Executa a consulta
$sql = "Select v.*, date_format(v.dtvenda, '%d/%m/%Y') AS dtv, CONCAT(c.marca, ' ', c.modelo, ' - placa: ', c.placa) as carro, cl.nome, ve.vendordesc, date_format(co.dtcompra, '%d/%m/%Y') AS dtc, co.vrcompra, (select sum(vrItemOS) from titemos where idos in (select idos from tos where idcar = c.idcar)) as vrc from tvenda v, tclient cl, tcar c, tvendor ve, tcompra co WHERE v.idcar = c.idcar AND v.idclient = cl.idclient AND v.idvendor = ve.idvendor AND c.idcar = co.idcar " . $w;
$res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
$l = 0;
while ($row = mysql_fetch_array($res)) {
  $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
  $l++;
  ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtvenda.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idvenda" type="hidden" value="<?php echo $row['idvenda']; ?>">
        <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <td >&nbsp;<?php echo $row['carro']; ?></td>
        <input class="form03" name="idclient" type="hidden" value="<?php echo $row['idclient']; ?>">
        <td >&nbsp;<?php echo $row['nome']; ?></td>
        <input class="form03" name="idvendor" type="hidden" value="<?php echo $row['idvendor']; ?>">
        <td >&nbsp;<?php echo $row['vendordesc']; ?></td>
        <td >&nbsp;<?php echo $row['dtc']; ?></td> 
        <input class="form03" name="dtvenda" type="hidden" value="<?php echo $row['dtvenda']; ?>">
        <td >&nbsp;<?php echo $row['dtv']; ?></td>
        <td >R$&nbsp;<?php echo $row['vrcompra']; ?></td>
        <td >R$&nbsp;<?php echo $row['vrc']; ?></td>
        <td >R$&nbsp;<?php echo $row['vrc'] + $row['vrcompra']; ?></td>
        <input class="form03" name="vrvenda" type="hidden" value="<?php echo $row['vrvenda']; ?>">
        <td >R$&nbsp;<?php echo $row['vrvenda']; ?></td>
        <td >R$&nbsp;<?php echo $row['vrvenda'] - ($row['vrc'] + $row['vrcompra']); ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <td >
        <form name="Exc<?php echo $row['idvenda']; ?>" action="<?php echo $home; ?>/cad/envia_cadtvenda.php" method="POST">
          <input name="idvenda" type="hidden" value="<?php echo $row['idvenda']; ?>">
          <input name="oper" type="hidden" value="Apagar">
          &nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idvenda']; ?>.submit();}" value="Excluir">
        </form>
      </td>
    </tr>
  <?php
}
?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtvenda.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
