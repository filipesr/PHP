<?php $modulotab = "tgrupoacesso"; ?>
<?php
require("../loga.php");
$idgrupoacesso = retRequest('idgrupoacesso');
if ($idgrupoacesso < 10) {
  $idgrupoacesso = "0" . $idgrupoacesso;
};
?>
<html><body>
    <script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
    <form method="POST" action="envia_cadtgrupoacesso.php" name="tgrupoacesso">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <table>
        <input class="form03" name="idgrupoacesso" type="hidden" value="<?php echo retRequest('idgrupoacesso') ?>">
        <tr><td >&nbsp;Grupo</td><td ><input class="form03" name="grupodesc" value="<?php echo retRequest('grupodesc'); ?>" type="text">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
        <tr id="tacesso" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>"><td  colspan="4" bgcolor="#000000" height="1"></td></tr>
        <tr id="tacesso" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
          <td></td>
          <td  colspan="2">
            <iframe src="tacesso.php?pesq=none&idgrupoacesso=<?php echo $idgrupoacesso ?>" frameborder="0" scrolling="no" height="<?php echo RetVar("select count(idAcesso) from tacesso where idgrupoacesso = $idgrupoacesso") * 25 + 200; ?>" width="800"></iframe>
          </td>
        </tr>
        <tr id="cad_tacesso" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
          <td  colspan="2" align="center">

          </td>
        </tr>
      </table>
    </form>
  </body></html>
