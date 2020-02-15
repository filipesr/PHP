<?php $modulotab = "tdoc"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtdoc.php" name="tdoc">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="iddoc" type="hidden" value="<?php echo retRequest('iddoc') ?>">
        <tr><td >&nbsp;Documento</td><td ><input class="form03" name="doc" value="<?php echo retRequest('doc'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
