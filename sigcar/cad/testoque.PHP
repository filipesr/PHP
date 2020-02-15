<?php $modulotab = "testoque"; ?>
<?php require("../loga.php"); ?>
<html>
  <body>
    <form action="<?php echo $home; ?>/cad/testoque.php" method="POST">
      <table id="Detail_999999">
        <tr>
          <?php $w .= retRequest('marca', "AND marca LIKE '%", "%'"); ?>
          <td >&nbsp;Marca</td><td ><input class="form03" name="marca" value="<?php echo retRequest('marca'); ?>" type="text"></td>
          <?php $w .= retRequest('modelo', "AND modelo LIKE '%", "%'"); ?>
          <td >&nbsp;Modelo</td><td ><input class="form03" name="modelo" value="<?php echo retRequest('modelo'); ?>" type="text"></td>
          <?php $w .= retRequest('ano_fab', "AND ano_fab = '", "'"); ?>
          <td >&nbsp;Ano Fabrica&ccedil;&atilde;o</td><td ><input class="form03" name="ano_fab" value="<?php echo retRequest('ano_fab'); ?>" type="text"></td>
        </tr><tr><?php $w .= retRequest('ano_mod', "AND ano_mod = '", "'"); ?>
          <td >&nbsp;Ano modelo</td><td ><input class="form03" name="ano_mod" value="<?php echo retRequest('ano_mod'); ?>" type="text"></td>
          <?php $w .= retRequest('chassi', "AND chassi LIKE '%", "%'"); ?>
          <td >&nbsp;Chassi</td><td ><input class="form03" name="chassi" value="<?php echo retRequest('chassi'); ?>" type="text"></td>
          <?php $w .= retRequest('cor', "AND cor LIKE '%", "%'"); ?>
          <td >&nbsp;Cor</td><td ><input class="form03" name="cor" value="<?php echo retRequest('cor'); ?>" type="text"></td>
        </tr>
        <tr><?php $w .= retRequest('portas', "AND portas = '", "'"); ?>
          <td >&nbsp;Portas</td><td ><input class="form03" name="portas" value="<?php echo retRequest('portas'); ?>" type="text"></td>
          <?php $w .= retRequest('placa', "AND placa LIKE '%", "%'"); ?>
          <td >&nbsp;Placa</td>
          <td ><input class="form03" name="placa" value="<?php echo retRequest('placa'); ?>" type="text"></td>
          <td></td>
          <td><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td>
        </tr>
      </table>
    </form>
    <table>
      <tr style="<?php echo $TitItem ?>">
        <td>&nbsp;<?php aTit("marca", "Marca"); ?></td>
        <td>&nbsp;<?php aTit("modelo", "Modelo"); ?></td>
        <td>&nbsp;<?php aTit("ano", "Ano"); ?></td>
        <td>&nbsp;Acess&oacute;rios</td>
        <td>&nbsp;<?php aTit("cor", "Cor"); ?></td>
        <td>&nbsp;<?php aTit("portas", "Portas"); ?></td>
        <td>&nbsp;<?php aTit("placa", "Placa"); ?></td>
        <td>&nbsp;<?php aTit("vrcompra", "Compra"); ?></td>
        <td>&nbsp;<?php aTit("totalserv", "Servi&ccedil;os"); ?></td>
        <td>&nbsp;Total</td>
        <td>&nbsp;</td>
        <td nowrap >&nbsp;</td></tr>
      <?php
      $colspan = 16;
      //Executa a consulta
      $sql = "select c.*, concat(ano_fab, '/', ano_mod) as ano, date_format(co.dtcompra, '%d/%m/%Y') as dtc, co.vrcompra, (select sum(vritemos) from titemos where idos in(select idos from tos where idcar = c.idcar)) as totalserv, coalesce(foto1, foto2, foto3, foto4, foto5, 0) as fotos from tcar c, tcompra co where c.idcar = co.idcar and c.idcar not in (select idcar from tvenda) " . $w;
	  //echo "<tr><td colspan='12'>$sql</td></tr>";
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
        <tr style="<?php echo $style; ?>">
          <td>&nbsp;<?php echo $row['marca']; ?></td>
          <td>&nbsp;<?php echo $row['modelo']; ?></td>
          <td>&nbsp;<?php echo $row['ano']; ?></td>
          <td nowrap>&nbsp;
            <?php
            $sql = "Select acabrev, acdesc from tac where idac in (select idac from taccar where idcar = " . $row['idcar'] . ") ";
            //echo($sql);
            $res1 = sqlexec($id, $sql);
            //Exibe as linhas encontradas na consulta
            while ($row1 = mysql_fetch_array($res1)) {
              ?>
              <span title="<?php echo $row1[1]; ?>"><?php echo $row1[0]; ?></span>
            <?php } ?>
          </td>
          <td>&nbsp;<?php echo $row['cor']; ?></td>
          <td>&nbsp;<?php echo $row['portas']; ?></td>
          <td>&nbsp;<?php echo $row['placa']; ?></td>
          <td>&nbsp;<?php echo $row['dtc']; ?> - R$ <?php echo $row['vrcompra']; ?></td>
          <td>&nbsp;R$ <?php echo $row['totalserv']; ?></td>
          <td>&nbsp;R$ <?php echo $row['totalserv'] + $row['vrcompra']; ?></td>
          <td>
              <a href="tos.php?idcar=<?php echo $row['idcar']; ?>"> <img src="/sigcar/imagens/btns/tos.jpg" height="15"></a>
		  	<?php if ($row['fotos'] != 0) { ?>   
              <a href="listafotos.php?oper=Ver&idcar=<?php echo $row['idcar']; ?>"> <img src="/sigcar/imagens/btns/camera.png" height="15"></a>
            <?php } ?>
            <?php if ($row['totalserv'] != "") { ?>   
              <a href="javascript:detailbox('<?php echo $row['idcar']; ?>')"> Detalhes</a>
            <?php } ?>   
          </td>
        </tr>
        <tr style="display:none" id="Detail_<?php echo $row['idcar']; ?>">
          <td colspan="10"> </td>
          <td>	
            <table>
              <tr style="<?php echo $TitSub ?>">
                <td>&nbsp;OS</td>
                <td>&nbsp;Data</td>
                <td>&nbsp;Servi&ccedil;o</td>
                <td>&nbsp;Valor</td>
              </tr>
              <?php
              $sql = "select i.*, date_format(o.dtos, '%d/%m/%Y') AS data, s.servicedesc from titemos i, tos o, tservice s where i.idos = o.idos and i.idservice = s.idservice and o.idcar = " . $row['idcar'] . " order by dtos";
              $res1 = sqlexec($id, $sql);
              //Exibe as linhas encontradas na consulta
              $ls = 0;
              while ($row1 = mysql_fetch_array($res1)) {
                $sstyle = $ls % 2 == 0 ? $SubPar : $SubImpar;
                $ls++;
                ?>
                <tr style="<?php echo $sstyle; ?>">
                  <td>&nbsp;<?php echo $row1['idos']; ?></td>
                  <td>&nbsp;<?php echo $row1['data']; ?></td>
                  <td>&nbsp;<?php echo $row1['servicedesc']; ?></td>
                  <td>&nbsp;R$ <?php echo $row1['vritemos']; ?></td>
                </tr>
                <?php
              }
              $sstyle = $ls % 2 == 0 ? $SubPar : $SubImpar;
              ?>
              <tr>
                <td  colspan="4" bgcolor="#000000" height="1"></td>
              </tr>
              <tr style="<?php echo $sstyle; ?>">
                <td colspan="3">&nbsp;<b>Total</b></td>
                <td>&nbsp;<b>R$ <?php echo $row['totalserv']; ?></b></td>
              </tr>
            </table>
          </td>
        </tr>
        <?php
      }
      ?>
    </table>
  </body>
</html>
