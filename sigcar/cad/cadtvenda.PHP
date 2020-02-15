<?php $modulotab = "tvenda"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idvenda" type="hidden" value="<?php echo retRequest('idvenda') ?>">
        <tr><td >&nbsp;carro</td><td >
            <?php
            $sqlcar = "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar ";
            if ($oper == "Inserir") {
              $sqlcar .= "where idcar in (select idcar from tcompra) AND idcar NOT in (select idcar from tvenda) ";
            };
            selComb("idcar", retRequest('idcar'), $sqlcar . "order by carro");
            ?></td></tr>
        <tr><td >&nbsp;Data de Venda</td><td >&nbsp;&nbsp;
            <?php
            if ($oper != "Editar") {
              dtCal($modulotab, "dtvenda", retRequest("dtvenda"));
            }
            else {
              echo retRequest("dtvenda");
            };
            ?></td></tr>
        <tr><td >&nbsp;Valor de Venda</td><td >&nbsp;&nbsp;<?php if ($oper != "Editar") { ?><input class="form03" name="vrvenda" type="text"><?php
            }
            else {
              echo "R$ " . retRequest('vrvenda');
            };
            ?></td></tr>
        <tr><td >&nbsp;Comprador</td><td >&nbsp;
            <?php selComb("idclient", retRequest('idclient'), "select idclient,nome from tclient Order by nome"); ?></td></tr>
        <tr><td >&nbsp;Vendedor</td><td >&nbsp;
            <?php selComb("idvendor", retRequest('idvendor'), "select idvendor,vendordesc from tvendor Order by vendordesc"); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
