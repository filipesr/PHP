<?php $modulotab = "tcar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idcar" type="hidden" value="<?php echo retRequest('idcar') ?>">
        <tr><td >&nbsp;Marca</td><td >&nbsp;<input class="form03" name="marca" value="<?php echo retRequest('marca'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Modelo</td><td >&nbsp;<input class="form03" name="modelo" value="<?php echo retRequest('modelo'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Fabricada</td><td >&nbsp;<input class="form03" name="ano_fab" value="<?php echo retRequest('ano_fab'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Modelo do ano</td><td >&nbsp;<input class="form03" name="ano_mod" value="<?php echo retRequest('ano_mod'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Chassi</td><td >&nbsp;<input class="form03" name="chassi" value="<?php echo retRequest('chassi'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Cor</td><td >&nbsp;<input class="form03" name="cor" value="<?php echo retRequest('cor'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Portas</td><td >&nbsp;<input class="form03" name="portas" value="<?php echo retRequest('portas'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Placa</td><td >&nbsp;<input class="form03" name="placa" value="<?php echo retRequest('placa'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Data de Compra</td><td >&nbsp;<?php dtCal($modulotab, "dtcompra", retRequest("dtcompra")); ?></td></tr>
        <tr><td >&nbsp;Valor de Compra</td><td >&nbsp;<input class="form03" name="vrcompra" value="<?php echo retRequest('vrcompra'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Data de Venda</td><td >&nbsp;<?php dtCal($modulotab, "dtvenda", retRequest("dtvenda")); ?></td></tr>
        <tr><td >&nbsp;Valor de Venda</td><td >&nbsp;<input class="form03" name="vrvenda" value="<?php echo retRequest('vrvenda'); ?>" type="Number"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
