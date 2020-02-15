<?php $modulotab = "tcar"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tcar.php" method="POST">
        <?php $w .= retRequest('marca', "AND marca LIKE '%", "%'"); ?>
        <td >&nbsp;Marca</td><td ><input class="form03" name="marca" value="<?php echo retRequest('marca'); ?>" type="text"></td>
        <?php $w .= retRequest('modelo', "AND modelo LIKE '%", "%'"); ?>
        <td >&nbsp;Modelo</td><td ><input class="form03" name="modelo" value="<?php echo retRequest('modelo'); ?>" type="text"></td>
        <?php $w .= retRequest('ano_fab', "AND ano_fab = '", "'"); ?>
        <td >&nbsp;Ano Fabrica&ccedil;&atilde;o</td><td ><input class="form03" name="ano_fab" value="<?php echo retRequest('ano_fab'); ?>" type="text"></td>
        <tr></tr><?php $w .= retRequest('ano_mod', "AND ano_mod = '", "'"); ?>
        <td >&nbsp;Ano modelo</td><td ><input class="form03" name="ano_mod" value="<?php echo retRequest('ano_mod'); ?>" type="text"></td>
        <?php $w .= retRequest('chassi', "AND chassi LIKE '%", "%'"); ?>
        <td >&nbsp;Chassi</td><td ><input class="form03" name="chassi" value="<?php echo retRequest('chassi'); ?>" type="text"></td>
        <?php $w .= retRequest('cor', "AND cor LIKE '%", "%'"); ?>
        <td >&nbsp;Cor</td><td ><input class="form03" name="cor" value="<?php echo retRequest('cor'); ?>" type="text"></td>
        <tr></tr><?php $w .= retRequest('portas', "AND portas = '", "'"); ?>
        <td >&nbsp;Portas</td><td ><input class="form03" name="portas" value="<?php echo retRequest('portas'); ?>" type="text"></td>
        <?php $w .= retRequest('placa', "AND placa LIKE '%", "%'"); ?>
        <td >&nbsp;Placa</td><td ><input class="form03" name="placa" value="<?php echo retRequest('placa'); ?>" type="text"></td>
        <td></td><td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("marca", "Marca"); ?></td>
      <td>&nbsp;<?php aTit("modelo", "Modelo"); ?></td>
      <td>&nbsp;<?php aTit("ano", "Ano"); ?></td>
      <td>&nbsp;Acess&oacute;rios</td>
      <td>&nbsp;<?php aTit("chassi", "Chassi"); ?></td>
      <td>&nbsp;<?php aTit("cor", "Cor"); ?></td>
      <td>&nbsp;<?php aTit("portas", "Portas"); ?></td>
      <td>&nbsp;<?php aTit("placa", "Placa"); ?></td>
      <td></td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 16;
//Executa a consulta
      $sql = "Select *, CONCAT(ano_fab,'/',ano_mod) as ano, coalesce(foto1, foto2, foto3, foto4, foto5, 0) as fotos from tcar WHERE 1=1 " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtcar.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input class="form03" name="marca" type="hidden" value="<?php echo $row['marca']; ?>">
        <td >&nbsp;<?php echo $row['marca']; ?></td>
        <input class="form03" name="modelo" type="hidden" value="<?php echo $row['modelo']; ?>">
        <td >&nbsp;<?php echo $row['modelo']; ?></td>
        <input class="form03" name="ano_fab" type="hidden" value="<?php echo $row['ano_fab']; ?>"><input class="form03" name="ano_mod" type="hidden" value="<?php echo $row['ano_mod']; ?>">
        <td >&nbsp;<?php echo $row['ano']; ?></td>
        <td nowrap>&nbsp;
          <?php
          $sql = "Select acabrev, acdesc from tac where idac in (Select idac from taccar where idcar = " . $row['idcar'] . ") ";
          $res1 = sqlexec($id, $sql);
          //Exibe as linhas encontradas na consulta
          while ($row1 = mysql_fetch_array($res1)) {
            ?>
            <span title="<?php echo $row1[1]; ?>"><?php echo $row1[0]; ?></span>
          <?php } ?>
        </td>
        <input class="form03" name="chassi" type="hidden" value="<?php echo $row['chassi']; ?>">
        <td >&nbsp;<?php echo $row['chassi']; ?></td>
        <input class="form03" name="cor" type="hidden" value="<?php echo $row['cor']; ?>">
        <td >&nbsp;<?php echo $row['cor']; ?></td>
        <input class="form03" name="portas" type="hidden" value="<?php echo $row['portas']; ?>">
        <td >&nbsp;<?php echo $row['portas']; ?></td>
        <input class="form03" name="placa" type="hidden" value="<?php echo $row['placa']; ?>">
        <td >&nbsp;<?php echo $row['placa']; ?></td>
        <td ><a href="listafotos.php?oper=Editar&idcar=<?php echo $row['idcar']; ?>"> <img src="/sigcar/imagens/btns/camera.png" height="15"></a></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['idcar']; ?>" action="<?php echo $home; ?>/cad/envia_cadtcar.php" method="POST">
        <input name="idcar" type="hidden" value="<?php echo $row['idcar']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idcar']; ?>.submit();}" value="Excluir">
        </td></form>
    </tr>
    <?php
  }
  ?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtcar.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
