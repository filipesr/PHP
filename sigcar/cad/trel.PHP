<?php $modulotab = "trel"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <form action="<?php echo $home; ?>/cad/trel.php" method="POST" name="trel">
          <?php $w .= retRequest('reltit', "AND reltit LIKE '%", "%'"); ?>
          <td>&nbsp;reltit</td><td><input class="form03" name="reltit" value="<?php echo retRequest('reltit'); ?>" type="Text"></td>
          <?php $w .= retRequest('idrelcab', "AND idrelcab = '", "'"); ?>
          <td>&nbsp;idrelcab</td><td><?php selComb("idrelcab", retRequest("idrelcab"), "select idrelcab,reltit from trel order by reltit"); ?></td>
          <?php $w .= retRequest('reltab', "AND reltab LIKE '%", "%'"); ?>
          <td>&nbsp;reltab</td><td><input class="form03" name="reltab" value="<?php echo retRequest('reltab'); ?>" type="Text"></td>
          <?php $w .= retRequest('relwhere', "AND relwhere LIKE '%", "%'"); ?>
          <td>&nbsp;relwhere</td><td><input class="form03" name="relwhere" value="<?php echo retRequest('relwhere'); ?>" type="Text"></td>
          <td><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

    <table><tr style="<?php echo $TitItem ?>">
        <td><?php aTit("idrel", "ID") ?></td>
        <td><?php aTit("reltit", "T&iacute;tulo") ?></td>
        <td><?php aTit("idrelcab", "Cabe&ccedil;alho") ?></td>
        <td><?php aTit("reltab", "Tabela") ?></td>
        <td><?php aTit("relwhere", "Condi&ccedil;&atilde;o") ?></td>
        <td nowrap>&nbsp;</td>
        <?php
        $colspan = 8;
        //Executa a consulta
        $sql = "Select * from trel WHERE 1=1 " . $w;
        $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
        //Exibe as linhas encontradas na consulta
        $l = 0;
        while ($row = mysql_fetch_array($res)) {
          $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
          $l++;
          ?>
        <tr style="<?php echo $style; ?>">
        <form action="<?php echo $home; ?>/cad/cadtrel.php" method="POST" name="trel">
          <input name="oper" type="hidden" value="Editar">
          <input class="form03" name="idrel" type="hidden" value="<?php echo $row['idrel']; ?>">
          <td>&nbsp;<?php echo $row['idrel']; ?></td>
          <input class="form03" name="reltit" type="hidden" value="<?php echo $row['reltit']; ?>">
          <td>&nbsp;<?php echo $row['reltit']; ?></td>
          <input class="form03" name="idrelcab" type="hidden" value="<?php echo $row['idrelcab']; ?>">
          <td>&nbsp;<?php echo $row['idrelcab']; ?></td>
          <input class="form03" name="reltab" type="hidden" value="<?php echo $row['reltab']; ?>">
          <td>&nbsp;<?php echo $row['reltab']; ?></td>
          <input class="form03" name="relwhere" type="hidden" value="<?php echo $row['relwhere']; ?>">
          <td>&nbsp;<?php echo $row['relwhere']; ?></td>
          <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td></form>
        <form name="Exc<?php echo $row['idrel']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
          <input name="idrel" type="hidden" value="<?php echo $row['idrel']; ?>">
          <input name="idrelcab" type="hidden" value="<?php echo $row['idrelcab']; ?>">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="oper" type="hidden" value="Apagar">
          <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idrel']; ?>.submit();}" value="Excluir">
          </td></form>
      </tr>
  <?php
}
?>
    <tr>
      <td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center">
          <form action="<?php echo $home; ?>/cad/cad<?php echo $modulotab ?>.php" method="POST">
            <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
            <input name="oper" type="hidden" value="Inserir">
            <input name="idrelcab" type="hidden" value="<?php echo retRequest('idrelcab'); ?>">
            <input class="btIns" type="submit" value="Inserir">
          </form></div>
      </td>
    </tr>
  </table></body></html>
