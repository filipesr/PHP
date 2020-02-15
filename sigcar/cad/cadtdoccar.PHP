<?php $modulotab = "tdoccar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="iddoccar" type="hidden" value="<?php echo retRequest('iddoccar') ?>">
        <?php if (retRequest('idcar') != "") { ?>
          <input name="idcar" value="<?php echo retRequest('idcar') ?>" type="hidden">
          <?php
        }
        if (retRequest('pesq') == "") {
          ?>
          <tr><td >&nbsp;carro</td><td >
              <?php
              if (retRequest('oper') == "Inserir") {
                selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro");
              }
              else {
                echo RetVar("select CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar where idcar = " . retRequest('idcar'));
              }
              ?>
            </td></tr>
        <?php }
        ?>
        <tr><td >&nbsp;documento</td><td >
            <?php selComb("iddoc", retRequest('iddoc'), "select iddoc,doc from tdoc order by doc"); ?></td></tr>
        <tr><td >&nbsp;Data</td><td ><?php dtCal($modulotab, "dtdoccar", retRequest('dtdoccar')); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
