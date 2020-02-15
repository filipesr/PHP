<?php $modulotab = "tcar"; ?>
<?php
require("../loga.php");
$idcar = retRequest('idcar');
?>
<html><body>
  <form method="post" action="envia_cadtcarfotos.php" enctype="multipart/form-data">
    <input name="oper" type="hidden" value="Editar">
    <input class="form03" name="idcar" type="hidden" value="<?php echo $idcar; ?>">
  <table><tr style="<?php echo $TitItem ?>">
      <td>&nbsp;Marca</td>
      <td>&nbsp;Modelo</td>
      <td>&nbsp;Ano</td>
      <td>&nbsp;Chassi</td>
      <td>&nbsp;Cor</td>
      <td>&nbsp;Portas</td>
      <td>&nbsp;Placa</td>
      <td nowrap >&nbsp;</td>
      <?php
      $colspan = 16;
//Executa a consulta
      $sql = "Select *, CONCAT(ano_fab,'/',ano_mod) as ano from tcar WHERE idcar=$idcar ";
      $res = sqlexec($id, $sql);
//Exibe as linhas encontradas na consulta
      $l = 0;
      while ($row = mysql_fetch_array($res)) {
        $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
        $l++;
        ?>
      <tr style="<?php echo $style; ?>">
        <td >&nbsp;<?php echo $row['marca']; ?></td>
        <td >&nbsp;<?php echo $row['modelo']; ?></td>
        <td >&nbsp;<?php echo $row['ano']; ?></td>
        <td >&nbsp;<?php echo $row['chassi']; ?></td>
        <td >&nbsp;<?php echo $row['cor']; ?></td>
        <td >&nbsp;<?php echo $row['portas']; ?></td>
        <td >&nbsp;<?php echo $row['placa']; ?></td>
	</tr><tr><td colspan="7" style="<?php echo $style; ?>">
      <table>
    	<tr><td><img src="<?php echo $home . "/imagens/fotos/" . $row['foto1']; ?>"><br><input type="file" name="foto1" id="foto1"> </td></tr>
    	<tr><td><img src="<?php echo $home . "/imagens/fotos/" . $row['foto2']; ?>"><br><input type="file" name="foto2" id="foto2"> </td></tr>
    	<tr><td><img src="<?php echo $home . "/imagens/fotos/" . $row['foto3']; ?>"><br><input type="file" name="foto3" id="foto3"> </td></tr>
    	<tr><td><img src="<?php echo $home . "/imagens/fotos/" . $row['foto4']; ?>"><br><input type="file" name="foto4" id="foto4"> </td></tr>
    	<tr><td><img src="<?php echo $home . "/imagens/fotos/" . $row['foto5']; ?>"><br><input type="file" name="foto5" id="foto5"> </td></tr>
      </table></td>
    </tr>
    <tr><td colspan="7" style="<?php echo $style; ?>"><center><?php if (retRequest('oper') == "Editar") { ?> 
    <input class="btEdt" type="submit" value="Salvar"><?php }; ?> <input class="btEdt" type="button" onClick="javascript:if (confirm('&quot;Tem certeza?&quot;')){history.go(-1);return true;}" value="Voltar"></center></td></tr>
    <?php
  }
  ?>
</table></form></body></html>
