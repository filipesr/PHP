<?php $modulotab = "tos"; ?>
<?php
require("../loga.php");
$idos = vrIF(retRequest('idos'), "", NextAI('tos'));
if ($idos < 10) {
  $idos = "0" . $idos;
};
?>
<html><body>
    <table>
      <form method="POST" action="envia_cad<?php echo $modulotab ?>.php" name="<?php echo $modulotab ?>">
        <input name="oper" type="hidden" value="<?php echo retRequest('oper') ?>">
        <input class="form03" name="idos" type="hidden" value="<?php echo $idos ?>">
        <tr><td >&nbsp;Cod.OS</td><td ><?php echo $idos ?></td></tr
        ><tr><td >&nbsp;Carro</td><td >
            <?php selComb("idcar", retRequest('idcar'), "select idcar,CONCAT(marca, ' | ', modelo, ' - placa: ', placa) as carro from tcar order by carro"); ?></td></tr>
        <tr><td >&nbsp;Data</td><td ><?php dtCal($modulotab, "dtOS", retRequest('dtos')); ?></td></tr>
        <tr><td  colspan="2" align="center">&nbsp;<input name="Submit" type="submit" class="form01" value="Salvar" /></form></td></tr>
  <tr id="titemos" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>"><td  colspan="4" bgcolor="#000000" height="1"></td></tr>
  <tr id="titemos" style="display:<?php echo vrIF(retRequest('oper'), "Inserir", "none") ?>">
    <td valign="top">Servi�os</td>
    <td  colspan="2">
      <iframe src="titemos.php?pesq=none&idos=<?php echo $idos ?>" frameborder="0" scrolling="no" height="<?php echo RetVar("select count(vrItemOS) from titemos where idos = $idos") * 25 + 100; ?>" width="600"></iframe>
    </td>
  </tr>
</table>
</body></html>
