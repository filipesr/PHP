<?php $modulotab = "tdoccar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('iddoc', "AND dc.iddoc = '", "'"); ?>
        <td >&nbsp;documento&nbsp;<?php selComb("iddoc", retRequest('iddoc'), "select iddoc,doc from tdoc order by doc"); ?></td></tr><tr>
          <?php $w .= retRequest('idcar', "AND dc.idcar = '", "'"); ?>
          <td >&nbsp;carro&nbsp;<?php selComb("idcar", retRequest('idcar'), "select idcar,concat(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?>
          </td></tr><tr>
          <?php $dtC = 'dtdoccar'; ?>
          <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
          <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          <td  nowrap>&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
          <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php aTit("carro", "carro"); ?></td>
      <td>&nbsp;<?php aTit("d.doc", "documento"); ?></td>
      <td>&nbsp;<?php aTit("dc.dtdoccar", "Data"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 7;
      //Executa a consulta
      $sql = "Select dc.*, d.doc, CONCAT(c.marca, ' ', c.modelo, ' - placa: ', c.placa) as carro, date_format(dc.dtdoccar, '%d/%m/%Y') AS dt from tdoccar dc, tdoc d, tcar c where dc.iddoc = d.iddoc and dc.idcar = c.idcar " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtdoccar.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="iddoccar" type="hidden" value="<?php echo $row['iddoccar']; ?>">
        <input name="iddoc" type="hidden" value="<?php echo $row['iddoc']; ?>">
        <input name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input name="dtdoccar" type="hidden" value="<?php echo $row['dtdoccar']; ?>">
        <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php echo $row['carro']; ?></td>
        <td >&nbsp;<?php echo $row['doc']; ?></td>
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['iddoccar']; ?>" action="<?php echo $home; ?>/cad/envia_cadtdoccar.php" method="POST">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input name="iddoccar" type="hidden" value="<?php echo $row['iddoccar']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['iddoccar']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr>
    <td colspan="<?php echo $colspan; ?>">&nbsp;
      <div align="center">
        <form action="<?php echo $home; ?>/cad/cadtdoccar.php" method="POST">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="idcar" type="hidden" value="<?php echo retRequest('idcar'); ?>">
          <input name="oper" type="hidden" value="Inserir">
          <input class="btIns" type="submit" value="Inserir">
        </form>
      </div>
    </td>
  </tr>
</table></body></html>
