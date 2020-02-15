<?php $modulotab = "tdoc"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tdoc.php" method="POST">
        <?php $w .= retRequest('doc', "AND Doc like '%", "%'"); ?>
        <td >&nbsp;Documento</td><td ><input class="form03" name="doc" value="<?php echo retRequest('doc'); ?>" type="text"></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("doc", "Documentos"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 5;
      //Executa a consulta
      $sql = "Select * from tdoc WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtdoc.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="iddoc" type="hidden" value="<?php echo $row['iddoc']; ?>">
        <input class="form03" name="doc" type="hidden" value="<?php echo $row['doc']; ?>">
        <td >&nbsp;<?php echo $row['doc']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['iddoc']; ?>" action="<?php echo $home; ?>/cad/envia_cadtdoc.php" method="POST">
        <input name="iddoc" type="hidden" value="<?php echo $row['iddoc']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['iddoc']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtdoc.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
