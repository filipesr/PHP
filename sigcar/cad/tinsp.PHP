<?php $modulotab = "tinsp"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <form action="<?php echo $home; ?>/cad/<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
          <?php $w .= retRequest('inspdesc', "AND inspdesc LIKE '%", "%'"); ?>
          <td>&nbsp;inspdesc</td><td><input class="form03" name="inspdesc" value="<?php echo retRequest('inspdesc'); ?>" type="Text"></td>
          <td>
            <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
            <input class="btPesq" name="Limpar" value="Limpar" type="reset">
            <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif">
          </td></form></tr></table>

    <table><tr style="<?php echo $TitItem ?>">
        <td><?php aTit("idInsp", "idInsp") ?></td>
        <td><?php aTit("inspdesc", "inspdesc") ?></td>
        <td nowrap>&nbsp;</td>
        <?php
        $colspan = 5;
        //Executa a consulta
        $sql = "Select * from $modulotab WHERE 1=1 " . $w;
        $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
        //Exibe as linhas encontradas na consulta
        $l = 0;
        while ($row = mysql_fetch_array($res)) {
          $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
          $l++;
          ?>
        <tr style="<?php echo $style; ?>">
        <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
          <input name="oper" type="hidden" value="Editar">
          <input class="form03" name="idinsp" type="hidden" value="<?php echo $row['idinsp']; ?>">
          <td>&nbsp;<?php echo $row['idinsp']; ?></td>
          <input class="form03" name="inspdesc" type="hidden" value="<?php echo $row['inspdesc']; ?>">
          <td>&nbsp;<?php echo $row['inspdesc']; ?></td>
          <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td></form>
        <form name="Exc<?php echo $row['idinsp']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
          <input name="idinsp" type="hidden" value="<?php echo $row['idinsp']; ?>">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
          <input name="oper" type="hidden" value="Apagar">
          <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idinsp']; ?>.submit();}" value="Excluir">
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
