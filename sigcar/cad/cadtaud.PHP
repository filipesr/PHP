<?php $modulotab = "taud"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <form method="POST" action="envia_cadtaud.php" name="taud">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idaud" type="hidden" value="<?php echo retRequest('idaud') ?>">
        <?php $w .= retRequest('idmodulo', "AND a.idmodulo = '", "'"); ?>
        <td >&nbsp;modulo</td><td >
          <?php selComb("idmodulo", retRequest('idmodulo'), "select idmodulo,modulodesc from tmodulo order by modulodesc"); ?>
        </td>
        <tr><td >&nbsp;Data</td><td ><?php echo retRequest('dt'); ?></td></tr>
        <tr><td >&nbsp;Ler</td><td ><?php selCombSNX("aler", retRequest('aler')); ?></td></tr>
        <tr><td >&nbsp;Editar</td><td ><?php selCombSNX("aeditar", retRequest('aeditar')); ?></td></tr>
        <tr><td >&nbsp;Inserir</td><td ><?php selCombSNX("ainserir", retRequest('ainserir')); ?></td></tr>
        <tr><td >&nbsp;Apagar</td><td ><?php selCombSNX("aapagar", retRequest('aapagar')); ?></td></tr>
        <tr><td >&nbsp;Ativo</td><td ><?php selCombSNX("active", retRequest('active')); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
