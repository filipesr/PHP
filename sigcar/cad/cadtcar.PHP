<?php $modulotab = "tcar"; ?>
<?php
require("../loga.php");
$idcar = vrIF(retRequest('idcar'), "", NextAI('idcar'));
if ($idcar < 10) {
  $idcar = "0" . $idcar;
};
?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtcar.php" name="tcar">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idcar" type="hidden" value="<?php echo $idcar ?>">
        <tr><td >&nbsp;Marca</td><td >&nbsp;<input class="form03" name="marca" value="<?php echo retRequest('marca'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Modelo</td><td >&nbsp;<input class="form03" name="modelo" value="<?php echo retRequest('modelo'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Fabricada</td><td >&nbsp;<input class="form03" name="ano_fab" value="<?php echo retRequest('ano_fab'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Modelo do ano</td><td >&nbsp;<input class="form03" name="ano_mod" value="<?php echo retRequest('ano_mod'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Chassi</td><td >&nbsp;<input class="form03" name="chassi" value="<?php echo retRequest('chassi'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Cor</td><td >&nbsp;<input class="form03" name="cor" value="<?php echo retRequest('cor'); ?>" type="Text"></td></tr>
        <tr><td >&nbsp;Portas</td><td >&nbsp;<input class="form03" name="portas" value="<?php echo retRequest('portas'); ?>" type="Number"></td></tr>
        <tr><td >&nbsp;Placa</td><td >&nbsp;<input class="form03" name="placa" value="<?php echo retRequest('placa'); ?>" type="Text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
        <tr id="taccar" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>"><td  colspan="4" bgcolor="#000000" height="1"></td></tr>
        <tr id="taccar" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
          <td valign="top">Acess�rios</td>
          <td  colspan="2">
            <iframe src="taccar.php?pesq=none&idcar=<?php echo $idcar ?>" frameborder="0" scrolling="no" height="<?php echo RetVar("select count(idaccar) from taccar where idcar = $idcar") * 25 + 100; ?>" width="600"></iframe>
          </td>
        </tr>
        <tr id="tdoccar" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>"><td  colspan="4" bgcolor="#000000" height="1"></td></tr>
        <tr id="tdoccar" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
          <td valign="top">Documentos</td>
          <td  colspan="2">
            <iframe src="tdoccar.php?pesq=none&idcar=<?php echo $idcar ?>" frameborder="0" scrolling="no" height="<?php echo RetVar("select count(iddoccar) from tdoccar where idcar = $idcar") * 25 + 200; ?>" width="600"></iframe>
          </td>
        </tr>
      </table>
    </form>
  </body></html>
