<?php $modulotab = "tmodulo"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tmodulo.php" method="POST">
        <?php $w .= retRequest('modulotab', "AND modulotab LIKE '%", "%'"); ?>
        <td >&nbsp;Tabela</td><td ><input class="form03" name="modulotab" value="<?php echo retRequest('modulotab'); ?>" type="text"></td>
        <?php $w .= retRequest('modulodesc', "AND modulodesc LIKE '%", "%'"); ?>
        <td >&nbsp;Modulo</td><td ><input class="form03" name="modulodesc" value="<?php echo retRequest('modulodesc'); ?>" type="text"></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("modulotab", "Tabela"); ?></td>
      <td>&nbsp;<?php aTit("modulodesc", "Modulo"); ?></td>
      <td>&nbsp;Imagem</td>
      <td>&nbsp;<?php aTit("ord", "Ordem"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 12;
      //Executa a consulta
      $sql = "Select * from tmodulo WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . vrIF(retRequest('ordem') . " " . retRequest('desc'), "", " order by ord"));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtmodulo.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idmodulo" type="hidden" value="<?php echo $row['idmodulo']; ?>">
        <input class="form03" name="modulotab" type="hidden" value="<?php echo $row['modulotab']; ?>">
        <input class="form03" name="ord" type="hidden" value="<?php echo $row['ord']; ?>">
        <td >&nbsp;<?php echo $row['modulotab']; ?></td>
        <input class="form03" name="modulodesc" type="hidden" value="<?php echo $row['modulodesc']; ?>">
        <td  onMouseOver="javascript:detailbox(<?php echo $row['idmodulo']; ?>)" onMouseOut="javascript:detailbox(<?php echo $row['idmodulo']; ?>)">&nbsp;<?php echo $row['modulodesc']; ?></td>
        <td >&nbsp;<img id="Detail_<?php echo $row['idmodulo']; ?>" style="display:none" src="../imagens/btns/<?php echo $row['modulotab']; ?>.jpg"></td>
        <td >&nbsp;<?php echo $row['ord']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idmodulo']; ?>" action="<?php echo $home; ?>/cad/envia_cadtmodulo.php" method="POST">
        <input name="idmodulo" type="hidden" value="<?php echo $row['idmodulo']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idmodulo']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
  <?php
}
?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtmodulo.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
