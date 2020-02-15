<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require('./class/ClassesObjetos.class.php');
        
        $teste = new ClassesObjetos();
        $teste->getClass('De introdução', 'mostrar uma classe');
        $teste->verClass();
        
        $teste->Classe = "Abacaxi";
        $teste->Funcao = "Pina Colada";
        $teste->verClass();
        ?>
    </body>
</html>
