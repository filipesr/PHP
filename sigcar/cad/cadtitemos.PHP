<?php $modulotab = "titemos"; ?>
<?php require("../loga.php"); ?>
<html><body>
    <table>
      <form method="POST" action="envia_cadtitemos.php" name="titemos">
        <input name="pesq" type="hidden" value="<?php echo retRequest('pesq'); ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input name="iditemos" type="hidden" value="<?php echo retRequest('iditemos') ?>">
        <?php if (retRequest('idos') != "") { ?>
          <input name="idos" value="<?php echo retRequest('idos') ?>" type="hidden">
          <?php
        }
        if (retRequest('pesq') == "") {
          ?>
          <tr><td >&nbsp;Cod.OS</td><td >
              <?php if (retRequest('oper') == "Inserir") { ?>
                <input class="form03" name="idos" value="<?php echo retRequest('idos'); ?>" type="text">
                <?php
              }
              else {
                echo retRequest('idos');
              }
              ?>
            </td></tr>
        <?php }
        ?>
        <tr><td >&nbsp;Servi�o</td><td >
            <?php selComb("idservice", retRequest('idservice'), "select idservice,CONCAT(servicedesc,' R$ ',price) as det from tservice order by det"); ?></td></tr>
        <tr><td >&nbsp;Valor</td><td ><input class="form03" name="vritemos" value="<?php echo retRequest('vritemos'); ?>" type="text"></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></form></td></tr>
</table>
</body></html>
