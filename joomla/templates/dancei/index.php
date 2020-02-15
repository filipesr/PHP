<?php 
defined('_JEXEC') or die('Restricted access');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
	<jdoc:include type="head" />
	<!-- folha de estilos -->
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/dancei/css/template_css.css" type="text/css" />
    <!-- função para aumento de tela -->
	<script language="javascript" src="<?php echo $this->baseurl ?>/templates/dancei/js/fontes.js"	type="text/javascript"></script>
	<!-- chamada ao flash de forma acessível - início -->
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/dancei/js/flash.js"></script>
    <!-- chamada ao flash de forma acessível - fim -->
	
	</head>

<body>
<div id="site">
<div id="unb">
  <div id="icones">
<ul id="topmenu">
  <table width="100%"  border="0">

  <tr>

    <td width="6%" valign="top"><a href="index.php?option=com_joomap&Itemid=26" title="mapa do website"><img src="<?php echo $this->baseurl ?>/templates/dancei/images/mapa_icone.jpg" width="38" height="34" border="0" align="absmiddle" /></a></td>

    <td width="27%">mapa do site</td>

	<td width="29%" >tamanho da letra</td>

    <td width="38%" valign="top">		

		<a href="javascript:sizeFont2('site','+');void(0);" title="aumentar tamanho do texto" /><img src="<?php echo $this->baseurl ?>/templates/dancei/images/amais_icone.jpg" width="33" height="33" border="0" align="absmiddle" /></a>

		&nbsp;<a href="javascript:sizeFont2('site','-');void(0);" title="diminuir tamanho do texto" /><img src="<?php echo $this->baseurl ?>/templates/dancei/images/amenos_icone.jpg" width="32" height="33" border="0" align="absbottom" /> </a>

	</td>

  </tr>

</table>
</ul>		
</div>
<div id="busca">

<table width="100%"  border="0">

  <tr>

    <td width="5%"> <img src="<?php echo $this->baseurl ?>/templates/dancei/images/busca_icone.jpg" width="29" height="26" /></td>

    <td width="95%" align="left">  <jdoc:include type="modules" name="user4" /></td>

  </tr>

</table>			  
</div>
</div>
				
				
<div id="header">
  <div align="center"><a href="#"></a>
    <!-- carregando o flash de forma acessível - início -->
<script type="text/javascript"> 
<!--
new Flash("<?php echo $this->baseurl ?>/templates/dancei/swf/topo.swf", "TesteSWF", "780", "170", {wmode: "transparent", showMenu: "false"}).write();
//--> 
</script>
<!-- carregando o flash de forma acessível - fim -->
  </div>
</div>
<div id="menu">
	<jdoc:include type="modules" name="top" style="" />
</div>
<div id="conteudo">
<!-- Caminho de migalhas-->
>> <jdoc:include type="modules" name="breadcrumb" />
<hr width="100%" color="#000" />
<!-- Depoimentos-->
<jdoc:include type="modules" name="depoimento" />

<!-- conteudo da homepage -->
<jdoc:include type="component" />
</div>

<div id ="menulateral">
  <h4><img src="<?php echo $this->baseurl ?>/templates/dancei/images/destaques.jpg" width="105" height="23" /></h4>
  <!-- conteudo do módulo right -->
  <jdoc:include type="modules" name="right" style="xhtml" />
</div>
<div class="texto" id="rodape">
  <jdoc:include type="modules" name="footer" style="xhtml"/>
</div>
</div>
</body>

</html>
