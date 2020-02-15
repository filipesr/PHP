<?php $modulotab = "tmodulo"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cadtmodulo.php" name="tmodulo">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idmodulo" type="hidden" value="<?php echo retRequest('idmodulo') ?>">
        <tr><td >&nbsp;Tabela</td><td ><input class="form03" name="modulotab" value="<?php echo retRequest('modulotab'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Modulo</td><td ><input class="form03" name="modulodesc" value="<?php echo retRequest('modulodesc'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Ordem</td><td ><input class="form03" name="ord" value="<?php echo retRequest('ord'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
