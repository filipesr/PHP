<?php $modulotab = "tclient"; ?>
<?php
require("../loga.php");
$iduser = vrIF(retRequest('iduser'), "", NextAI('tuser'));
if ($iduser < 10) {
  $iduser = "0" . $iduser;
};
$Login = vrIF(retRequest('login'), "", "cliente" . $iduser);
?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtclient.php" name="tclient">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <input class="form03" name="iduser" type="hidden" value="<?php echo $iduser ?>">
      <input class="form03" name="login" type="hidden" value="<?php echo $Login ?>">
      <table>
        <input class="form03" name="idclient" type="hidden" value="<?php echo retRequest('idclient') ?>">
        <tr><td >&nbsp;nome</td><td ><input class="form03" name="nome" value="<?php echo retRequest('nome'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Telefone</td><td ><input class="form03" maxlength="14" onKeyPress="mascara(this,telefone)" name="tel" value="<?php echo retRequest('tel'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Rua</td><td ><input class="form03" name="rua" value="<?php echo retRequest('rua'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Cidade</td><td ><input class="form03" name="cidade" value="<?php echo retRequest('cidade'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;Bairro</td><td ><input class="form03" name="bairro" value="<?php echo retRequest('bairro'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;UF</td><td ><input class="form03" name="uf" value="<?php echo retRequest('uf'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;CPF/CNPJ</td><td ><input class="form03" name="cpfcnpj" value="<?php echo retRequest('cpfcnpj'); ?>" type="text"></td></tr>
        <tr><td >&nbsp;CI/IE</td><td ><input class="form03" name="ciie" value="<?php echo retRequest('ciie'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>
  </body></html>
