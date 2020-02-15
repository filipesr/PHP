<?php $modulotab = "trelfunc"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <form action="<?php echo $home; ?>/cad/trelfunc.php" method="POST" name="trelfunc">
          <?php $w .= retRequest('funcdesc', "AND funcdesc LIKE '%", "%'"); ?>
          <td>&nbsp;funcdesc</td><td><input class="form03" name="funcdesc" value="<?php echo retRequest('funcdesc'); ?>" type="Text"></td>
          <?php $w .= retRequest('funcpre', "AND funcpre LIKE '%", "%'") ?>
          <td>&nbsp;funcpre</td><td><input class="form03" name="funcpre" value="<?php echo retRequest('funcpre'); ?>" type="Text"></td>
<?php $w .= retRequest('funcpos', "AND funcpos LIKE '%", "%'"); ?>
          <td>&nbsp;funcpos</td><td><input class="form03" name="funcpos" value="<?php echo retRequest('funcpos'); ?>" type="Text"></td>
          <td><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

    <table><tr style="<?php echo $TitItem ?>">
        <td><?php aTit("idrelfunc", "idrelfunc") ?></td>
        <td><?php aTit("funcdesc", "funcdesc") ?></td>
        <td><?php aTit("funcpre", "funcpre") ?></td>
        <td><?php aTit("funcpos", "funcpos") ?></td>
        <td nowrap>&nbsp;</td>
        <?php
        $colspan = 7;
        //Executa a consulta
        $sql = "Select * from trelfunc WHERE 1=1 " . $w;
        $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
        //Exibe as linhas encontradas na consulta
        $l = 0;
        while ($row = mysql_fetch_array($res)) {
          $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
          $l++;
          ?>
        <tr style="<?php echo $style; ?>">
        <form action="<?php echo $home; ?>/cad/cadtrelfunc.php" method="POST" name="trelfunc">
          <input name="oper" type="hidden" value="Editar">
          <input class="form03" name="idrelfunc" type="hidden" value="<?php echo $row['idrelfunc']; ?>">
          <td>&nbsp;<?php echo $row['idrelfunc']; ?></td>
          <input class="form03" name="funcdesc" type="hidden" value="<?php echo $row['funcdesc']; ?>">
          <td>&nbsp;<?php echo $row['funcdesc']; ?></td>
          <input class="form03" name="funcpre" type="hidden" value="<?php echo $row['funcpre']; ?>">
          <td>&nbsp;<?php echo $row['funcpre']; ?></td>
          <input class="form03" name="funcpos" type="hidden" value="<?php echo $row['funcpos']; ?>">
          <td>&nbsp;<?php echo $row['funcpos']; ?></td>
          <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td></form>
        <form name="Exc<?php echo $row['idrelfunc']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
          <input name="idrelfunc" type="hidden" value="<?php echo $row['idrelfunc']; ?>">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
          <input name="oper" type="hidden" value="Apagar">
          <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idrelfunc']; ?>.submit();}" value="Excluir">
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
