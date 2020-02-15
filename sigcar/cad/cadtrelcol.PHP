<?php $modulotab = "trelcol"; ?>
<?php
require("../loga.php");
$idrelCol = vrIF(retRequest('idrelcol'), "", NextAI('trelcol'));
if ($idrelCol < 10) {
  $idrelCol = "0" . $idrelCol;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq') ?>">
        <input name="idrelcol" type="hidden" value="<?php echo retRequest('idrelcol') ?>">
        <?php if (retRequest('idrel') != "") { ?>
          <input name="idrel" type="hidden" value="<?php echo retRequest('idrel') ?>">
          <?php
        }
        if (retRequest('pesq') == "") {
          ?>
          <tr><td >&nbsp;Relat�rio</td><td >
              <?php if (retRequest('oper') == "Inserir") { ?>
                <?php selComb("idrel", retRequest("idrel"), "select idrel,reltit from trel order by reltit"); ?>
                <?php
              }
              else {
                echo retRequest('idrel');
              }
              ?>
            </td></tr>
        <?php }
        ?>
        <tr><td>&nbsp;Titulo da Coluna</td><td><input class="form03" name="relcoltit" value="<?php echo retRequest('relcoltit'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Coluna</td><td><input class="form03" name="relcol" value="<?php echo retRequest('relcol'); ?>" type="Text"></td></tr>
        <tr><td>&nbsp;Funcao</td><td><?php selComb("idrelFunc", retRequest("idrelfunc"), "select idrelFunc,FuncDesc from trelfunc order by FuncDesc"); ?></td></tr>
        <tr><td>&nbsp;Agrupar</td><td><?php selCombSNX("Agrup", retRequest('agrup')); ?></td></tr>
        <tr><td>&nbsp;Ordem</td><td><input class="form03" name="ord" value="<?php echo retRequest('ord'); ?>" type="Number"></td></tr>
        <tr><td>&nbsp;Mostrar</td><td><?php selCombSNX("Mostrar", retRequest('mostrar')); ?></td></tr>
        <tr><td colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></td></tr>
    </table>
  </form>
</body></html>
