<?php
session_start(); //iniciamos a sess�o que foi aberta
session_destroy(); //pei!!! destruimos a sess�o ;)
session_unset(); //limpamos as variaveis globais das sess�es
include "functions.php"; // Executa a cl�usula SQL
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Margel Ve&iacute;culos</title>
    <style type="text/css">
      <!--
      body {
        background-image: url(imagens/bg_page.jpg);
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        background-color: #DEDEDC;
      }
      .style1 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
        color: #FFFFFF;
      }
      .style2 {font-size: 12px; color: #999999; font-family: Verdana, Arial, Helvetica, sans-serif;}
      .style3 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
        color: red;
      }
      -->
    </style>
    <link href="css/form.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" background="imagens/pic_top.jpg"><img src="imagens/logo.jpg" width="89" height="20" /></td>
      </tr>
    </table>
    <table width="100%" height="100%" border="0">
      <tr>
        <td height="268" align="center" valign="middle"><p>&nbsp;</p>
          <table width="294" align="center">
            <tr>
              <td width="295"><img src="imagens/id_panel.jpg" width="294" height="62" /></td>
            </tr>
            <tr>
              <td width="294" height="169" align="center" valign="middle" background="imagens/bg_login.jpg">
                <form id="Login" name="Login" method="POST" action="loga.php">
                  <table width="51%" border="0">
                    <tr>
                      <td align="left"><span class="style1">login</span></td>
                    </tr>

                    <tr>
                      <td align="left" class="style1"><input name="lnome" type="text" class="tlogin" /></td>
                    </tr>
                    <tr>
                      <td align="left" class="style1">senha</td>
                    </tr>
                    <tr>
                      <td align="left"><input name="lsenha" type="password" class="tlogin" /></td>
                    </tr>
                    <tr>
                      <td height="33" align="center">
                        <label>
                          <input name="Submit" type="submit" class="form01" value="logar" />
                        </label>
                        </span>
                      </td>
                    </tr>
                  </table>
                  <?php
                  if (isset($_POST["login"]) && $_GET['login'] == "falhou") {
                    echo "<span class='style3'>" . $_GET['causa'] . "</span>";
                  }
                  ?>

                </form>
              </td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <table width="21%" border="0" align="center">
            <tr>
              <td>
                <div align="right" class="style2">
                  Painel de Controle |<br />
                  SigCar Controle de ve&iacute;culos |<br />
                  &copy; 2008-2012 |<br />
                  Todos os direitos reservados &reg; |<br />
                  by connect consulting | 
                </div>
              </td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
  </body>
</html>
