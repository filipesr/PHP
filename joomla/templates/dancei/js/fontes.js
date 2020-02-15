// JavaScript Document
/** 
 * change font acessibility, for  Detection
*/
function sizeFont2 (elem, acao)
{
    // tamanho inicial da fonte (em px)
    var tamInic = 16;
    
    // Tamanho m�nimo da fonte (em px)
    var tamMin = 12;
    
    // Tamanho m�ximo da fonte (em px)
    var tamMax = 22;

    // Pega o tamanho da fonte. Se n�o foi setada ainda (primeira vez
    // que a fun��o � executada) ter� como tamanho padr�o 'tamInic'.
    if (document.getElementById(elem).style.fontSize == "") 
      var tamFonte = tamInic;
    else
      var tamFonte = parseInt(document.getElementById(elem).style.fontSize);
    switch (acao)
    {
      // Aumenta o tamanho, enquanto foi menor que 'tamMax'
      case '+':
        if (tamFonte < tamMax)
          document.getElementById(elem).style.fontSize = (tamFonte + 2) + "px";
      break;
      
      // Diminui o tamanbo, enquanto for maior que 'tamMin'
      case '-':
        if (tamFonte > tamMin)
          document.getElementById(elem).style.fontSize = (tamFonte - 2) + "px";
      break;
    }
}