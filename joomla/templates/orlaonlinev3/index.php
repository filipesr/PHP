<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

switch (date("m")) {
        case "01":    $mes = Janeiro;     break;
        case "02":    $mes = Fevereiro;   break;
        case "03":    $mes = Março;       break;
        case "04":    $mes = Abril;       break;
        case "05":    $mes = Maio;        break;
        case "06":    $mes = Junho;       break;
        case "07":    $mes = Julho;       break;
        case "08":    $mes = Agosto;      break;
        case "09":    $mes = Setembro;    break;
        case "10":    $mes = Outubro;     break;
        case "11":    $mes = Novembro;    break;
        case "12":    $mes = Dezembro;    break; 
 }


?>
<?php
	$debug = true;
	$largEsp = 10;
	$largPag = 960;
	$largLogo = 216;
	$largProc = 120;
	$largEsq = $largPag / 3 - $largEsp;
	$largDir = 240;
	$largMeio = $largPag - $largEsq - $largDir - $largEsp - $largEsp;
	$leftMeio = $largEsq + $largEsp;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OrlaOnline</title>
<style>
	div {
		border:none;
		overflow:hidden;
	}
<?php if ($degug) {?>
	#div1 {
		background:#CCCCCC;
	}
	#div2 {
		background:#99CCFF;
	}
	#div3 {
		background:#FF6600;
	}
	#div4 {
		background:#006600;
	}
	#div5 {
		background:#0099CC;
	}
<?php }?>
	#divEsp {
		height:<?php echo $largEsp?>px;;
	}
</style>
<style type="text/css">
<!--
*  {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.mainlevel  {
	color: #FFFFFF;
	text-decoration: none;
	vertical-align:bottom;
	line-height: 20px;
	font-size:12px;
	white-space:nowrap;
}
.inputboxpesq {
	font-size: 9px;
	height: 11px;
	border: none;
	text-align:center;
}
.TitAzul, .styleTit2, .gn_header_1, .gn_header_2, .gn_header_3, .gn_header_4, .gn_header_5, .gn_header_6 {
	text-align:justify;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #77B698;
	border-bottom-width: medium;
	border-bottom-style: solid;
	margin-bottom:5px;
}
.gn_static_1, .gn_static_2, .gn_static_3, .gn_static_4, .gn_static_5, .gn_static_6 {
	text-align:justify;
}
.gn_static_2 {
	height:15px;
	
}
.EmCimaDaHora {
	width:100%;
}
img {
	border:none;
}
.NotAll, .gn_static_3, .gn_static_4{
	padding:5px;
}
.NotBot{
	width:32%;
}
.PoolButton {
	border:solid 1px #0099FF;
	outline: solid 1px #0099FF;
	background-color:#CED1FF;
}
a {
	color:#000000;
	text-decoration:none;
}
a:hover {
	background-color:#CCCCFF;

}-->
</style>
</head>

<body>
<center>
  <div id="div1" style="width:<?php echo $largPag?>px;">
    <div id="div2">
      <div id="div3">
        <!-- Logo -->
        <div id="div4" style="width:<?php echo $largLogo?>px; float:left">
          <img name="logo" src="<?php echo $this->baseurl ?>/templates/orlaonlinev3/images/logo.gif" width="216" height="70" border="0" alt=""><br />
		  <?php echo date("d")." de ".$mes." de ".date("Y"); ?>
        </div>
        <!-- Banner Topo -->
        <div id="div4" style="width:<?php echo $largPag - $largLogo - $largEsp?>px; margin-left:<?php echo $largLogo + $largEsp ?>px">
		  <jdoc:include type="modules" name="bannersuper" />
        </div>
      </div>
      <div id="divEsp"></div>
      <div id="div3" style="background:url(<?php echo $this->baseurl ?>/templates/orlaonlinev3/images/menubkg.gif)">
        <!-- Menu -->
        <div id="div4" style="width:<?php echo $largPag - $largProc - $largEsp?>px; float:left">
          <jdoc:include type="modules" name="menutopo" />
        </div>
        <!-- Procura -->
        <div id="div4" style="width:<?php echo $largPorc ?>px; margin-left:<?php echo $largPag - $largProc ?>px; margin-top:4px">
          <jdoc:include type="modules" name="procura" />
        </div>
      </div>
    </div id="div3">
    <div id="divEsp"></div>
    <div id="div3">
<?php if($this->countModules('colesq')) : ?>
        <!-- Coluna Esquerda -->
      <div id="div4" style="width:<?php echo $largEsq?>px; float:left">
        <jdoc:include type="modules" name="colesq" />
      </div>
<?php endif; ?>
<?php 
if(!$this->countModules('colesq')) : 
	$largMeio += $largEsq + $largEsp;
	$leftMeio  = $leftEsq;
endif; 
?>
      <div id="div4" style="width:<?php echo $largMeio + $largDir + $largEsp?>px; margin-left:<?php echo $leftMeio?>px">
        <!-- Coluna Central -->
        <div id="div5" style="width:<?php echo $largMeio?>px; float:left">
          <jdoc:include type="message" />
          <jdoc:include type="component" />
          <jdoc:include type="modules" name="colmid" />
        </div>
        <!-- Coluna Direita -->
        <div id="div5" style="width:<?php echo $largDir?>px; margin-left:<?php echo $largMeio + $largEsp?>px">
          <jdoc:include type="modules" name="coldir" />
        </div>
<?php if($this->countModules('bannerfull')) : ?>
    	<div id="divEsp"></div>
        <!-- Banner Meio + Direita -->
        <div id="div5" style="width:100%; float:left;">
          <div align="center"><jdoc:include type="modules" name="bannerfull" /></div>
        </div>
<?php endif; ?>
      </div>
    </div>
<?php if($this->countModules('bot')) : ?>
    <div id="divEsp"></div>
        <!-- Rodapé de notícias -->
    <div id="div3">
      <jdoc:include type="modules" name="bot" />
    </div>
<?php endif; ?>
<?php if($this->countModules('bannersuperfoot')) : ?>
    <div id="divEsp"></div>
        <!-- Banner Rodapé -->
    <div id="div3">
      <jdoc:include type="modules" name="bannersuperfoot" />
    </div>
<?php endif; ?>
    <div id="divEsp"></div>
        <!-- Direitos Autorais -->
    <div id="div3" style="background-color:#879FDF">
      <jdoc:include type="modules" name="direitos" />
    </div>
  </div>
</center>
</body>
</html>