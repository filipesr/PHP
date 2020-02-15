<?php $modulotab = "trent"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <form action="<?php echo $home; ?>/cad/<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
          <?php $w .= retRequest('vrdiaria', "AND vrdiaria = '", "'"); ?>
            <?php $w .= retRequest('idcar', "AND idcar = '", "'"); ?>
          <td>&nbsp;carro</td><td>
          <?php selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?></td>
          <?php $w .= retRequest('idclient', "AND idclient = '", "'"); ?>
          <td>&nbsp;Cliente</td><td><?php selComb("idclient", retRequest("idclient"), "select idclient,nome from tclient order by Nome"); ?></td>
          <td>&nbsp;Valor</td><td><input class="form03" name="vrdiaria" value="<?php echo retRequest('vrdiaria'); ?>" type="Number"></td>
<?php $w .= retRequest('dtdiaria', "AND dtdiaria = '", "'"); ?>
<?php $dtC = "dtdiaria"; ?>
<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          <td nowrap>&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td></td>
<?php $w .= retRequest('qtdediaria', "AND qtdeDiaria = '", "'"); ?>
          <td>&nbsp;No. Diarias</td><td><input class="form03" name="qtdediaria" value="<?php echo retRequest('qtdediaria'); ?>" type="Number"></td>
          <td nowrap>
            <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
            <input class="btPesq" name="Limpar" value="Limpar" type="reset">
            <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif">
          </td></form></tr></table>

    <table><tr style="<?php echo $TitItem ?>">
        <td><?php aTit("carro", "carro") ?></td>
        <td><?php aTit("nome", "Cliente") ?></td>
        <td><?php aTit("dtdiaria", "Data") ?></td>
        <td><?php aTit("vrdiaria", "Valor da Di�ria") ?></td>
        <td><?php aTit("qtdeDiaria", "No. Diarias") ?></td>
        <td><strong>Total</strong></td>
        <td nowrap>&nbsp;</td>
<?php
$colspan = 9;
//Executa a consulta
$sql = "Select r.*, CONCAT(ca.marca, ' | ', ca.modelo, ' - placa: ', ca.placa) as carro, c.Nome from trent r, tcar ca, tclient c WHERE r.idcar = ca.idcar AND r.idclient = c.idclient " . $w;
$res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
$l = 0;
while ($row = mysql_fetch_array($res)) {
  $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
  $l++;
  ?>
        <tr style="<?php echo $style; ?>">
        <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
          <input name="oper" type="hidden" value="Editar">
          <input class="form03" name="idRent" type="hidden" value="<?php echo $row['idrent']; ?>">
          <input class="form03" name="vrdiaria" type="hidden" value="<?php echo $row['vrdiaria']; ?>">
          <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
          <td>&nbsp;<?php echo $row['carro']; ?></td>
          <input class="form03" name="idclient" type="hidden" value="<?php echo $row['idclient']; ?>">
          <td>&nbsp;<?php echo $row['nome']; ?></td>
          <input class="form03" name="dtdiaria" type="hidden" value="<?php echo $row['dtdiaria']; ?>">
          <td>&nbsp;<?php echo $row['dtdiaria']; ?></td>
          <td>&nbsp;R$ <?php echo $row['vrdiaria']; ?></td>
          <input class="form03" name="qtdeDiaria" type="hidden" value="<?php echo $row['qtdediaria']; ?>">
          <td>&nbsp;<?php echo $row['qtdediaria']; ?></td>
          <td>&nbsp;R$ <?php echo $row['vrdiaria'] * $row['qtdediaria']; ?></td>
          <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td></form>
        <form name="Exc<?php echo $row['idrent']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
          <input name="idRent" type="hidden" value="<?php echo $row['idrent']; ?>">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
          <input name="oper" type="hidden" value="Apagar">
          <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idrent']; ?>.submit();}" value="Excluir">
          </td></form>
      </tr>
  <?php
}
?>
    <tr>
      <td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center">
          <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab ?>.php" method="POST">
            <input name="oper" type="hidden" value="Inserir">
            <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
            <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
            <input class="btIns" type="submit" value="Inserir">
          </form></div>
      </td>
    </tr>
  </table></body></html>
