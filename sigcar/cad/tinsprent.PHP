<?php $modulotab = "tinsprent"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <form action="<?php echo $home; ?>/cad/<?php echo $modulotab; ?>.php" method="POST" name="<?php echo $modulotab; ?>">
          <?php $w .= retRequest('inspetor', "AND inspetor LIKE '%", "%'"); ?>
          <td>&nbsp;inspetor</td><td><input class="form03" name="inspetor" value="<?php echo retRequest('inspetor'); ?>" type="Text"></td>
          <?php $w .= retRequest('idrent', "AND idrent = '", "'"); ?>
          <td>&nbsp;Aluguel</td><td>
            <?php selComb("idrent", retRequest("idrent"), "select idrent,(CONCAT(ca.modelo,' - ', ca.placa, ' para ', c.Nome, ' em ', date_format(r.dtdiaria, '%d/%m/%Y'))) as alug from trent r, tclient c, tcar ca where r.idclient = c.idclient AND r.idcar = ca.idcar AND r.idrent in (select idrent from tinsprent) order by r.dtdiaria"); ?>
          </td>
          <?php $w .= retRequest('dtinsprent', "AND dtinsprent = '", "'"); ?>
          <?php $dtC = "dtinsprent"; ?>
		  <?php $w .= retRequest("$dtC . 'A', AND " . $dtC . " > '", "'"); ?>
		  <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
          <td nowrap>&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td></td>
          <?php $w .= retRequest('inspdesc', "AND inspdesc LIKE '%", "%'"); ?>
          <td>&nbsp;Descri��o</td><td><input class="form03" name="inspdesc" value="<?php echo retRequest('inspdesc'); ?>" type="Text"></td>
          <td nowrap>
            <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
            <input class="btPesq" name="Limpar" value="Limpar" type="reset">
            <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif">
          </td></form></tr></table>

    <table><tr style="<?php echo $TitItem ?>">
        <td><?php aTit("inspetor", "inspetor") ?></td>
        <td><?php aTit("idrent", "Aluguel") ?></td>
        <td><?php aTit("dtinsprent", "Data") ?></td>
        <td><?php aTit("inspdesc", "Descri��o") ?></td>
        <td nowrap>&nbsp;</td>
        <?php
        $colspan = 8;
//Executa a consulta
        $sql = "Select i.*,date_format(i.dtinsprent, '%d/%m/%Y') as data,(CONCAT(ca.modelo,' - ', ca.placa, ' para ', c.Nome, ' em ', date_format(r.dtdiaria, '%d/%m/%Y'))) as alug from tinsprent i, tclient c, tcar ca, trent r WHERE i.idrent = r.idrent AND r.idclient = c.idclient AND r.idcar = ca.idcar " . $w;
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
          <input class="form03" name="idinsprent" type="hidden" value="<?php echo $row['idinsprent']; ?>">
          <input class="form03" name="inspetor" type="hidden" value="<?php echo $row['inspetor']; ?>">
          <td>&nbsp;<?php echo $row['inspetor']; ?></td>
          <input class="form03" name="idrent" type="hidden" value="<?php echo $row['idrent']; ?>">
          <td>&nbsp;<?php echo $row['alug']; ?></td>
          <input class="form03" name="dtinsprent" type="hidden" value="<?php echo $row['dtinsprent']; ?>">
          <td>&nbsp;<?php echo $row['data']; ?></td>
          <input class="form03" name="inspdesc" type="hidden" value="<?php echo $row['inspdesc']; ?>">
          <td>&nbsp;<?php echo $row['inspdesc']; ?></td>
          <td>&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td></form>
        <form name="Exc<?php echo $row['idinsprent']; ?>" action="<?php echo $home; ?>/cad/envia_cad<?php echo $modulotab ?>.php" method="POST">
          <input name="idinsprent" type="hidden" value="<?php echo $row['idinsprent']; ?>">
          <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
          <input name="id" type="hidden" value="<?php echo retRequest('id'); ?>">
          <input name="oper" type="hidden" value="Apagar">
          <td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idinsprent']; ?>.submit();}" value="Excluir">
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
