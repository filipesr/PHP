<?php $modulotab = "tclient"; ?>
<?php require("../loga.php"); ?>
<html><body>

    <table id="Detail_999999" style="display:block"><tr>
      <form action="<?php echo $home; ?>/cad/tclient.php" method="POST">
        <?php $w .= retRequest('nome', "AND nome LIKE '%", "%'"); ?>
        <td >&nbsp;Nome</td><td ><input class="form03" name="nome" value="<?php echo retRequest('nome'); ?>" type="text"></td>
        <?php $w .= retRequest('tel', "AND tel LIKE '%", "%'"); ?>
        <td >&nbsp;Telefone</td><td ><input class="form03" name="tel" value="<?php echo retRequest('tel'); ?>" type="text"></td>
        <?php $w .= retRequest('rua', "AND rua LIKE '%", "%'"); ?>
        <td >&nbsp;Rua</td><td ><input class="form03" name="rua" value="<?php echo retRequest('rua'); ?>" type="text"></td>
      </tr><tr><?php $w .= retRequest('cidade', "AND cidade LIKE '%", "%'"); ?>
      <td >&nbsp;Cidade</td><td ><input class="form03" name="cidade" value="<?php echo retRequest('cidade'); ?>" type="text"></td>
      <?php $w .= retRequest('bairro', "AND bairro LIKE '%", "%'"); ?>
      <td >&nbsp;Bairro</td><td ><input class="form03" name="bairro" value="<?php echo retRequest('bairro'); ?>" type="text"></td>
      <?php $w .= retRequest('uf', "AND uf LIKE '%", "%'"); ?>
      <td >&nbsp;UF</td><td ><input class="form03" name="uf" value="<?php echo retRequest('uf'); ?>" type="text"></td>
    </tr><tr><?php $w .= retRequest('cpfcnpj', "AND cpfcnpj = '", "'"); ?>
      <td >&nbsp;CPF/CNPJ</td><td ><input class="form03" name="cpfcnpj" value="<?php echo retRequest('cpfcnpj'); ?>" type="text"></td>
      <?php $w .= retRequest('ciie', "AND ciie = '", "'"); ?>
      <td >&nbsp;CI/IE</td><td ><input class="form03" name="ciie" value="<?php echo retRequest('ciie'); ?>" type="text"></td>
      <td></td><td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

<table><tr style="<?php echo $TitItem ?>">
    <td>&nbsp;<?php aTit("nome", "Nome"); ?></td>
    <td>&nbsp;<?php aTit("tel", "Tel"); ?></td>
    <td>&nbsp;<?php aTit("rua", "Rua"); ?></td>
    <td>&nbsp;<?php aTit("cidade", "Cidade"); ?></td>
    <td>&nbsp;<?php aTit("bairro", "Bairro"); ?></td>
    <td>&nbsp;<?php aTit("uf", "UF"); ?></td>
    <td>&nbsp;<?php aTit("cpfcnpj", "CPF/CNPJ"); ?></td>
    <td>&nbsp;<?php aTit("ciie", "CI/IE"); ?></td>
    <td nowrap >&nbsp;</td>
    <?php
    $colspan = 13;
//Executa a consulta
    $sql = "Select c.* from tclient c, tuser u WHERE u.active = 1 and u.iduser = c.iduser " . $w;
    $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
    $l = 0;
    while ($row = mysql_fetch_array($res)) {
      $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
      $l++;
      ?>
    <tr style="<?php echo $style; ?>">
    <form action="<?php echo $home; ?>/cad/cadtclient.php" method="POST">
      <input name="oper" type="hidden" value="Editar">
      <input class="form03" name="idclient" type="hidden" value="<?php echo $row['idclient']; ?>">
      <input name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
      <input class="form03" name="nome" type="hidden" value="<?php echo $row['nome']; ?>">
      <td >&nbsp;<?php echo $row['nome']; ?></td>
      <input class="form03" name="tel" type="hidden" value="<?php echo $row['tel']; ?>">
      <td >&nbsp;<?php echo $row['tel']; ?></td>
      <input class="form03" name="rua" type="hidden" value="<?php echo $row['rua']; ?>">
      <td >&nbsp;<?php echo $row['rua']; ?></td>
      <input class="form03" name="cidade" type="hidden" value="<?php echo $row['cidade']; ?>">
      <td >&nbsp;<?php echo $row['cidade']; ?></td>
      <input class="form03" name="bairro" type="hidden" value="<?php echo $row['bairro']; ?>">
      <td >&nbsp;<?php echo $row['bairro']; ?></td>
      <input class="form03" name="uf" type="hidden" value="<?php echo $row['uf']; ?>">
      <td >&nbsp;<?php echo $row['uf']; ?></td>
      <input class="form03" name="cpfcnpj" type="hidden" value="<?php echo $row['cpfcnpj']; ?>">
      <td >&nbsp;<?php echo $row['cpfcnpj']; ?></td>
      <input class="form03" name="ciie" type="hidden" value="<?php echo $row['ciie']; ?>">
      <td >&nbsp;<?php echo $row['ciie']; ?></td>
      <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
      </td></form>
    <form name="Exc<?php echo $row['idclient']; ?>" action="<?php echo $home; ?>/cad/envia_cadtclient.php" method="POST">
      <input name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
      <input name="oper" type="hidden" value="Apagar">
      <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idclient']; ?>.submit();}" value="Excluir">
      </td></form>
  </tr>
  <?php
}
?>
<tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtclient.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
