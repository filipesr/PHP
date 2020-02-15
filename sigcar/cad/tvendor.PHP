<?php $modulotab = "tvendor"; ?>
<?php require("../loga.php"); ?>
<html>
  <body>
    <form action="<?php echo $home; ?>/cad/tvendor.php" method="POST">
      <table id="Detail_999999" style="display:block"><tr>
          <?php $w .= retRequest('vendordesc', "AND v.vendordesc LIKE '%", "%'"); ?>
          <td >&nbsp;Vendedor</td><td ><input class="form03" name="vendordesc" value="<?php echo retRequest('vendordesc'); ?>" type="text"></td>
          <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td>
        </tr>
      </table>
    </form>

    <table>
      <tr style="<?php echo $TitItem ?>">
        <td>&nbsp;<?php aTit("login", "Usu&aacute;rio"); ?></td>
        <td>&nbsp;<?php aTit("vendordesc", "Vendedor"); ?></td>
        <td nowrap >&nbsp;</td>
        <?php
        $colspan = 6;
        //Executa a consulta
        $sql = "Select v.*, u.login, u.pass from tvendor v, tuser u where u.active = 1 and v.iduser = u.iduser " . $w;
        $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
        //Exibe as linhas encontradas na consulta
        $l = 0;
        while ($row = mysql_fetch_array($res)) {
          $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
          $l++;
          ?>
        <tr style="<?php echo $style; ?>">
        <form action="<?php echo $home; ?>/cad/cadtvendor.php" method="POST">
          <input name="oper" type="hidden" value="Editar">
          <input class="form03" name="idvendor" type="hidden" value="<?php echo $row['idvendor']; ?>">
          <input class="form03" name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
          <input class="form03" name="login" type="hidden" value="<?php echo $row['login']; ?>">
          <input class="form03" name="pass" type="hidden" value="<?php echo $row['pass']; ?>">
          <td >&nbsp;<?php echo $row['login']; ?></td>
          <input class="form03" name="vendordesc" type="hidden" value="<?php echo $row['vendordesc']; ?>">
          <td >&nbsp;<?php echo $row['vendordesc']; ?></td>
          <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
          </td>
        </form>
        <td>
          <form name="Exc<?php echo $row['idvendor']; ?>" action="<?php echo $home; ?>/cad/envia_cadtvendor.php" method="POST">
            <input name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
            <input name="oper" type="hidden" value="Apagar">
            &nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idvendor']; ?>.submit();}" value="Excluir">
          </form>
        </td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td colspan="<?php echo $colspan; ?>">&nbsp;
        <div align="center">
          <form action="<?php echo $home; ?>/cad/cadtvendor.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
