<?php $modulotab = "tcompra"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:block">
      <tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idcar', "AND ca.idcar = '", "'"); ?>
        <td >&nbsp;carro
          <?php selComb("idcar", retRequest('idcar'), "select idcar, concat(IFNULL(marca, ' '), ' | ', IFNULL(modelo, ' '), ' - placa: ', IFNULL(placa, ' ')) as carro from tcar order by carro"); ?>
        </td>
        <?php $w .= retRequest('nome', "AND Nome LIKE '%", "%'"); ?>
        <td >&nbsp;Cliente</td><td ><input class="form03" name="nome" value="<?php echo retRequest('nome'); ?>" type="text"></td>
      </tr><tr>
      <?php $dtC = 'dtcompra'; ?>
      <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
      <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
      <td  nowrap>&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
      <?php $w .= retRequest('vrcompra', "AND vrcompra = '", "'"); ?>
      <td >&nbsp;Valor</td><td ><input class="campoData" name="vrcompra" value="<?php echo retRequest('vrcompra'); ?>" type="text"></td>
      <td >
        <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif">
      </td>
  </form>
</tr>
</table>

<table><tr style="<?php echo $TitItem ?>">
    <td>&nbsp;<?php aTit("nome", "Cliente"); ?></td>
    <td>&nbsp;<?php aTit("carro", "carro"); ?></td>
    <td>&nbsp;<?php aTit("c.dtcompra", "Data"); ?></td>
    <td>&nbsp;<?php aTit("vrcompra", "Valor"); ?></td>
    <td nowrap >&nbsp;</td>
    <?php
    $colspan = 8;
    //Executa a consulta
    $sql = "Select c.*, CONCAT(ca.marca, ' | ', ca.modelo, ' - placa: ', ca.placa) as carro, date_format(c.dtcompra, '%d/%m/%Y') AS dtc, cl.nome from tcompra c, tcar ca, tclient cl where c.idcar = ca.idcar and c.idclient = cl.idclient " . $w;
    $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
    //Exibe as linhas encontradas na consulta
    $l = 0;
    while ($row = mysql_fetch_array($res)) {
      $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
      $l++;
      ?>
    <tr style="<?php echo $style; ?>">
    <form action="<?php echo $home; ?>/cad/cadtcompra.php" method="POST">
      <input name="oper" type="hidden" value="Editar">
      <input class="form03" name="idcompra" type="hidden" value="<?php echo $row['idcompra']; ?>">
      <input class="form03" name="idclient" type="hidden" value="<?php echo $row['idclient']; ?>">
      <td >&nbsp;<?php echo $row['nome']; ?></td>
      <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
      <td >&nbsp;<?php echo $row['carro']; ?></td>
      <input class="form03" name="dtcompra" type="hidden" value="<?php echo $row['dtc']; ?>">
      <td >&nbsp;<?php echo $row['dtc']; ?></td>
      <input class="form03" name="vrcompra" type="hidden" value="<?php echo $row['vrcompra']; ?>">
      <td >&nbsp;R$ <?php echo $row['vrcompra']; ?></td>
      <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
      </td></form>
    <form name="Exc<?php echo $row['idcompra']; ?>" action="<?php echo $home; ?>/cad/envia_cadtcompra.php" method="POST">
      <input name="idcompra" type="hidden" value="<?php echo $row['idcompra']; ?>">
      <input name="oper" type="hidden" value="Apagar">
      <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idcompra']; ?>.submit();}" value="Excluir">
      </td></form>
  </tr>
  <?php
}
?>
<tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtcompra.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>