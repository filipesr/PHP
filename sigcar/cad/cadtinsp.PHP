<?php $modulotab = "tinsp"; ?>
<?php
require("../loga.php");
$idinsp = vrIF(retRequest('idinsp'), "", NextAI($modulotab));
if ($idinsp < 10) {
  $idinsp = "0" . $idinsp;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="id" type="hidden" value="<?php echo retRequest('id') ?>">
        <input name="idinsp" type="hidden" value="<?php echo retRequest('idinsp') ?>">
        <tr><td>&nbsp;inspdesc</td><td><input class="form03" name="inspdesc" value="<?php echo retRequest('inspdesc'); ?>" type="Text"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
