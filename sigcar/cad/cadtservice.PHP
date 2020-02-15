<?php $modulotab = "tservice"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtservice.php" name="tservice">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idservice" type="hidden" value="<?php echo retRequest('idservice') ?>">
        <tr><td >&nbsp;Servi�o</td><td ><input class="form03" name="servicedesc" value="<?php echo retRequest('servicedesc'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Pre�o Base</td><td ><input class="form03" name="price" value="<?php echo retRequest('price'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
