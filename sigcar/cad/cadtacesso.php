<?php $modulotab = "tacesso"; ?>
<?php require("../loga.php"); ?>
<html>
  <body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper'); ?>">
      <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
      <table>
        <input name="idacesso" type="hidden" value="<?php echo retRequest('idacesso'); ?>">
        <?php if (retRequest('pesq') == "") { ?>
          <tr><td >&nbsp;Grupo</td><td >&nbsp;
              <?php selComb("idgrupoacesso", retRequest('idgrupoacesso'), "select idgrupoacesso,grupodesc from tgrupoacesso order by grupodesc"); ?>
              <?php
            }
            else {
              ?>
              <input name="idgrupoacesso" type="hidden" value="<?php echo retRequest('idgrupoacesso'); ?>">
          <tr><td >&nbsp;modulo</td><td >&nbsp;
              <?php
            }
            if ((retRequest('pesq') != "") && (retRequest('oper') == "Editar")) {
              echo retRequest('modulodesc');
            }
            else {
              selComb("idmodulo", retRequest('idmodulo'), "select idmodulo,modulodesc from tmodulo order by modulodesc");
            }
            ?>
          </td><tr><td >&nbsp;Validade</td>
          <td > &nbsp;
            <?php dtCal($modulotab, "dtvalidade", retRequest("dtvalidade")); ?>
          </td></tr>
        <tr><td  valign="middle">&nbsp;Menu</td>
          <td >
            <?php
            selCombSNX("menu", retRequest('menu'), 'Exibir');
            ?>
          </td></tr>
        <tr><td  valign="middle">&nbsp;Permiss�es</td>
          <td >
            <?php
            selCombSNX("aler", retRequest('aler'), 'Ler<BR>');
            selCombSNX("ainserir", retRequest('ainserir'), 'Inserir<BR>');
            selCombSNX("aeditar", retRequest('aeditar'), 'Editar<BR>');
            selCombSNX("aapagar", retRequest('aapagar'), 'Apagar<BR>');
            ?>
          </td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
      </table>
    </form>

  </body></html>
