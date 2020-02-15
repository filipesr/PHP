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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- saved from url=(0014)about:internet -->
<html>
<head>
<title>OrlaOnline</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
}
.TvOrla {
	width:85%;
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
-->
</style>
</head>
<body bgcolor="#ffffff">
<table width="949" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <tr>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="216" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="111" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="337" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="161" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="124" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1"   height="1"></td>
  </tr>

  <tr>
   <td><img name="logo" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/logo.gif" width="216" height="70" border="0" alt=""></td>
   <td rowspan="2" colspan="4" valign="middle" align="center"><jdoc:include type="modules" name="bannersuper" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="70" border="0" alt=""></td>
  </tr>
  <tr>
   <td valign="top" align="center"><p style="margin:0px"><?php echo date("d")." de ".$mes." de ".date("Y"); ?></p></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="5"><img name="slice_04" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_04.gif" width="949" height="5" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="5" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="4" valign="top" background=" <?php echo $this->baseurl ?>/templates/orlaonlinev2/images/menubkg.gif"><jdoc:include type="modules" name="menutopo" /></td>
   <td align="center" valign="middle" background=" <?php echo $this->baseurl ?>/templates/orlaonlinev2/images/menubkg.gif"><jdoc:include type="modules" name="procura" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="4"><img name="slice_08" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_08.gif" width="811" height="22" border="0" alt=""></td>
   <td><img name="slice_09" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_09.gif" width="116" height="22" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="22" border="0" alt=""></td>
  </tr>
  <tr>
<?php if($this->countModules('colesq')) : ?>
   <td rowspan="2" colspan="2" valign="top" align="center"><jdoc:include type="modules" name="colesq" /></td>
<?php endif; ?>
   <td <?php if(!$this->countModules('colesq')) : ?> colspan="3" <?php endif; ?> valign="top" align="center"><jdoc:include type="message" /><jdoc:include type="component" /><jdoc:include type="modules" name="colmid" /></td>
   <td colspan="3" valign="top" align="center"><jdoc:include type="modules" name="coldir" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="1048" border="0" alt=""></td>
  </tr>
<?php if($this->countModules('bannerfull')) : ?>
  <tr>
   <td colspan="4" valign="top"><jdoc:include type="modules" name="bannerfull" /></p></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="78" border="0" alt=""></td>
  </tr>
<?php endif; ?>
<?php if($this->countModules('bot')) : ?>
  <tr>
   <td colspan="6" valign="top"><jdoc:include type="modules" name="bot" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="243" border="0" alt=""></td>
  </tr>
<?php endif; ?>
  <tr>
   <td colspan="6"><img name="slice_15" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_15.gif" width="949" height="8" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="8" border="0" alt=""></td>
  </tr>
<?php if($this->countModules('bannersuperfoot')) : ?>
  <tr>
   <td colspan="6" valign="top" align="center"><jdoc:include type="modules" name="bannersuperfoot" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="90" border="0" alt=""></td>
  </tr>
<?php endif; ?>
  <tr>
   <td colspan="6"><img name="slice_17" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_17.gif" width="949" height="10" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="10" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="6" bgcolor="#879FDF" style="font-size:14px; color:#FFFFFF" valign="middle" align="center"><jdoc:include type="modules" name="direitos" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="26" border="0" alt=""></td>
  </tr>
</table>
</body>
</html>
