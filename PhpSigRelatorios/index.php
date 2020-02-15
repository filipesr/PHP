<?php
session_name("SigRelatorio");
session_start();

// Version
define('VERSION', '1.5.4');

// Configuration
require_once('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            *{
                font-family: monospace;
                color: black;
            }
            div{
                width: 300px;
                color:#060;
            }
            input{
                border:#030 solid 1px;
                border-radius: 5px;
                background-color:#AFA;
                color:#060;
            }
            .painelLogin{
                border: 1px darkgreen dotted;
                text-align: center;
                border-radius: 10px;
                margin: 10px;
                padding: 10px;
            }
            .txtLogin{}
            .txtSenha{}
            .btLogar{}
            .msgErro{
                margin-top: 10px;
                background-color:#F66;
                border: solid 1px #990000;
                border-radius: 5px;
                color:white;
            }
        </style>
        <title>SigRelatorio</title>
    </head>
    <body>
        <div class="painelLogin">
        	<form action="<?php echo HTTP_SERVER; ?>listaArquivos.php" method="post">
                <div class="txtLogin">
                    usuário: <input type="text" name="login">
                </div>
                <div class="txtSenha">
                    senha: <input type="password" name="pass">
                </div>
                <div class="btLogar">
                    <input type="submit" value="Logar">
                </div>
                <?php if(isset($_GET['msgErro'])){ ?>
                <div class="msgErro">
                    <?php echo $_GET['msgErro']; ?>
                </div>
                <?php } ?>
            </form>
        </div>
    </body>
</html>
