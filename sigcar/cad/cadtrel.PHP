<?php $modulotab = "trel"; ?>
<?php
require("../loga.php");
$idrel = vrIF(retRequest('idrel'), "", NextAI('tRel'));
if ($idrel < 10) {
  $idrel = "0" . $idrel;
};
?>
<html>
  <body>
    <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
      <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
      <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
      <input name="idrel" type="hidden" value="<?php echo $idrel ?>">
      <table>
        <?php if (retRequest('idrelcab') != "") { ?>
          <input name="idrelcab" type="hidden" value="<?php echo retRequest('idrelcab') ?>">
          <?php
        }
        if (retRequest('pesq') == "") {
          ?>
          <tr>
            <td >&nbsp;Cabecalho</td>
            <td >
              <?php if (retRequest('oper') == "Inserir") { ?>
                <?php selComb("idrelCab", retRequest("idrelcab"), "select idrel,RelTit from trel where idrel <> $idrel order by RelTit"); ?>
                <?php
              }
              else {
                echo retRequest('idrelcab');
              }
              ?>
            </td>
          </tr>
        <?php }
        ?>
        <tr>
          <td>&nbsp;Titulo</td>
          <td><input class="form03" name="reltit" value="<?php echo retRequest('reltit'); ?>" type="Text"></td>
        </tr>
        <tr>
          <td>&nbsp;Tabela</td>
          <td><input class="form03" name="reltab" value="<?php echo retRequest('reltab'); ?>" type="Text"></td>
        </tr>
        <tr>
          <td>&nbsp;Condicao</td>
          <td><input class="form03" name="relwhere" value="<?php echo retRequest('relwhere'); ?>" type="Text"></td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td>
        </tr>
      </table>
    </form>
    <table>
      <tr id="idrelcol" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
        <td  colspan="4" bgcolor="#000000" height="1"></td>
      </tr>
      <tr id="idrelcol" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
        <td valign="top">Colunas</td>
        <td  colspan="2">
          <iframe src="trelcol.php?pesq=none&idrel=<?php echo $idrel ?>" frameborder="0" scrolling="no" height="<?php echo RetVar("select count(idrelcol) from trelcol where idrel = $idrel") * 25 + 200; ?>" width="600"></iframe>
        </td>
      </tr>
    </table>
    <?php
    if (retRequest('oper') != "Inserir") {
      CriaRelatorio($idrel);
    };
    ?>
  </body>
</html>
