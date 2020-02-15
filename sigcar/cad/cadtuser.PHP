<?php $modulotab = "tuser"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtuser.php" name="tuser">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="iduser" type="hidden" value="<?php echo retRequest('iduser') ?>">
        <tr><td >&nbsp;Grupo</td><td >
            <?php selComb("idgrupoacesso", retRequest('idgrupoacesso'), "select idgrupoacesso,grupodesc from tgrupoacesso order by grupodesc"); ?></td></tr>
        <tr><td >&nbsp;empresa</td><td >
            <?php selComb("idempresa", retRequest('idempresa'), "select idempresa,emp from tempresa order by emp"); ?></td></tr>
        <tr><td >&nbsp;Login</td><td ><input class="form03" name="login" value="<?php echo retRequest('login'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Pass</td><td ><input class="form03" name="pass" value="<?php echo retRequest('pass'); ?>" type="text"></td></tr>
        <tr><td  valign="middle">&nbsp;Situa��o</td>
          <td >
            <?php
            cbS("active", retRequest('active'), 'Ativo');
            ?>
          </td></tr>
        <tr><td >&nbsp;�ltimo Acesso</td><td ><?php echo retRequest('dtua'); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
