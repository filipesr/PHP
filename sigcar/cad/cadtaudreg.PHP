<?php $modulotab = "taudreg"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cadtaudreg.php" name="taudreg">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idaudreg" type="hidden" value="<?php echo retRequest('idaudreg') ?>">
        <tr><td >&nbsp;idmodulo</td><td ><input class="form03" name="idmodulo" value="<?php echo retRequest('idmodulo'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;iduser</td><td ><input class="form03" name="iduser" value="<?php echo retRequest('iduser'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;dtreg</td><td ><?php dtCalHor($modulotab, "dtdtreg", "hrdtreg", retRequest('dtreg')); ?></td></tr>
        <tr><td >&nbsp;sqlreg</td><td ><input class="form03" name="sqlreg" value="<?php echo retRequest('sqlreg'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
