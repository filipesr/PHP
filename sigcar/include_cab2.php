<script language="JavaScript" src="<?php echo $home . "/" ?>funcoes.js" type="text/javascript"></script>
<link href="<?php echo $home . "/" ?>css/body.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $home . "/" ?>css/borders.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $home . "/" ?>css/form.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $home . "/" ?>css/text.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $home . "/" ?>css/calendar.css" rel="stylesheet" type="text/css"/>
  <table width="100%" cellpadding="0" cellspacing="0" id="Detail_999999" style="display:<?php echo vrIF(retRequest('pesq'), "", "block") ?>">
    <tr valign="top">
      <td colspan="2" align="left" background="<?php echo $home . "/" ?>imagens/pic_top.jpg">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td onClick="javascript:detailbox('0')"><img src="<?php echo $home . "/" ?>imagens/logo.jpg" width="89" height="20" /></td>
            <td valign="middle"><font color="#FFFFFF" face="Verdana" size="2">- <?php echo RetVar("SELECT modulodesc FROM tmodulo WHERE modulotab = '" . $modulotab . "'"); ?> - <strong><a style="color:#900" href="http://www.facebook.com/sharer.php?u=<?php echo 'www.fsrezende.com.br';?>&t=SigCar" title="Compartilhar" target="blank"></strong></font>Compartilhar</a></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr id="Detail_0">
      <td align="left" background="<?php echo $home . "/" ?>imagens/bgmenu.jpg">
        <?php
        //Executa a consulta
        $w = ""; //width='50'";
        if (RetVar("SELECT idgrupoacesso FROM tuser WHERE login='$llogin' AND pass='$lsenha'") == 1) {
          $sql = "select modulotab, modulodesc, CONCAT('adm/',modulotab) as img from tmodulo order by ord, idmodulo";
        }
        else {
          $sql = "select m.modulotab, m.modulodesc, CONCAT('/',modulotab) as img from tmodulo m where idmodulo in(select a.idmodulo from tacesso a where a.Menu=1 and a.idgrupoacesso in (select u.idgrupoacesso from tuser u where u.login='$llogin' and u.pass='$lsenha')) order by ord";
        };
        $res = sqlexec($id, $sql);
        //Exibe as linhas encontradas na consulta
        while ($row = mysql_fetch_array($res)) {
          echo "<a href='" . $home . "/cad/" . $row['modulotab'] . ".php' title='" . $row['modulodesc'] . "'><img src='" . $home . "/imagens/btns" . $row['img'] . ".jpg' border='0' " . $w . "></a>";
        }
        ?>
      </td>
    </tr>
  </table>
