<?php $modulotab="trelcol"; ?>
<?php require("../loga.php"); ?>
<html><body>

<table id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'),"","block")?>"><tr>
<form method="POST" action="<?php echo $home;?>/cad/<?php echo $modulotab?>.php" name="<?php echo $modulotab?>">
<form action="<?php echo $home;?>/cad/trelcol.php" method="POST" name="trelcol">
<?php $w .= retRequest('relcoltit', "AND relcoltit LIKE '%", "%'"); ?>
<td>&nbsp;relcoltit</td><td><input class="form03" name="relcoltit" value="<?php echo retRequest('relcoltit'); ?>" type="Text"></td>
<?php $w .= retRequest('idrelfunc', "AND idrelfunc = '", "'"); ?>
<td>&nbsp;idrelfunc</td><td><?php selComb("idrelfunc", retRequest("idrelfunc"), "select idrelfunc,funcdesc from trelfunc order by funcdesc");?></td>
<?php $w .= retRequest('idrel', "AND idrel = '", "'"); ?>
<?php $w .= retRequest('idrel', "AND idrel = '", "'"); ?>
<td>&nbsp;idrel</td><td><?php selComb("idrel", retRequest("idrel"), "select idrel,reltit from trel order by reltit");?></td>
<?php $w .= retRequest('relcol', "AND relcol LIKE '%", "%'"); ?>
<td>&nbsp;relcol</td><td><input class="form03" name="relcol" value="<?php echo retRequest('relcol'); ?>" type="Text"></td>
<?php $w .= retRequest('agrup', "AND agrup = '", "'"); ?>
<td>&nbsp;agrup</td><td><?php selCombSN("agrup", retRequest('agrup'));?></td>
<?php $w .= retRequest('ord', "AND Ord = '", "'"); ?>
<td>&nbsp;Ord</td><td><input class="form03" name="ord" value="<?php echo retRequest('ord'); ?>" type="Number"></td>
<?php $w .= retRequest('mostrar', "AND mostrar = '", "'"); ?>
<td>&nbsp;Mostrar</td><td><?php selCombSN("mostrar", retRequest('mostrar'));?></td>
<td><input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar"><input class="btPesq" name="Limpar" value="Limpar" type="reset"> <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999')" src="../imagens/ocultpesq.gif"></td></form></tr></table>

<table><tr style="<?php echo $TitItem?>">
<td style="display:<?php echo vrIF(retRequest('pesq'),"","block")?>"><?php aTit("idrel","idrel")?></td>
<td><?php aTit("relcoltit","T&iacute;tulo da Coluna")?></td>
<td><?php aTit("relcol","Coluna")?></td>
<td><?php aTit("funcdesc","Fun&ccedil;&atilde;o")?></td>
<td><?php aTit("agrup","agrupar")?></td>
<td><?php aTit("mostrar","Mostrar")?></td>
<td><?php aTit("ord","Ordem")?></td>
<td nowrap>&nbsp;</td>
<?php
  $colspan=11;
  //Executa a consulta
  $sql="Select *, (select funcdesc from trelfunc where idrelfunc = trelcol.idrelfunc) as funcdesc from trelcol WHERE 1=1 ".$w;
  $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
  //Exibe as linhas encontradas na consulta
  $l=0;
  while ($row = mysql_fetch_array($res)) {
    $style=$l%2==0?$ItemPar:$ItemImpar;
    $l++;
?>
  <tr style="<?php echo $style;?>">
		<form action="<?php echo $home;?>/cad/cadtrelcol.php" method="POST" name="trelcol">
    <input name="idrel" type="hidden" value="<?php echo $_POST['idrel'];?>">
		<input name="pesq" type="hidden" value="<?php echo retRequest('pesq');?>">
		<input name="oper" type="hidden" value="Editar">
		<input class="form03" name="idrelcol" type="hidden" value="<?php echo $row['idrelcol'];?>">
		<input class="form03" name="idrel" type="hidden" value="<?php echo $row['idrel'];?>">
		<td style="display:<?php echo vrIF(retRequest('pesq'),"","block")?>">&nbsp;<?php echo $row['idrel'];?></td>
		<input class="form03" name="relcoltit" type="hidden" value="<?php echo $row['relcoltit'];?>">
		<td>&nbsp;<?php echo $row['relcoltit'];?></td>
		<input class="form03" name="relcol" type="hidden" value="<?php echo $row['relcol'];?>">
		<td>&nbsp;<?php echo $row['relcol'];?></td>
		<input class="form03" name="idrelfunc" type="hidden" value="<?php echo $row['idrelfunc'];?>">
		<td>&nbsp;<?php echo $row['funcdesc'];?></td>
		<input class="form03" name="agrup" type="hidden" value="<?php echo $row['agrup'];?>">
		<td>&nbsp;<?php echo ($row['agrup']==1)?"sim":"n&atilde;o";?></td>
		<input class="form03" name="mostrar" type="hidden" value="<?php echo $row['mostrar'];?>">
		<td>&nbsp;<?php echo ($row['mostrar']==1)?"sim":"n&atilde;o";?></td>
		<input class="form03" name="ord" type="hidden" value="<?php echo $row['ord'];?>">
		<td>&nbsp;<?php echo $row['ord'];?></td>
		<td>&nbsp;<input class="btEdt" type="submit" value="Editar">
    </td></form>
      <form name="Exc<?php echo $row['idrelcol'];?>" action="<?php echo $home;?>/cad/envia_cad<?php echo $modulotab?>.php" method="POST">
      <input name="idrelcol" type="hidden" value="<?php echo $row['idrelcol'];?>">
      <input name="pesq" type="hidden" value="<?php echo retRequest('pesq');?>">
      <input name="idrel" type="hidden" value="<?php echo $row['idrel'];?>">
      <input name="oper" type="hidden" value="Apagar">
		<td>&nbsp;<input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm(&quot;Tem certeza?&quot;)){document.Exc<?php echo $row['idrelcol'];?>.submit();}" value="Excluir">
    </td></form>
  </tr>
<?php
}
?>
<tr>
  <td colspan="<?php echo $colspan;?>">&nbsp;<div align="center">
    <form action="<?php echo $home;?>/cad/cad<?php echo $modulotab?>.php" method="POST">
      <input name="oper" type="hidden" value="Inserir">
      <input name="pesq" type="hidden" value="<?php echo retRequest('pesq');?>">
      <input name="idrel" type="hidden" value="<?php echo retRequest('idrel');?>">
      <input class="btIns" type="submit" value="Inserir">
    </form></div>
  </td>
</tr>
</table></body></html>
