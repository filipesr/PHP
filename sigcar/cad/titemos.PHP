<?php $modulotab = "titemos"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq') . $_POST['pesq'], "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idos', "AND o.idos = '", "'"); ?>
        <td >&nbsp;OS</td><td ><input class="form03" name="idos" value="<?php echo retRequest('idos'); ?>" type="text"></td>
        <?php $w .= retRequest('idservice', "AND o.idservice = '", "'"); ?>
        <td >&nbsp;Servi&ccedil;o</td><td >
          <?php selComb("idservice", retRequest('idservice'), "select idservice,CONCAT(servicedesc,' R$ ',price) as det from tservice order by det"); ?>
        </td>
        <?php $w .= retRequest('vritemos', "AND o.vrItemOS = '", "'"); ?>
        <td >&nbsp;Valor</td><td ><input class="form03" name="vritemos" value="<?php echo retRequest('vritemos'); ?>" type="text"></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>">&nbsp;<?php aTit("idos", "OS"); ?></td>
      <td>&nbsp;<?php aTit("servicedesc" . retRequest('idos', '&idos=') . retRequest('pesq', "&pesq="), "Servi&ccedil;o"); ?></td>
      <td>&nbsp;<?php aTit("vritemos" . retRequest('idos', '&idos=') . retRequest('pesq', "&pesq="), "Valor"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 7;
      //Executa a consulta
      $sql = "Select o.*, s.servicedesc from titemos o, tservice s where o.idservice = s.idservice " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtitemos.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input class="form03" name="iditemos" type="hidden" value="<?php echo $row['iditemos']; ?>">
        <input class="form03" name="idos" type="hidden" value="<?php echo $row['idos']; ?>">
        <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php echo $row['idos']; ?></td>
        <input class="form03" name="idservice" type="hidden" value="<?php echo $row['idservice']; ?>">
        <td >&nbsp;<?php echo $row['servicedesc']; ?></td>
        <input class="form03" name="vritemos" type="hidden" value="<?php echo $row['vritemos']; ?>">
        <td >&nbsp;R$ <?php echo $row['vritemos']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['iditemos']; ?>" action="<?php echo $home; ?>/cad/envia_cadtitemos.php" method="POST">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="iditemos" type="hidden" value="<?php echo $row['iditemos']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <input name="idos" type="hidden" value="<?php echo $row['idos']; ?>">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['iditemos']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr>
    <td colspan="<?php echo $colspan; ?>">
      <div align="center">
        <form action="<?php echo $home; ?>/cad/cadtitemos.php" method="POST">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="idos" type="hidden" value="<?php echo retRequest('idos'); ?>">
          <input name="oper" type="hidden" value="Inserir">
          <input class="btIns" type="submit" value="Inserir">
        </form>
      </div>
    </td>
  </tr>
</table></body></html>
