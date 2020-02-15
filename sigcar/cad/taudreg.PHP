<?php $modulotab = "taudreg"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/taudreg.php" method="POST" name="taudreg">
        <?php $w .= retRequest('idmodulo', "AND a.idmodulo = '", "'"); ?>
        <td >&nbsp;Modulo</td><td >
          <?php selComb("idmodulo", retRequest('idmodulo'), "select idmodulo,modulodesc from tmodulo order by modulodesc"); ?>
        </td>
        <?php $w .= retRequest('login', "AND u.login LIKE '%", "%'"); ?>
        <td >&nbsp;Usu&aacute;rio</td><td ><input class="form03" name="login" value="<?php echo retRequest('login'); ?>" type="text"></td>
        <?php $dtC = 'dtreg'; ?>
        <?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
        <?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td >&nbsp;Data entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
        <?php $w .= retRequest('sqlreg', "AND sqlReg LIKE '", "%'"); ?>
        <td >&nbsp;SQL</td><td >
          <select name="sqlreg">
            <option value=""> </option> 
            <option value="Select" <?php echo retRequest('sqlreg') == "Select" ? "selected" : ""; ?>>Ler</option>
            <option value="Update" <?php echo retRequest('sqlreg') == "Update" ? "selected" : ""; ?>>Editar</option>
            <option value="Delete" <?php echo retRequest('sqlreg') == "Delete" ? "selected" : ""; ?>>Apagar</option>
            <option value="Insert" <?php echo retRequest('sqlreg') == "Insert" ? "selected" : ""; ?>>Inserir</option>
          </select></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td><?php aTit("idmodulo", "Modulo"); ?></td>
      <td><?php aTit("iduser", "Usu&aacute;rio"); ?></td>
      <td><?php aTit("dtreg", "Data"); ?></td>
      <td>Sql registrado</td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 8;
      //Executa a consulta
      $sql = "Select a.*, m.modulodesc, date_format(a.dtreg, '%d/%m/%Y %T') AS dt, u.login from taudreg a, tmodulo m, tuser u where a.idmodulo = m.idmodulo and a.iduser = u.iduser " . $w;
      $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
      //Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
        <td >&nbsp;<?php echo $row['modulodesc']; ?></td>
        <td >&nbsp;<?php echo $row['login']; ?></td>
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <td >&nbsp;<?php echo $row['sqlreg']; ?></td>
      </tr>
      <?php
    }
    ?>
  </table></body></html>
