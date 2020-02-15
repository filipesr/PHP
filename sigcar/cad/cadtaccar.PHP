<?php $modulotab = "taccar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table> 
      <form method="POST" action="envia_cadtaccar.php" name="taccar">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="idaccar" type="hidden" value="<?php echo retRequest('idaccar') ?>">
        <?php if (retRequest('idcar') != "") { ?>
          <input name="idcar" value="<?php echo retRequest('idcar') ?>" type="hidden">
          <?php
        }
        if (retRequest('pesq') == "") {
          ?>
          <tr><td >&nbsp;Carro</td><td >
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
        <td>&nbsp;Acess�rio</td><td><?php selComb("idac", retRequest("idac"), "select idac,acdesc from tac order by acdesc"); ?></td>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
