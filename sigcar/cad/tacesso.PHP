<?php $modulotab = "tacesso"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idgrupoacesso', "AND a.idgrupoacesso = '", "'"); ?>
        <?php $w .= retRequest('idgrupoacesso', "AND a.idgrupoacesso = '", "'"); ?>
        <td >Grupo&nbsp;
          <?php selComb("idgrupoacesso", retRequest('idgrupoacesso'), "select idgrupoacesso,grupodesc from tgrupoacesso order by grupodesc"); ?>
          <?php $w .= retRequest('idmodulo', "AND a.idmodulo = '", "'"); ?>
          &nbsp;M&oacute;dulo&nbsp;
          <?php selComb("idmodulo", retRequest('idmodulo'), "select idmodulo,modulodesc from tmodulo order by modulodesc"); ?>
          <?php $dtC = 'dtvalidade'; ?>
          <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
          <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          &nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?>
        </td><td  rowspan="2">
          <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
          &nbsp;<input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></tr><tr>
          <?php $w .= retRequest('menu', "AND a.menu = '", "'"); ?>
          <td>menu&nbsp;<?php selCombSN("menu", retRequest('menu')); ?>
            <?php $w .= retRequest('aler', "AND a.aler = '", "'"); ?>
            &nbsp;Ler&nbsp;<?php selCombSN("aler", retRequest('aler')); ?>
            <?php $w .= retRequest('ainserir', "AND a.ainserir = '", "'"); ?>
            &nbsp;Inserir&nbsp;<?php selCombSN("ainserir", retRequest('ainserir')); ?>
            <?php $w .= retRequest('aeditar', "AND a.aeditar = '", "'"); ?>
            &nbsp;Editar&nbsp;<?php selCombSN("aeditar", retRequest('aeditar')); ?>
            <?php $w .= retRequest('aapagar', "AND a.aapagar = '", "'"); ?>
            &nbsp;Apagar&nbsp;<?php selCombSN("aapagar", retRequest('aapagar')); ?>
          </td></form></tr></table>

  <table><tr>
      <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" style="<?php echo $TitItem ?>" align="center">&nbsp;<?php aTit("g.grupodesc", "Grupo"); ?></td>
      <td style="<?php echo $TitItem ?>" align="center">&nbsp;<?php aTit("m.modulodesc", "M&oacute;dulo"); ?></td>
      <td style="<?php echo $TitItem ?>" align="center">&nbsp;<?php aTit("a.dtvalidade", "Validade"); ?></td>
      <td style="<?php echo $TitItem ?>" align="center">&nbsp;<?php aTit("a.menu", "menu"); ?></td>
      <td style="<?php echo $TitItem ?>" colspan="4" align="center">&nbsp;Acesso</td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 11;
//Executa a consulta
      $sql = "Select a.*, m.modulodesc, g.grupodesc, date_format(a.dtvalidade, '%d/%m/%Y') AS dt from tacesso a, tmodulo m, tgrupoacesso g where a.idmodulo = m.idmodulo and a.idgrupoacesso = g.idgrupoacesso " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtacesso.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input class="form03" name="idacesso" type="hidden" value="<?php echo $row['idacesso']; ?>">
        <input class="form03" name="idgrupoacesso" type="hidden" value="<?php echo $row['idgrupoacesso']; ?>">
        <td style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>" >&nbsp;<?php echo $row['grupodesc']; ?></td>
        <input class="form03" name="idmodulo" type="hidden" value="<?php echo $row['idmodulo']; ?>">
        <input class="form03" name="modulodesc" type="hidden" value="<?php echo $row['modulodesc']; ?>">
        <td >&nbsp;<?php echo $row['modulodesc']; ?></td>
        <input class="form03" name="dtvalidade" type="hidden" value="<?php echo $row['dtvalidade']; ?>">
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <input class="form03" name="menu" type="hidden" value="<?php echo $row['menu']; ?>">
        <td >&nbsp;<?php echo ($row['menu'] == 1) ? "Mostrar" : ""; ?></td>
        <input class="form03" name="aler" type="hidden" value="<?php echo $row['aler']; ?>">
        <td >&nbsp;<?php echo ($row['aler'] == 1) ? "Ler" : ""; ?></td>
        <input class="form03" name="ainserir" type="hidden" value="<?php echo $row['ainserir']; ?>">
        <td >&nbsp;<?php echo ($row['ainserir'] == 1) ? "Inserir" : ""; ?></td>
        <input class="form03" name="aeditar" type="hidden" value="<?php echo $row['aeditar']; ?>">
        <td >&nbsp;<?php echo ($row['aeditar'] == 1) ? "Editar" : ""; ?></td>
        <input class="form03" name="aapagar" type="hidden" value="<?php echo $row['aapagar']; ?>">
        <td >&nbsp;<?php echo ($row['aapagar'] == 1) ? "Apagar" : ""; ?></td>
        <td  nowrap>&nbsp;<input class="btEdt" type="submit" value="Editar"></td></form>

      <form name="Exc<?php echo $row['idacesso']; ?>" action="<?php echo $home; ?>/cad/envia_cadtacesso.php" method="POST">
        <input name="idacesso" type="hidden" value="<?php echo $row['idacesso']; ?>">
        <input name="idgrupoacesso" type="hidden" value="<?php echo $row['idgrupoacesso']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idacesso']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center">
        <form action="<?php echo $home; ?>/cad/cadtacesso.php" method="POST">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="oper" type="hidden" value="Inserir">
          <input name="idgrupoacesso" type="hidden" value="<?php echo $_GET['idgrupoacesso']; ?>">
          <input class="btIns" type="submit" value="Inserir">
        </form></div></td></tr>
</table></body></html>
