<?php $modulotab = "tinsprent"; ?>
<?php
require("../loga.php");
$idinsprent = vrIF(retRequest('idinsprent'), "", NextAI($modulotab));
if ($idinsprent < 10) {
  $idinsprent = "0" . $idinsprent;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="id" type="hidden" value="<?php echo retRequest('id') ?>">
        <input name="idinsprent" type="hidden" value="<?php echo retRequest('idinsprent') ?>">
        <tr><td>&nbsp;inspetor:</td><td><input class="form03" name="inspetor" value="<?php echo retRequest('inspetor'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Aluguel:</td><td>
            <?php selComb("idrent", retRequest("idrent"), "select idrent,(CONCAT(ca.modelo,' - ', ca.placa, ' para ', c.nome, ' em ', date_format(r.dtdiaria, '%d/%m/%Y'))) as alug from trent r, tclient c, tcar ca where r.idclient = c.idclient AND r.idcar = ca.idcar AND r.idrent not in (select idrent from tinsprent) order by r.dtdiaria"); ?>
          </td></tr>
        <?php $dtC = "dtinsprent"; ?>
		<?php  $w .= retRequest($dtC, "AND " . $dtC . " < '", "'"); ?>
        <td nowrap>&nbsp;Data:</td><td><?php dtCal($modulotab, $dtC, retRequest($dtC)); ?></td>
        <tr><td>&nbsp;descri��o:</td><td><input class="form03" name="inspdesc" value="<?php echo retRequest('inspdesc'); ?>" type="Text"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
