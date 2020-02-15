<?php $modulotab = "tcompra"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idcompra" type="hidden" value="<?php echo retRequest('idcompra') ?>">
        <tr><td >&nbsp;Cliente</td><td >
            <?php selComb("idclient", retRequest('idclient'), "select idclient,nome from tclient Order by nome"); ?></td></tr>
        <tr><td >&nbsp;Carro</td><td >
            <?php
            $sqlCar = "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar ";
            if ($oper == "Inserir") {
              $sqlCar .= "where idcar not in (select idcar from tcompra) ";
            };
            selComb("idcar", retRequest('idcar'), $sqlCar . "order by marca");
            ?></td></tr>
        <tr><td >&nbsp;Data</td><td ><?php dtCal($modulotab, "dtcompra", retRequest('dtcompra')); ?></td></tr>
        <tr><td >&nbsp;Valor</td><td ><input class="form03" name="vrcompra" value="<?php echo retRequest('vrcompra'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
