<?php $modulotab = "tos"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
          <?php $w .= retRequest('idcar', "AND o.idcar = '", "'"); ?>
          <td >&nbsp;Carro</td><td ><?php selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?></td>
        </td>
        <?php $dtC = 'dtos'; ?>
<?php if (retRequest($dtC . 'A') != NULL) {
  $w .= "AND " . $dtC . " > '" . retRequest($dtC . 'A') . "'";
} ?>
<?php if (retRequest($dtC . 'D') != NULL) {
  $w .= "AND " . $dtC . " < '" . retRequest($dtC . 'D') . "'";
} ?>
        <td  nowrap>&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("idos", "COD.os"); ?></td>
      <td>&nbsp;<?php aTit("carro", "carro"); ?></td>
      <td>&nbsp;<?php aTit("dtos", "Data"); ?></td>
      <td>&nbsp;Detalhes</td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 6;
      //Executa a consulta
      $sql = "Select o.*, CONCAT(c.marca, ' ', c.modelo, ' - placa: ', c.placa) as carro, date_format(o.dtos, '%d/%m/%Y') AS dt, (select sum(vrItemos) from titemos where idos = o.idos) as totalserv from tos o, tcar c where o.idcar = c.idcar " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtos.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idos" type="hidden" value="<?php echo $row['idos']; ?>">
        <td >&nbsp;<?php echo $row['idos']; ?></td>
        <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <td >&nbsp;<?php echo $row['carro']; ?></td>
        <input class="form03" name="dtos" type="hidden" value="<?php echo $row['dtos']; ?>">
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <td >
  <?php if ($row['totalserv'] != "") { ?>   
            <a href="javascript:detailbox('<?php echo $row['idos']; ?>')">R$ <?php echo $row['totalserv']; ?> </a>
  <?php
  }
  else {
    echo $row['totalserv'];
  }
  ?>
        </td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idos']; ?>" action="<?php echo $home; ?>/cad/envia_cadtos.php" method="POST">
        <input name="idos" type="hidden" value="<?php echo $row['idos']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idos']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <tr style="display:none" id="Detail_<?php echo $row['idos']; ?>">
      <td colspan="6">
        <table>
          <tr><td >&nbsp;</td></tr>
          <tr>
            <td style="<?php echo $TitSub ?>">&nbsp;Data</td>
            <td style="<?php echo $TitSub ?>">&nbsp;Servi�o</td>
            <td style="<?php echo $TitSub ?>">&nbsp;Valor</td>
          </tr>
  <?php
  $sql = "Select i.*, date_format(o.dtos, '%d/%m/%Y') AS data, s.servicedesc from titemos i, tos o, tservice s where i.idos = o.idos and i.idservice = s.idservice and o.idos = " . $row['idos'] . " " . $w;
  $res1 = sqlexec($id, $sql);
  //Exibe as linhas encontradas na consulta
  $ls = 0;
  while ($row1 = mysql_fetch_array($res1)) {
    $styles = $ls % 2 == 0 ? $SubPar : $SubImpar;
    $ls++;
    ?>
            <tr style="<?php echo $styles; ?>">
              <td >&nbsp;<?php echo $row1['data']; ?></td>
              <td >&nbsp;<?php echo $row1['servicedesc']; ?></td>
              <td >&nbsp;R$ <?php echo $row1['vritemos']; ?></td>
            </tr>
    <?php
  }
  ?>
          <tr>
            <td  colspan="4" bgcolor="#000000" height="1"></td>
          </tr>
          <tr>
            <td  colspan="2">&nbsp;<b>Total</b></td>
            <td >&nbsp;<b>R$ <?php echo $row['totalserv']; ?></b></td>
          </tr>
        </table>
      </td>
    </tr>
  <?php
}
?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtos.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="form03" name="idcar" type="hidden" value="<?php echo retRequest('idcar') ?>"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
