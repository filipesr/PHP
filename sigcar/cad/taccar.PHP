<?php $modulotab = "taccar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idac', "AND ac.idac = '", "'"); ?>
        <td>&nbsp;Acess&oacute;rio</td><td><?php selComb("idac", retRequest("idac"), "select idac,acdesc from tac order by acdesc"); ?></td>
        <?php $w .= retRequest('idcar', "AND c.idcar = '", "'"); ?>
        <?php $w .= retRequest('idcar', "AND c.idcar = '", "'"); ?>
        <td >&nbsp;carro</td><td >
          <?php selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(IFNULL(marca, ''), ' | ', IFNULL(modelo, ''), ' - placa: ', IFNULL(placa, '')) as carro from tcar order by carro"); ?>
        </td>
        <td><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php aTit("carro", "carro"); ?></td>
      <td>&nbsp;<?php aTit("acdesc" . retRequest('idac', '&idac=') . retRequest('pesq', '&pesq='), "Acess&oacute;rio") ?></td>
      <td nowrap>&nbsp;</td>
      <?php
      $colspan = 6;
      //Executa a consulta
      $sql = "Select acdesc, CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro, c.idcar from taccar ac, tcar c, tac a WHERE ac.idac = a.idac AND ac.idcar = c.idcar " . $w;
      //echo($sql);
      $res = sqlexec($id, $sql . retRequest('ordem'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtaccar.php" method="POST" name="taccar">
        <input name="oper" type="hidden" value="Editar">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input name="idaccar" type="hidden" value="<?php echo $row['idaccar']; ?>">
        <input name="idac" type="hidden" value="<?php echo $row['idac']; ?>">
        <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php echo $row['carro']; ?></td>
        <td>&nbsp;<?php echo $row['acdesc']; ?></td>
        <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idaccar']; ?>" action="<?php echo $home; ?>/cad/envia_cadtaccar.php" method="POST">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="idaccar" type="hidden" value="<?php echo $row['idaccar']; ?>">
        <input name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idaccar']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr>
    <td colspan="<?php echo $colspan; ?>">&nbsp;
      <div align="center">
        <form action="<?php echo $home; ?>/cad/cadtaccar.php" method="POST">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="idcar" type="hidden" value="<?php echo retRequest('idcar'); ?>">
          <input name="oper" type="hidden" value="Inserir">
          <input class="btIns" type="submit" value="Inserir">
        </form>
      </div>
    </td>
  </tr>
</table></body></html>
