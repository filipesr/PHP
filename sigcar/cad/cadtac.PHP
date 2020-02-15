<?php $modulotab = "tac"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cadtac.php" name="tac">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idac" type="hidden" value="<?php echo retRequest('idac') ?>">
        <tr><td>&nbsp;descri�ao</td><td><input class="form03" name="acdesc" value="<?php echo retRequest('acdesc'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Abrevia��o</td><td><input class="form03" name="acabrev" value="<?php echo retRequest('acabrev'); ?>" type="Text"></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
