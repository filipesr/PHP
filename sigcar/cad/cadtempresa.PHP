<?php $modulotab = "tempresa"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idempresa" type="hidden" value="<?php echo retRequest('idempresa') ?>">
        <tr><td >&nbsp;empresa</td><td ><input class="form03" name="emp" value="<?php echo retRequest('emp'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Data de Validade</td><td ><?php dtCal($modulotab, "dtvalidade", retRequest('dtvalidade')); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
