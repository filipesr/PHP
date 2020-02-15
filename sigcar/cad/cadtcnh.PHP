<?php $modulotab = "tcnh"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="id" type="hidden" value="<?php echo retRequest('id') ?>">
        <input name="idcnh" type="hidden" value="<?php echo retRequest('idcnh') ?>">
        <tr><td>&nbsp;CNH:</td><td><input class="form03" name="codcnh" value="<?php echo retRequest('codcnh'); ?>" type="Text"></td></tr>
        <?php $dtC = "dtpri"; ?>
		<?php  $w .= retRequest($dtC, "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Primeira Habilita��o:</td><td><?php dtCal($modulotab, $dtC, retRequest($dtC)); ?></td></tr>
        <?php $dtC = "dtval"; ?>
		<?php $w .= retRequest($dtC, "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Validade:</td><td><?php dtCal($modulotab, $dtC, retRequest($dtC)); ?></td></tr>
        <?php $dtC = "dtemissao"; ?>
		<?php $w .= retRequest($dtC, "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Data de Emissao:</td><td><?php dtCal($modulotab, $dtC, retRequest($dtC)); ?></td></tr>
        <tr><td>&nbsp;Org�o emissor:</td><td><input class="form03" name="org" value="<?php echo retRequest('org'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Obs.:</td><td><input class="form03" name="obs" value="<?php echo retRequest('obs'); ?>" type="Text"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
