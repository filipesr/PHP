<?php $modulotab = "tcnh"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('codcnh', "AND cnh = '", "'"); ?>
        <td>&nbsp;cnh:</td><td><input class="form03" name="codcnh" value="<?php echo retRequest('codcnh'); ?>" type="Text"></td>
        <?php $w .= retRequest('dtpri', "AND dtpri = '", "'"); ?>
        <?php $dtC = "dtpri"; ?>
		<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
		<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Primeira Habilita��o entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td></td>
        <?php $w .= retRequest('dtemissao', "AND dtemissao = '", "'"); ?>
        <?php $dtC = "dtemissao"; ?>
		<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
		<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Data de Emiss�o entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td></td>
        <?php $w .= retRequest('dtval', "AND dtval = '", "'"); ?>
        <?php $dtC = "dtval"; ?>
		<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
		<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Data de Validade entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td></td>
        <?php $w .= retRequest('org', "AND org LIKE '%", "%'"); ?>
        <td>&nbsp;org�o expeditor:</td><td><input class="form03" name="org" value="<?php echo retRequest('org'); ?>" type="Text"></td>
        <?php $w .= retRequest('obs', "AND obs LIKE '%", "%'"); ?>
        <td>&nbsp;Obs.:</td><td><input class="form03" name="obs" value="<?php echo retRequest('obs'); ?>" type="Text"></td>
        <td nowrap>
          <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
          <input class="btPesq" name="Limpar" value="Limpar" type="reset">
          <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif">
        </td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td><?php aTit("cnh", "cnh") ?></td>
      <td><?php aTit("dtpri", "Prim. Hab.") ?></td>
      <td><?php aTit("dtemissao", "Emiss�o") ?></td>
      <td><?php aTit("dtval", "Validade") ?></td>
      <td><?php aTit("org", "org�o Expeditor") ?></td>
      <td nowrap>&nbsp;</td>
      <?php
      $colspan = 10;
//Executa a consulta
      $sql = "Select * from $modulotab WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idcnh" type="hidden" value="<?php echo $row['idcnh']; ?>">
        <input class="form03" name="codcnh" type="hidden" value="<?php echo $row['cnh']; ?>">
        <td>&nbsp;<?php echo $row['cnh']; ?></td>
        <input class="form03" name="dtval" type="hidden" value="<?php echo $row['dtval']; ?>">
        <input class="form03" name="dtpri" type="hidden" value="<?php echo $row['dtpri']; ?>">
        <input class="form03" name="dtemissao" type="hidden" value="<?php echo $row['dtemissao']; ?>">
        <td>&nbsp;<?php echo $row['dtpri']; ?></td>
        <td>&nbsp;<?php echo $row['dtemissao']; ?></td>
        <td>&nbsp;<?php echo $row['dtval']; ?></td>
        <input class="form03" name="org" type="hidden" value="<?php echo $row['org']; ?>">
        <td>&nbsp;<?php echo $row['org']; ?></td>
        <input class="form03" name="obs" type="hidden" value="<?php echo $row['obs']; ?>">
        <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idcnh']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
        <input name="idcnh" type="hidden" value="<?php echo $row['idcnh']; ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idcnh']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr>
    <td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center">
        <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab ?>.php" method="POST">
          <input name="oper" type="hidden" value="Inserir">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
          <input class="btIns" type="submit" value="Inserir">
        </form></div>
    </td>
  </tr>
</table></body></html>
