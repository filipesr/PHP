<?php $modulotab = "tempresa"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('emp', "AND emp LIKE '%", "%'"); ?>
        <td >&nbsp;Empresa</td><td ><input class="form03" name="emp" value="<?php echo retRequest('emp'); ?>" type="text"></td>
        <?php $dtC = 'dtvalidade'; ?>
        <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
        <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td  nowrap>&nbsp;Validade entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("emp", "Empresa"); ?></td>
      <td>&nbsp;<?php aTit("dtvalidade", "Validade"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 6;
      //Executa a consulta
      $sql = "Select *, date_format(dtvalidade, '%d/%m/%Y') AS dt from tempresa WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtempresa.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idempresa" type="hidden" value="<?php echo $row['idempresa']; ?>">
        <input class="form03" name="emp" type="hidden" value="<?php echo $row['emp']; ?>">
        <td >&nbsp;<?php echo $row['emp']; ?></td>
        <input class="form03" name="dtvalidade" type="hidden" value="<?php echo $row['dtvalidade']; ?>">
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idempresa']; ?>" action="<?php echo $home; ?>/cad/envia_cadtempresa.php" method="POST">
        <input name="idempresa" type="hidden" value="<?php echo $row['idempresa']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idempresa']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtempresa.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
