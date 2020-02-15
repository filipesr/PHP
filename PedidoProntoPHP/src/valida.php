<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (phpversion() >= 5.4):
            echo phpversion() . " Olá mundo, podemos programar!";
        else:
            echo "Sua versão de PHP está desatualizada! Atualize para a versão 5.4 ou superior! Versão atual: " . phpversion();
        endif;
        
        echo ini_get("date.timezone");
       
        ?>
    </body>
</html>
