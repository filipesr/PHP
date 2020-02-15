<?php $modulotab = "tvendor"; ?>
<?php
require("../loga.php");
$iduser = vrIF(retRequest('iduser'), "", NextAI('tuser'));
if ($iduser < 10) {
  $iduser = "0" . $iduser;
};
$login = vrIF(retRequest('login'), "", "vendedor" . $iduser);
?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtvendor.php" name="tvendor">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idvendor" type="hidden" value="<?php echo retRequest('idvendor') ?>">
        <input class="form03" name="iduser" type="hidden" value="<?php echo $iduser ?>">
        <input class="form03" name="login" type="hidden" value="<?php echo $login ?>">
        <tr><td >&nbsp;nome</td><td ><input class="form03" name="vendordesc" value="<?php echo retRequest('vendordesc'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Usu�rio</td><td ><?php echo $login; ?>
          </td></tr>
        <?php if (retRequest('oper') == "Editar") { ?>
          <tr><td >&nbsp;Senha</td><td >******</td></tr>
        <?php } ?>
        <tr><td >&nbsp;Nova Senha</td><td ><input name="pass" type="password" class="form03"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
