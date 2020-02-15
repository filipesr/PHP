<?php $modulotab = "trent"; ?>
<?php
require("../loga.php");
$idrent = vrIF(retRequest('idrent'), "", NextAI($modulotab));
if ($idrent < 10) {
  $idrent = "0" . $idrent;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="id" type="hidden" value="<?php echo retRequest('id') ?>">
        <input name="idrent" type="hidden" value="<?php echo retRequest('idrent') ?>">
        <tr><td>&nbsp;Carro:</td><td>
            <?php selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?></td></tr>
        <tr><td>&nbsp;Cliente:</td><td><?php selComb("idclient", retRequest("idclient"), "select idclient,nome from tclient order by nome"); ?></td></tr>
        <?php $dtC = "dtdiaria"; ?>
		<?php $w .= retRequest($dtC, "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Data:</td><td><?php dtCal($modulotab, $dtC, retRequest($dtC)); ?></td>
        <tr><td>&nbsp;N�mero de diarias:</td><td><input class="form03" name="qtdediaria" value="<?php echo retRequest('qtdediaria'); ?>" type="Number"></td></tr>
        <tr><td>&nbsp;Valor:</td><td><input class="form03" name="vrdiaria" value="<?php echo retRequest('vrdiaria'); ?>" type="Number"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
