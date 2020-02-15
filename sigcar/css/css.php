<?php
// Variaveis de estilo
$TitItem = "font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-decoration: none;font-weight: bold;"; // Titulo Tabela
$TitSub = "font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;text-decoration: none;font-weight: bold;";  // Titulo Detalhe
$CorDestaque = "#AAAAFF";
$ItemPar = "\" onmouseover= this.style.backgroundColor='$CorDestaque' onmouseout= this.style.backgroundColor=\"transparent";
$ItemImpar = "background-color:#E0E0E0\" onmouseover= this.style.backgroundColor='$CorDestaque' onmouseout= this.style.backgroundColor=\"#E0E0E0";
$SubPar = "";
$SubPar = $ItemPar;
$SubImpar = "background-color:#E0E0E0";
$SubImpar = $ItemImpar;
?> 
<style type="text/css">
  a:link {<?php echo $TitItem ?>}
  a:visited {<?php echo $TitItem ?>}
  a:hover {<?php echo $TitItem ?>}
  a:active {<?php echo $TitItem ?>}
</style>
