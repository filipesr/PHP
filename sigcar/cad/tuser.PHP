<?php $modulotab = "tuser"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table id="Detail_999999" style="display:block"><tr>
      <form method="POST" action="<?php echo $home; ?>/cad/<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <?php $w .= retRequest('idgrupoacesso', "AND u.idgrupoacesso = '", "'"); ?>
        <td >&nbsp;Grupo</td><td >
        <?php selComb("idgrupoacesso", retRequest('idgrupoacesso'), "select idgrupoacesso,grupodesc from tgrupoacesso order by grupodesc"); ?>
        </td>
          <?php $w .= retRequest('idempresa', "AND u.idempresa = '", "'"); ?>
        <td >&nbsp;Empresa</td><td>
        <?php selComb("idempresa", retRequest('idempresa'), "select idempresa,emp from tempresa order by emp"); ?>
        </td>
        <?php $w .= retRequest('login', "AND u.login LIKE '%", "%'"); ?>
        <td >&nbsp;Usu&aacute;rio</td><td ><input class="form03" name="login" value="<?php echo retRequest('login'); ?>" type="text"></td>
<?php $dtC = 'dtua'; ?>
<?php $w .= retRequest($dtC . 'A', "AND " . $dtC . " > '", "'"); ?>
<?php $w .= retRequest($dtC . 'D', "AND " . $dtC . " < '", "'"); ?>
        <td  nowrap>&nbsp;&Uacute;ltimo Acesso entre:<?php dtCal($modulotab, $dtC . "A", retRequest($dtC . 'A')); ?>&nbsp;e <?php dtCal($modulotab, $dtC . "D", retRequest($dtC . 'D')); ?></td>
<?php $w .= retRequest('active', "AND u.active = '", "'"); ?>
        <td >Ativo</td><td ><?php selCombSN("active", retRequest('active')); ?></td>
        <td ><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;<?php aTit("grupodesc", "Grupo"); ?></td>
      <td>&nbsp;<?php aTit("emp", "Empresa"); ?></td>
      <td>&nbsp;<?php aTit("login", "Usu&aacute;rio"); ?></td>
      <td>&nbsp;<?php aTit("pass", "Senha"); ?></td>
      <td>&nbsp;<?php aTit("active", "Situa&ccedil;&atilde;o"); ?></td>
      <td>&nbsp;<?php aTit("dtua", "&Uacute;ltimo Acesso"); ?></td>
      <td nowrap >&nbsp;</td>
<?php
$colspan = 9;
//Executa a consulta
$sql = "Select u.*, g.grupodesc, e.emp, date_format(u.dtua, '%d/%m/%Y') AS dt from tuser u, tgrupoacesso g, tempresa e where u.idgrupoacesso = g.idgrupoacesso and u.idempresa = e.idempresa " . $w;
$res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
//Exibe as linhas encontradas na consulta
$l = 0;
while ($row = mysql_fetch_array($res)) {
  $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
  $l++;
  ?>
      <tr style="<?php echo $style; ?>">
      <form action="<?php echo $home; ?>/cad/cadtuser.php" method="POST">
        <input name="oper" type="hidden" value="Editar">
        <input class="form03" name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
        <input class="form03" name="idgrupoacesso" type="hidden" value="<?php echo $row['idgrupoacesso']; ?>">
        <td >&nbsp;<?php echo $row['grupodesc']; ?></td>
        <input class="form03" name="idempresa" type="hidden" value="<?php echo $row['idempresa']; ?>">
        <td >&nbsp;<?php echo $row['emp']; ?></td>
        <input class="form03" name="login" type="hidden" value="<?php echo $row['login']; ?>">
        <td >&nbsp;<?php echo $row['login']; ?></td>
        <input class="form03" name="pass" type="hidden" value="<?php echo $row['pass']; ?>">
        <td >&nbsp;<?php echo $row['pass']; ?></td>
        <input class="form03" name="active" type="hidden" value="<?php echo $row['active']; ?>">
        <td >&nbsp;<?php echo ($row['active'] == 1) ? "Ativo" : "Inativo"; ?></td>
        <input class="form03" name="dtua" type="hidden" value="<?php echo $row['dtua']; ?>">
        <td >&nbsp;<?php echo $row['dt']; ?></td>
        <td >&nbsp;<input class="btEdt" type="submit" value="Editar">
        </td></form>
      <form name="Exc<?php echo $row['iduser']; ?>" action="<?php echo $home; ?>/cad/envia_cadtuser.php" method="POST">
        <input name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
        <input name="oper" type="hidden" value="Apagar">
        <td >&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['iduser']; ?>.submit();}" value="Excluir">
        </td></form>
      <form name="Des<?php echo $row['iduser']; ?>" action="<?php echo $home; ?>/cad/envia_cadtuser.php" method="POST">
        <input name="iduser" type="hidden" value="<?php echo $row['iduser']; ?>">
        <input name="oper" type="hidden" value="Desativar">
        <td >&nbsp;<input name="Desativar" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['iduser']; ?>.submit();}" value="Desativar">
        </td></form>
    </tr>
  <?php
}
?>
  <tr><td colspan="<?php echo $colspan; ?>">&nbsp;<div align="center"><form action="<?php echo $home; ?>/cad/cadtuser.php" method="POST"><input name="oper" type="hidden" value="Inserir"><input class="btIns" type="submit" value="Inserir"></form></div></td></tr>
</table></body></html>
