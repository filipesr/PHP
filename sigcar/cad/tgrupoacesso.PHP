<?php $modulotab = "tgrupoacesso"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tgrupoacesso.php" method="POST">
        <input name="grupodesc" type="hidden" value="<?php echo $_POST['grupodesc']; ?>">
        <input name="ordem" type="hidden" value="<?php echo $_POST['ordem']; ?>">
        <?php $w .= retRequest('pgrupodesc', "AND grupodesc LIKE '%", "%'"); ?>
        <td >&nbsp;Grupo</td><td ><input class="form03" name="pgrupodesc" value="<?php echo retRequest('pgrupodesc'); ?>" type="text"></td>
        <td >
          <input name="w" type="hidden" value="<?php echo $w; ?>">
          <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("grupodesc", "Grupo"); ?></td>
      <td nowrap >&nbsp;</td><td></td><td width="100%"></td>
      <?php
      $colspan = 3;
      //Executa a consulta
      $sql = "Select * from tgrupoacesso WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtgrupoacesso.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idgrupoacesso" type="hidden" value="<?php echo $row['idgrupoacesso']; ?>">
        <input class="form03" name="grupodesc" type="hidden" value="<?php echo $row['grupodesc']; ?>">
        <td  nowrap>&nbsp;<a href="javascript:detailbox('<?php echo $row['idgrupoacesso']; ?>')"><?php echo $row['grupodesc']; ?></a></td>

        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idgrupoacesso']; ?>" action="<?php echo $home; ?>/cad/envia_cadtgrupoacesso.php" method="POST">
        <input name="idgrupoacesso" type="hidden" value="<?php echo $row['idgrupoacesso']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idgrupoacesso']; ?>.submit();}" value="Excluir">
        </td><td></td></form>
    </tr>
    <tr style="display:none" id="Detail_<?php echo $row['idgrupoacesso']; ?>" >
      <td  colspan="4">
        <?php
        $sql = "select m.modulotab, m.modulodesc from tmodulo m where idmodulo in(select a.idmodulo from tacesso a where a.menu=1 and a.idgrupoacesso = " . $row['idgrupoacesso'] . ") Order by Ord";
        $res1 = sqlexec($id, $sql);
        //Exibe as linhas encontradas na consulta
        while ($row1 = mysql_fetch_array($res1)) {
          echo "<img src='" . $home . "/imagens/btns/" . $row1['modulotab'] . ".jpg' border='0'>";
        }
        ?>
      </td>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtgrupoacesso.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
