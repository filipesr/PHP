<?php $modulotab = "trelfunc"; ?>
<?php
require("../loga.php");
$idrelfunc = vrIF(retRequest('idrelfunc'), "", NextAI('trelfunc'));
if ($idrelfunc < 10) {
  $idrelfunc = "0" . $idrelfunc;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="idrelfunc" type="hidden" value="<?php echo retRequest('idrelfunc') ?>">
        <tr><td>&nbsp;Descricao</td><td><input class="form03" name="funcdesc" value="<?php echo retRequest('funcdesc'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Prefixo</td><td><input class="form03" name="duncpre" value="<?php echo retRequest('funcpre'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Posfixo</td><td><input class="form03" name="funcpos" value="<?php echo retRequest('funcpos'); ?>" type="Text"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
