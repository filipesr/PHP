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
}
.pesqinputbox {
	font-size: 9px;
	height: 11px;
	text-align:center;
}
.gn_static_1 {
	text-align:justify;
}
.bannergroupNW {

}
img {
	border:none;
}

-->
</style>
</head>
<body bgcolor="#ffffff">
<table width="949" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <tr>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="216" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="287" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="136" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="194" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="116" height="1"></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1"   height="1"></td>
  </tr>

  <tr>
   <td><img name="logo" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/logo.gif" width="216" height="70" border="0" alt=""></td>
   <td rowspan="2" colspan="5" valign="middle" align="center"><jdoc:include type="modules" name="bannersuper" /></td>
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
   <td  valign="middle" background=" <?php echo $this->baseurl ?>/templates/orlaonlinev2/images/menubkg.gif"><jdoc:include type="modules" name="procura" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="5"><img name="slice_08" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_08.gif" width="811" height="22" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="22" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="2" valign="top" align="justify"><jdoc:include type="message" /><jdoc:include type="component" /><jdoc:include type="modules" name="colesq" /></td>
   <td valign="top" align="justify">[*****************************************]<jdoc:include type="modules" name="colmid" /></td>
   <td colspan="2" valign="top" align="justify"><jdoc:include type="modules" name="coldir" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="1293" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="5"><img name="slice_17" src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/slice_17.gif" width="949" height="10" border="0" alt=""></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="22" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="5" bgcolor="#879FDF" style="font-size:14px; color:#FFFFFF" valign="middle" align="center"><jdoc:include type="modules" name="direitos" /></td>
   <td><img src="<?php echo $this->baseurl ?>/templates/orlaonlinev2/images/spacer.gif" width="1" height="26" border="0" alt=""></td>
  </tr>
</table>
</body>
</html>
