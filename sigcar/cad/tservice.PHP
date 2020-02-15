<?php $modulotab = "tservice"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tservice.php" method="POST">
        <?php $w .= retRequest('servicedesc', "AND servicedesc LIKE '%", "%'"); ?>
        <td >&nbsp;Servi&ccedil;o</td><td ><input class="form03" name="servicedesc" value="<?php echo retRequest('servicedesc'); ?>" type="text"></td>
<?php $w .= retRequest('price', "AND price = '", "'"); ?>
        <td >&nbsp;Pre&ccedil;o</td><td ><input class="form03" name="price" value="<?php echo retRequest('price'); ?>" type="text"></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("servicedesc", "Servi&ccedil;o"); ?></td>
      <td>&nbsp;<?php aTit("price", "Pre&ccedil;o"); ?></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 6;
      //Executa a consulta
      $sql = "Select * from tservice WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtservice.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idservice" type="hidden" value="<?php echo $row['idservice']; ?>">
        <input class="form03" name="servicedesc" type="hidden" value="<?php echo $row['servicedesc']; ?>">
        <td >&nbsp;<?php echo $row['servicedesc']; ?></td>
        <input class="form03" name="price" type="hidden" value="<?php echo $row['price']; ?>">
        <td >R$&nbsp;<?php echo $row['price']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idservice']; ?>" action="<?php echo $home; ?>/cad/envia_cadtservice.php" method="POST">
        <input name="idservice" type="hidden" value="<?php echo $row['idservice']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idservice']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
  <?php
}
?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtservice.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
