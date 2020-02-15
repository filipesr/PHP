<?php $modulotab = "taud"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idmodulo', "AND a.idmodulo = '", "'"); ?>
        <td >&nbsp;M&oacute;dulo</td><td >
          <?php selComb("idmodulo", retRequest('idmodulo'), "select idmodulo,modulodesc from tmodulo order by modulodesc"); ?>
        </td>
        <?php $dtC = 'dtaud'; ?>
        <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
        <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td  nowrap>&nbsp;Ativa&ccedil;&atilde;o entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
        <?php $w .= retRequest('aler', "AND a.aler = '", "'"); ?>
        <td >Ler</td><td ><?php selCombSN("aler", retRequest('aler')); ?></td>
        <?php $w .= retRequest('ainserir', "AND a.ainserir = '", "'"); ?>
        <td >Inserir</td><td ><?php selCombSN("ainserir", retRequest('ainserir')); ?></td>
        <?php $w .= retRequest('aeditar', "AND a.aeditar = '", "'"); ?>
        <td >Editar</td><td ><?php selCombSN("aeditar", retRequest('aeditar')); ?></td>
        <?php $w .= retRequest('aapagar', "AND a.aapagar = '", "'"); ?>
        <td >Apagar</td><td ><?php selCombSN("aapagar", retRequest('aapagar')); ?></td>
        <?php $w .= retRequest('active', "AND active = '", "'"); ?>
        <td >Ativo</td><td ><?php selCombSN("active", retRequest('active')); ?></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td><?php aTit("modulodesc", "M&oacute;dulo"); ?></td>
      <td><?php aTit("dtaud", "Ativa&ccedil;&atilde;o"); ?></td>
      <td style="<?php echo $TitItem ?>" colspan="4">Registrar</td>
      <td><?php aTit("active", "Ativo"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 11;
//Executa a consulta
      $sql = "Select * from taud WHERE 1=1 " . $w;
      $sql = "Select a.*, m.modulodesc, date_format(a.dtaud, '%d/%m/%Y %T') AS dt from taud a, tmodulo m where a.idmodulo = m.idmodulo " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtaud.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idmodulo" type="hidden" value="<?php echo $row['idmodulo']; ?>">
        <input class="form03" name="idaud" type="hidden" value="<?php echo $row['idaud']; ?>">
        <td >&nbsp;<?php echo $row['modulodesc']; ?></td>
        <input class="form03" name="dt" type="hidden" value="<?php echo $row['dt']; ?>">
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <input class="form03" name="aler" type="hidden" value="<?php echo $row['aler']; ?>">
        <td >&nbsp;<?php echo ($row['aler'] == 1) ? "Ler" : ""; ?></td><td>
          <input class="form03" name="ainserir" type="hidden" value="<?php echo $row['ainserir']; ?>">
          &nbsp;<?php echo ($row['ainserir'] == 1) ? "Inserir" : ""; ?></td><td>
          <input class="form03" name="aeditar" type="hidden" value="<?php echo $row['aeditar']; ?>">
          &nbsp;<?php echo ($row['aeditar'] == 1) ? "Editar" : ""; ?></td><td>
          <input class="form03" name="aapagar" type="hidden" value="<?php echo $row['aapagar']; ?>">
          &nbsp;<?php echo ($row['aapagar'] == 1) ? "Apagar" : ""; ?></td>
        <input class="form03" name="active" type="hidden" value="<?php echo $row['active']; ?>">
        <td >&nbsp;<?php echo ($row['active'] == 1) ? "Sim" : ""; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idaud']; ?>" action="<?php echo $home; ?>/cad/envia_cadtaud.php" method="POST">
        <input name="idaud" type="hidden" value="<?php echo $row['idaud']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idaud']; ?>.submit();}" value="Desativar">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtaud.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
