<!--
function impressao(urlStr) {
  window.open(urlStr,'Popup_Window','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=500,height=500');
}

function popup_up(pagina,targ,largura,altura){
  esquerda = (screen.width - largura - 10)/2;
  topo = screen.height - 59;
  topo = (topo - altura)/2;
  param = "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=" + largura + ",height=" + altura + ",top=" + topo + ",left=" + esquerda;
  window.open(pagina,targ,param);
}

function popup(pagina,targ,largura,altura,esquerda,topo,scrollbars){
  if (scrollbars == null || scrollbars == ''){
    scrollbars = '0';
  }
  if (esquerda == null || esquerda == ''){
    esquerda = (screen.width - largura - 10)/2;
  }
  if (topo == null || topo == ''){
    topo = (screen.height - altura - 57)/2;
  }
  //	param = "fullscreen=0,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0";
  //	win = window.open("",targ,param);
  //	win.moveTo(esquerda,topo);
  //	win.resizeTo(largura,altura);
  //	param = "fullscreen=1"
  param = "fullscreen=0,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=" + scrollbars + ",resizable=0,width=" + largura + ",height=" + altura + ",top=" + topo + ",left=" + esquerda;
  win = window.open(pagina,targ,param);
  return win;
}

function Money_2_Java(num){
  novo_num = num;
  for(z=0;novo_num.lastIndexOf(".")>-1;z++){
    ult_ponto = novo_num.lastIndexOf(".");
    novo_num = novo_num.substring(0,ult_ponto) + novo_num.substring(ult_ponto+1,novo_num.length);
  }
  ult_virg = novo_num.lastIndexOf(",");
  if (ult_virg > -1){
    novo_num = novo_num.substring(0,ult_virg) + "." + novo_num.substring(ult_virg+1,novo_num.length);
  }
  return novo_num
}

function NumJava_2_Money(num){
  virg = false;
  novo_num = "";
  num = "" + num
  if (num.lastIndexOf(".") == -1){
    virg = true;
    ponto = 0
  }
  for(i=0;i<num.length;i++){
    if(num.substring(num.length-i-1,num.length-i) == "."){
      if (!virg){
        virg = true;
        ponto = 0;
        novo_num = "," + novo_num;
      }
    }else{
      if(virg){
        if (ponto == 3 && num.substring(num.length-i-1,num.length-i) != "-"){
          ponto = 0
          novo_num = "." + novo_num
        }
        ponto = ponto + 1
      }
      novo_num = num.substring(num.length-i-1,num.length-i) + novo_num;
    }
  }
  if (novo_num.lastIndexOf(",") == -1){
    novo_num = novo_num + ",00";
  }else if(novo_num.lastIndexOf(",") == novo_num.length - 2){
    novo_num = novo_num + "0";
  //	}else{
  //		novo_num = novo_num.substring(0,novo_num.lastIndexOf(",")) + novo_num.substring(novo_num.lastIndexOf(",") + 1,2);
  }
  return novo_num
}

function mascaradata(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=8) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 4 ){
        if (Digitos.indexOf(digito)>=0){
          temp = "/"+ S.charAt(0) + S.charAt(1) + S.charAt(2) + S.charAt(3)
          }
        }
    if (numero == 5 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) +"/"+ S.charAt(1) + S.charAt(2) + S.charAt(3) + S.charAt(4)
        }
      }
  if (numero == 6 ){
    if (Digitos.indexOf(digito)>=0){
      temp = "/"+ S.charAt(0) + S.charAt(1) +"/"+ S.charAt(2) + S.charAt(3) + S.charAt(4) + S.charAt(5)
      }
    }
  if (numero == 7 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) +"/"+ S.charAt(1) + S.charAt(2) +"/"+ S.charAt(3) + S.charAt(4) + S.charAt(5)+ S.charAt(6)
      }
    }
if (numero == 8 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) +"/"+ S.charAt(2) + S.charAt(3) +"/"+ S.charAt(4) + S.charAt(5) + S.charAt(6)+ S.charAt(7)
    }
  }
}
}
campo.value = temp;
}

function mascaradatahora(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=14) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 5 ){
        if (Digitos.indexOf(digito)>=0){
          temp = S.charAt(0) +"/"+ S.charAt(1) + S.charAt(2) + S.charAt(3) + S.charAt(4)
          }
        }
    if (numero == 6 ){
      if (Digitos.indexOf(digito)>=0){
        temp = "/"+ S.charAt(0) + S.charAt(1) +"/"+ S.charAt(2) + S.charAt(3) + S.charAt(4) + S.charAt(5)
        }
      }
  if (numero == 7 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) +"/"+ S.charAt(1) + S.charAt(2) +"/"+ S.charAt(3) + S.charAt(4) + S.charAt(5)+ S.charAt(6)
      }
    }
  if (numero == 8 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) +"/"+ S.charAt(2) + S.charAt(3) +"/"+ S.charAt(4) + S.charAt(5) + S.charAt(6)+ S.charAt(7)
      }
    }
if (numero == 9 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + S.charAt(2) +" "+ S.charAt(3) + S.charAt(4) + ":" + S.charAt(5) + S.charAt(6) + ":" + S.charAt(7)+ S.charAt(8)
    }
  }
if (numero == 10 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + S.charAt(2) + S.charAt(3) +" "+ S.charAt(4) + S.charAt(5) + ":" + S.charAt(6) + S.charAt(7) + ":" + S.charAt(8)+ S.charAt(9)
    }
  }
if (numero == 11 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + "/" + S.charAt(1) + S.charAt(2) + S.charAt(3) + S.charAt(4) + " " + S.charAt(5) + S.charAt(6) + ":" + S.charAt(7) + S.charAt(8) + ":" + S.charAt(9)+ S.charAt(10)
    }
  }
if (numero == 12 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + "/" + S.charAt(2) + S.charAt(3) + S.charAt(4) + S.charAt(5) + " " + S.charAt(6) + S.charAt(7) + ":" + S.charAt(8) + S.charAt(9) + ":" + S.charAt(10)+ S.charAt(11)
    }
  }
if (numero == 13 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + "/" + S.charAt(1) + S.charAt(2) + "/" + S.charAt(3) + S.charAt(4) + S.charAt(5) + S.charAt(6) + " " + S.charAt(7) + S.charAt(8) + ":" + S.charAt(9) + S.charAt(10) + ":" + S.charAt(11)+ S.charAt(12)
    }
  }
if (numero == 14 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + "/" + S.charAt(2) + S.charAt(3) + "/" + S.charAt(4) + S.charAt(5) + S.charAt(6) + S.charAt(7) + " "+ S.charAt(8) + S.charAt(9) + ":" + S.charAt(10) + S.charAt(11) + ":" + S.charAt(12)+ S.charAt(13)
    }
  }
}
}
campo.value = temp;
}

function mascarahora(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=5) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 3 ){
        if (Digitos.indexOf(digito)>=0){
          temp = S.charAt(0) + ":" + S.charAt(1)+ S.charAt(2)
          }
        }
    if (numero == 4 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) + S.charAt(1) + ":" + S.charAt(2)+ S.charAt(3)
        }
      }
  if (numero == 5 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + ":" + S.charAt(1) + S.charAt(2) + ":" + S.charAt(3)+ S.charAt(4)
      }
    }
  if (numero == 6 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) + ":" + S.charAt(2) + S.charAt(3) + ":" + S.charAt(4)+ S.charAt(5)
      }
    }
}
}
campo.value = temp;
}

function mascaracep(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=6) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 3 ){
        if (Digitos.indexOf(digito)>=0){
          temp = S.charAt(0) + "-" + S.charAt(1) + S.charAt(2) + S.charAt(3)
          }
        }
    if (numero == 4 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) + S.charAt(1) + "-" + S.charAt(2) + S.charAt(3) + S.charAt(4)
        }
      }
  if (numero == 5 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) + S.charAt(2) + "-" + S.charAt(3) + S.charAt(4) + S.charAt(5)
      }
    }
  if (numero == 6 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + "." + S.charAt(1) + S.charAt(2) + S.charAt(3) + "-" + S.charAt(4) + S.charAt(5) + S.charAt(6)
      }
    }
if (numero == 7 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + "." + S.charAt(2) + S.charAt(3) + S.charAt(4) + "-" + S.charAt(5) + S.charAt(6) + S.charAt(7)
    }
  }
}
}
//	document.formulario.CGC.value = temp;
campo.value = temp;
}

function mascarafone(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=10) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 5 ){
        if (Digitos.indexOf(digito)>=0){
          temp = S.charAt(0) +"-"+ S.charAt(1) + S.charAt(2) + S.charAt(3) + S.charAt(4)
          }
        }
    if (numero == 6 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) + S.charAt(1) +"-"+ S.charAt(2) + S.charAt(3) + S.charAt(4) + S.charAt(5)
        }
      }
  if (numero == 7 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) + S.charAt(2) +"-"+ S.charAt(3) + S.charAt(4) + S.charAt(5)+ S.charAt(6)
      }
    }
  if (numero == 8 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) + S.charAt(2) + S.charAt(3) +"-"+ S.charAt(4) + S.charAt(5) + S.charAt(6) + S.charAt(7)
      }
    }
if (numero == 9 ){
  if (Digitos.indexOf(digito)>=0){
    temp = "(" + S.charAt(0) + ") " + S.charAt(1) + S.charAt(2) + S.charAt(3) + S.charAt(4) +"-"+ S.charAt(5) + S.charAt(6) + S.charAt(7)+ S.charAt(8)
    }
  }
if (numero == 10 ){
  if (Digitos.indexOf(digito)>=0){
    temp = "(" + S.charAt(0) + S.charAt(1) + ") " + S.charAt(2) + S.charAt(3) + S.charAt(4) + S.charAt(5) +"-"+ S.charAt(6) + S.charAt(7) + S.charAt(8)+ S.charAt(9)
    }
  }
}
}
//	document.formulario.CGC.value = temp;
campo.value = temp;
}

function mascaranumero(S,campo){
  var Digitos = "0123456789";
  S = limpa_string(Money_2_Java(S));
  ini_z = false
  sem_zero = ""
  for (var i=0; i<S.length; i++){
    if (ini_z == true || S.charAt(i) != "0"){
      ini_z = true;
      sem_zero = sem_zero + S.charAt(i);
    }
  }
  S = sem_zero;
  a_virg = "";
  numero = 0;
  for (var i=0; i<S.length - 2; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (Digitos.indexOf(digito)>=0){
      a_virg = a_virg + digito
      }
  }
  if (S.length == 1){
    temp = "0.0" + S
    temp = NumJava_2_Money(temp);
  }else if (S.length == 2){
    temp = "0." + S
    temp = NumJava_2_Money(temp);
  }else if (S.length > 2){
    temp = a_virg + "." + S.charAt(S.length-2) + S.charAt(S.length-1);
    temp = NumJava_2_Money(temp);
  }else{
    temp = S;
  }
  if (eval(Money_2_Java(temp)) == 0){
    temp = "";
  }
  if(temp=="")
  {
    temp = "0,00"
    }
  campo.value = temp;
}

function mascaranumero2(S,campo){
  var Digitos = "0123456789";
  S = limpa_string(Money_2_Java(S));
  ini_z = false
  sem_zero = ""
  for (var i=0; i<S.length; i++){
    if (ini_z == true || S.charAt(i) != "0"){
      ini_z = true;
      sem_zero = sem_zero + S.charAt(i);
    }
  }
  S = sem_zero;
  a_virg = "";
  numero = 0;
  for (var i=0; i<S.length - 2; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (Digitos.indexOf(digito)>=0){
      a_virg = a_virg + digito
      }
  }
  temp = S;
  if (eval(Money_2_Java(temp)) == 0){
    temp = "";
  }
  campo.value = temp;
}

function mascaracpfcnpj(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=13) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 2 ){
        temp = "-" + S.substring(S.length-2,S.length)
        }
      if (numero == 3 ){
        if (Digitos.indexOf(digito)>=0){
          temp = S.charAt(0) +"-"+ S.charAt(1) + S.charAt(2)
          }
        }
    if (numero == 4 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) + S.charAt(1) + "-" + S.charAt(2) + S.charAt(3)
        }
      }
  if (numero == 5 ){
    if (Digitos.indexOf(digito)>=0){
      temp = "."+S.charAt(0) + S.charAt(1) + S.charAt(2) + "-" + S.charAt(3) + S.charAt(4)
      }
    }
  if (numero == 6 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) +"."+ S.charAt(1) + S.charAt(2) + S.charAt(3) + "-" + S.charAt(4) + S.charAt(5)
      }
    }
if (numero == 7 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) +"."+ S.charAt(2) + S.charAt(3) + S.charAt(4) + "-" + S.charAt(5)+ S.charAt(6)
    }
  }
if (numero == 8 ){
  if (Digitos.indexOf(digito)>=0){
    temp = "."+S.charAt(0) + S.charAt(1) + S.charAt(2) +"."+ S.charAt(3) + S.charAt(4) + S.charAt(5) + "-" + S.charAt(6)+ S.charAt(7)
    }
  }
if (numero == 9 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) +"."+ S.charAt(1) + S.charAt(2) + S.charAt(3) +"."+ S.charAt(4) + S.charAt(5) + S.charAt(6) + "-" + S.charAt(7)+ S.charAt(8)
    }
  }
if (numero == 10){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) +"."+ S.charAt(2) + S.charAt(3) + S.charAt(4) +"."+ S.charAt(5) + S.charAt(6) + S.charAt(7) + "-" + S.charAt(8)+ S.charAt(9)
    }
  }
if (numero == 11){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + S.charAt(2) +"."+ S.charAt(3) + S.charAt(4) + S.charAt(5) +"."+ S.charAt(6) + S.charAt(7) + S.charAt(8) + "-" + S.charAt(9) + S.charAt(10)
    }
  }
if (numero == 12){
  if (Digitos.indexOf(digito)>=0){
    temp = "." + S.charAt(0) + S.charAt(1) + S.charAt(2) + "." + S.charAt(3) + S.charAt(4) + S.charAt(5) + "/" +  S.charAt(6) + S.charAt(7) + S.charAt(8) + S.charAt(9) + "-" + S.charAt(10) + S.charAt(11)
    }
  }
if (numero == 13){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + "." +  S.charAt(1) + S.charAt(2) + S.charAt(3) +"."+ S.charAt(4) + S.charAt(5) + S.charAt(6) +"/"+ S.charAt(7) + S.charAt(8) + S.charAt(9) + S.charAt(10) +"-"+ S.charAt(11) + S.charAt(12)
    }
  }
if (numero == 14){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + "." + S.charAt(2) + S.charAt(3) + S.charAt(4) + "." + S.charAt(5) + S.charAt(6) + S.charAt(7) + "/" + S.charAt(8) + S.charAt(9) + S.charAt(10) + S.charAt(11) +"-"+ S.charAt(12) + S.charAt(13)
    }
  }
}
}
//	document.formulario.CGC.value = temp;
campo.value = temp;
}

function mascaracnpjcol(S,campo){
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  var dig = "";
  var espaco;
  var numero;
  numero = 0;
  espaco = 0;
  S = limpa_string(S);	
  for (var i=0; i<S.length; i++){
    numero = numero + 1;
    digito = S.charAt(i);
    if (i<=11) {
      if (Digitos.indexOf(digito)>=0){
        temp = temp + digito
        }
      if (numero == 2 ){
        temp = "-" + S.substring(S.length-2,S.length)
        }
      if (numero == 3 ){
        if (Digitos.indexOf(digito)>=0){
          temp = "." + S.charAt(0) + S.charAt(1) + S.charAt(2)
          }
        }
    if (numero == 4 ){
      if (Digitos.indexOf(digito)>=0){
        temp = S.charAt(0) +"."+ S.charAt(1) + S.charAt(2) + S.charAt(3)
        }
      }
  if (numero == 5 ){
    if (Digitos.indexOf(digito)>=0){
      temp = S.charAt(0) + S.charAt(1) +"."+ S.charAt(2) + S.charAt(3) + S.charAt(4)
      }
    }
  if (numero == 6 ){
    if (Digitos.indexOf(digito)>=0){
      temp = "."+S.charAt(0) + S.charAt(1) + S.charAt(2) +"."+ S.charAt(3) + S.charAt(4) + S.charAt(5)
      }
    }
if (numero == 7 ){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) +"."+ S.charAt(1) + S.charAt(2) + S.charAt(3) +"."+ S.charAt(4) + S.charAt(5) + S.charAt(6)
    }
  }
if (numero == 8){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) +"."+ S.charAt(2) + S.charAt(3) + S.charAt(4) +"."+ S.charAt(5) + S.charAt(6) + S.charAt(7)
    }
  }
if (numero == 9){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + S.charAt(2) +"."+ S.charAt(3) + S.charAt(4) + S.charAt(5) +"."+ S.charAt(6) + S.charAt(7) + S.charAt(8)
    }
  }
if (numero == 10){
  if (Digitos.indexOf(digito)>=0){
    temp = "." + S.charAt(0) + S.charAt(1) + S.charAt(2) + "." + S.charAt(3) + S.charAt(4) + S.charAt(5) + "/" +  S.charAt(6) + S.charAt(7) + S.charAt(8) + S.charAt(9)
    }
  }
if (numero == 11){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + "." +  S.charAt(1) + S.charAt(2) + S.charAt(3) +"."+ S.charAt(4) + S.charAt(5) + S.charAt(6) +"/"+ S.charAt(7) + S.charAt(8) + S.charAt(9) + S.charAt(10)
    }
  }
if (numero == 12){
  if (Digitos.indexOf(digito)>=0){
    temp = S.charAt(0) + S.charAt(1) + "." + S.charAt(2) + S.charAt(3) + S.charAt(4) + "." + S.charAt(5) + S.charAt(6) + S.charAt(7) + "/" + S.charAt(8) + S.charAt(9) + S.charAt(10) + S.charAt(11)
    }
  }
}
}
//	document.formulario.CGC.value = temp;
campo.value = temp;
}

function limpa_string(S){
  // Deixa so' os digitos no numero
  var Digitos = "0123456789";
  var temp = "";
  var digito = "";
  for (var i=0; i<S.length; i++){
    digito = S.charAt(i);
    if (Digitos.indexOf(digito)>=0){
      temp=temp+digito
      }
  }
  return temp
}

function limpa_string_virg(S){
  // Deixa so' os digitos no numero
  var Digitos = "0123456789,.";
  var temp = "";
  var digito = "";
  for (var i=0; i<S.length; i++){
    digito = S.charAt(i);
    if (Digitos.indexOf(digito)>=0){
      temp=temp+digito
      }
  }
  return temp
}

function valida_CPF(s){
  var i;
  s = limpa_string(s);
  var c = s.substr(0,9);
  var dv = s.substr(9,2);
  var d1 = 0;
  for (i = 0; i < 9; i++){
    d1 += c.charAt(i)*(10-i);
  }
  if (d1 == 0) return false;
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(0) != d1){
    return false;
  }

  d1 *= 2;
  for (i = 0; i < 9; i++){
    d1 += c.charAt(i)*(11-i);
  }
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(1) != d1){
    return false;
  }
  return true;
}
function valida_CGC(s){
  var i;
  s = limpa_string(s);
  var c = s.substr(0,12);
  var dv = s.substr(12,2);

  var d1 = 0;
  for (i = 0; i < 12; i++){
    d1 += c.charAt(11-i)*(2+(i % 8));
  }
  if (d1 == 0) return false;
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(0) != d1){
    return false;
  }

  d1 *= 2;
  for (i = 0; i < 12; i++){
    d1 += c.charAt(11-i)*(2+((i+1) % 8));
  }
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(1) != d1){
    return false;
  }
  return true;
}
function ltrim(string){
  inicio = false;
  nova_string = "";
  for (x=0;x<string.length;x++){
    if (string.charAt(x) != " "){
      inicio = true;
      nova_string = nova_string + string.charAt(x);
    }else if(inicio){
      nova_string = nova_string + string.charAt(x);
    }
  }
  return nova_string
}

function rtrim(string){
  inicio = false;
  nova_string = "";
  for (x = string.length - 1;x>=0;x--){
    if (string.charAt(x) != " "){
      inicio = true;
      nova_string = string.charAt(x) + nova_string;
    }else if(inicio){
      nova_string = string.charAt(x) + nova_string;
    }
  }
  return nova_string
}

function trim(string){
  return ltrim(rtrim(string))
}
function logout() {
  if(confirm('Deseja sair e fazer logout do HelpDesk Online?')){
    popup_up('logout.asp?x=unload','logout',50,10)
  }
}
function mascara(o,f){
  v_obj=o
  v_fun=f
  setTimeout("execmascara()",1)
}

function execmascara(){
  v_obj.value=v_fun(v_obj.value)
}

function leech(v){
  v=v.replace(/o/gi,"0")
  v=v.replace(/i/gi,"1")
  v=v.replace(/z/gi,"2")
  v=v.replace(/e/gi,"3")
  v=v.replace(/a/gi,"4")
  v=v.replace(/s/gi,"5")
  v=v.replace(/t/gi,"7")
  return v
}

function soNumeros(v){
  return v.replace(/\D/g,"")
}

function telefone(v){
  v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
  v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par�nteses em volta dos dois primeiros d�gitos
  v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
  return v
}

function cpf(v){
  v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
  v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
  v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
  //de novo (para o segundo bloco de n�meros)
  v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h�fen entre o terceiro e o quarto d�gitos
  return v
}

function cep(v){
  v=v.replace(/D/g,"")                //Remove tudo o que n�o � d�gito
  v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse � t�o f�cil que n�o merece explica��es
  return v
}

function cnpj(v){
  v=v.replace(/\D/g,"")                           //Remove tudo o que n�o � d�gito
  v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro d�gitos
  v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto d�gitos
  v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono d�gitos
  v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um h�fen depois do bloco de quatro d�gitos
  return v
}

function romanos(v){
  v=v.toUpperCase()             //Mai�sculas
  v=v.replace(/[^IVXLCDM]/g,"") //Remove tudo o que n�o for I, V, X, L, C, D ou M
  //Essa � complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
  while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
    v=v.replace(/.$/,"")
  return v
}

function site(v){
  //Esse sem comentarios para que voc� entenda sozinho ;-)
  v=v.replace(/^http:\/\/?/,"")
  dominio=v
  caminho=""
  if(v.indexOf("/")>-1)
    dominio=v.split("/")[0]
  caminho=v.replace(/[^\/]*/,"")
  dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
  caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
  caminho=caminho.replace(/([\?&])=/,"$1")
  if(caminho!="")dominio=dominio.replace(/\.+$/,"")
  v="http://"+dominio+caminho
  return v
}

/*
	*****************************************************************************************************
	Author : Lea Smart
	Source : www.totallysmartit.com
	Date : 7/3/2001
	DHTML Calendar
	Version 1.2
	
	You are free to use this code if you retain this header.
	You do not need to link to my site (be nice though!)
	
	Amendments
	22 Jan 2002; Added ns resize bug code; rewrote date functions into Date 'class';
				 Added support for yyyy-mm-dd date format
				 Added support for calendar beginning on any day
	7th Feb 2002 Fixed day highlight when year wasn't current year bug
	9th Jun 2002 Fixed bug with weekend colour
				 Amended the code for the date functions extensions.  Shortened addDays code considerably
	*****************************************************************************************************
	*/
var timeoutDelay = 2000; // milliseconds, change this if you like, set to 0 for the calendar to never auto disappear
var g_startDay = 0// 0=sunday, 1=monday
	
// preload images
var imgUp = new Image(8,12);
imgUp.src = 'imagens/up.gif';
var imgDown = new Image(8,12);
imgDown.src = 'imagens/down.gif';
	
// used by timeout auto hide functions
var timeoutId = false;
	
// the now standard browser sniffer class
function Browser(){
  this.dom = document.getElementById?1:0;
  this.ie4 = (document.all && !this.dom)?1:0;
  this.ns4 = (document.layers && !this.dom)?1:0;
  this.ns6 = (this.dom && !document.all)?1:0;
  this.ie5 = (this.dom && document.all)?1:0;
  this.ok = this.dom || this.ie4 || this.ns4;
  this.platform = navigator.platform;
}
var browser = new Browser();
		
// dom browsers require this written to the HEAD section
	
if (browser.dom || browser.ie4){
  document.writeln('<style>');
  document.writeln('#container {');
  document.writeln('position : absolute;');
  document.writeln('left : 100px;');
  document.writeln('top : 100px;');
  document.writeln('width : 124px;');
  ;
  browser.platform=='Win32'?height=140:height=145;
  document.writeln('height : ' + height +'px;');
  document.writeln('clip:rect(0px 224px ' + height + 'px 0px);');
  //document.writeln('overflow : hidden;');
  document.writeln('visibility : hidden;');
  document.writeln('background-color : #EFEFEF');
  document.writeln('}');
  document.writeln('</style>')
  document.write('<div id="container"');
  if (timeoutDelay) document.write(' onmouseout="calendarTimeout();" onmouseover="if (timeoutId) clearTimeout(timeoutId);"');
  document.write('></div>');
}
	
var g_Calendar;  // global to hold the calendar reference, set by constructor
	
function calendarTimeout(){
  if (browser.ie4 || browser.ie5){
    if (window.event.srcElement && window.event.srcElement.name!='month') timeoutId=setTimeout('g_Calendar.hide();',timeoutDelay);
  }
  if (browser.ns6 || browser.ns4){
    timeoutId=setTimeout('g_Calendar.hide();',timeoutDelay);
  }
}
	
// constructor for calendar class
function Calendar(){
  g_Calendar = this;
  // some constants needed throughout the program
  this.daysOfWeek = new Array("Dom","Seg","Ter","Qua","Qui","Sex","Sab");
  this.months = new Array("Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
  this.daysInMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	  
  if (browser.ns4){
    var tmpLayer = new Layer(127);
    if (timeoutDelay){
      tmpLayer.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
      tmpLayer.onmouseover = function(event) {
        if (timeoutId) clearTimeout(timeoutId);
      };
      tmpLayer.onmouseout = function(event) {
        timeoutId=setTimeout('g_Calendar.hide()',timeoutDelay);
      };
    }
    tmpLayer.x = 100;
    tmpLayer.y = 100;
    tmpLayer.bgColor = "#ffffff";
  }
  if (browser.dom || browser.ie4){
    var tmpLayer = browser.dom?document.getElementById('container'):document.all.container;
  }
  this.containerLayer = tmpLayer;
  if (browser.ns4 && browser.platform=='Win32') {
    this.containerLayer.clip.height=134;
    this.containerLayer.clip.width=127;
  }

}
	
Calendar.prototype.getFirstDOM = function() {
  var thedate = new Date();
  thedate.setDate(1);
  thedate.setMonth(this.month);
  thedate.setFullYear(this.year);
  return thedate.getDay();
}

Calendar.prototype.getDaysInMonth = function (){
  if (this.month!=1) {
    return this.daysInMonth[this.month]
  }
  else {
    // is it a leap year
    if (Date.isLeapYear(this.year)) {
      return 29;
    }
    else {
      return 28;
    }
  }
}
	 
Calendar.prototype.buildString = function(){
  var tmpStr = '<form onSubmit="this.year.blur();return false;"><table width="100%" border="1" cellspacing="0" cellpadding="2" class="calBorderColor"><tr><td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="1" class="calBgColor">';
  tmpStr += '<tr>';
  tmpStr += '<td width="60%" class="cal" align="left">';
  if (this.hasDropDown) {
    tmpStr += '<select class="month" name="month" onchange="g_Calendar.selectChange();">';
    for (var i=0;i<this.months.length;i++){
      tmpStr += '<option value="' + i + '"' 
      if (i == this.month) tmpStr += ' selected';
      tmpStr += '>' + this.months[i] + '</option>';
    }
    tmpStr += '</select>';
  } else {
    tmpStr += '<table border="0" cellspacing="0" cellpadding="0"><tr><td><a href="javascript: g_Calendar.changeMonth(-1);"><img name="calendar" src="imagens/down.gif" width="8" height="12" border="0" alt=""></a></td><td class="cal" width="100%" align="center">' + this.months[this.month] + '</td><td class="cal"><a href="javascript: g_Calendar.changeMonth(+1);"><img name="calendar" src="imagens/up.gif" width="8" height="12" border="0" alt=""></a></td></tr></table>';
  }
  tmpStr += '</td>';
  /* observation : for some reason if the below event is changed to 'onChange' rather than 'onBlur' it totally crashes IE (4 and 5)!
	  */
  tmpStr += '<td width="40%" align="right" class="cal">';
	  
  if (this.hasDropDown) { 
    tmpStr += '<input class="year" type="text" size="';
    // get round NS4 win32 lenght of year input problem
    (browser.ns4 && browser.platform=='Win32')?tmpStr += 1:tmpStr += 4;
    tmpStr += '" name="year" maxlength="4" onBlur="g_Calendar.inputChange();" value="' + this.year + '">';
  } else {
    tmpStr += '<table border="0" cellspacing="0" cellpadding="0"><tr><td class="cal"><a href="javascript: g_Calendar.changeYear(-1);"><img name="calendar" src="imagens/down.gif" width="8" height="12" border="0" alt=""></a></td><td class="cal" width="100%" align="center">' + this.year + '</td><td class="cal"><a href="javascript: g_Calendar.changeYear(+1);"><img name="calendar" src="imagens/up.gif" width="8" height="12" border="0" alt=""></a></td></tr></table>'
  }
  tmpStr += '</td>';
  tmpStr += '</tr>';
  tmpStr += '</table>';
  var iCount = 1;

  var iFirstDOM = (7+this.getFirstDOM()-g_startDay)%7; // to prevent calling it in a loop

  var iDaysInMonth = this.getDaysInMonth(); // to prevent calling it in a loop
	  
  tmpStr += '<table width="100%" border="0" cellspacing="0" cellpadding="1" class="calBgColor">';
  tmpStr += '<tr>';
  for (var i=0;i<7;i++){
    tmpStr += '<td align="center" class="calDaysColor">' + this.daysOfWeek[(g_startDay+i)%7] + '</td>';
  }
  tmpStr += '</tr>';
  var tmpFrom = parseInt('' + this.dateFromYear + this.dateFromMonth + this.dateFromDay,10);
  var tmpTo = parseInt('' + this.dateToYear + this.dateToMonth + this.dateToDay,10);
  var tmpCompare;
  for (var j=1;j<=6;j++){
    tmpStr += '<tr>';
    for (var i=1;i<=7;i++){
      tmpStr += '<td width="16" align="center" '
      if ( (7*(j-1) + i)>=iFirstDOM+1  && iCount <= iDaysInMonth){
        if (iCount==this.day && this.year==this.oYear && this.month==this.oMonth) tmpStr += 'class="calHighlightColor"';
        else {
          if (i==7-g_startDay || i==((7-g_startDay)%7)+1) tmpStr += 'class="calWeekend"';
          else tmpStr += 'class="cal"';
        }
        tmpStr += '>';
        /* could create a date object here and compare that but probably more efficient to convert to a number
			   and compare number as numbers are primitives */
        tmpCompare = parseInt('' + this.year + padZero(this.month) + padZero(iCount),10);
        if (tmpCompare >= tmpFrom && tmpCompare <= tmpTo) {
          tmpStr += '<a class="cal" href="javascript: g_Calendar.clickDay(' + iCount + ');">' + iCount + '</a>';
        } else {
          tmpStr += '<span class="disabled">' + iCount + '</span>';
        }
        iCount++;
      } else {
        if  (i==7-g_startDay || i==((7-g_startDay)%7)+1) tmpStr += 'class="calWeekend"'; else tmpStr +='class="cal"';
        tmpStr += '>&nbsp;';
      }
      tmpStr += '</td>'
    }
    tmpStr += '</tr>'
  }
  tmpStr += '</table></td></tr></table></form>'
  return tmpStr;
}
	
Calendar.prototype.selectChange = function(){
  this.month = browser.ns6?this.containerLayer.ownerDocument.forms[0].month.selectedIndex:this.containerLayer.document.forms[0].month.selectedIndex;
  this.writeString(this.buildString());
}
	
Calendar.prototype.inputChange = function(){
  var tmp = browser.ns6?this.containerLayer.ownerDocument.forms[0].year:this.containerLayer.document.forms[0].year;
  if (tmp.value >=1900 || tmp.value <=2100){
    this.year = tmp.value;
    this.writeString(this.buildString());
  } else {
    tmp.value = this.year;
  }
}
Calendar.prototype.changeYear = function(incr){
  (incr==1)?this.year++:this.year--;
  this.writeString(this.buildString());
}
Calendar.prototype.changeMonth = function(incr){
  if (this.month==11 && incr==1){
    this.month = 0;
    this.year++;
  } else {
    if (this.month==0 && incr==-1){
      this.month = 11;
      this.year--;
    } else {
      (incr==1)?this.month++:this.month--;
    }
  }
  this.writeString(this.buildString());
}
	
Calendar.prototype.clickDay = function(day){
  var tmp = eval('document.' + this.target);
  tmp.value = this.formatDateAsString(day,this.month,this.year);
  if (browser.ns4) this.containerLayer.hidden=true;
  if (browser.dom || browser.ie4){
    this.containerLayer.style.visibility='hidden';
  }
}
Calendar.prototype.formatDateAsString = function(day, month, year){
  var delim = eval('/\\' + this.dateDelim + '/g');
  switch (this.dateFormat.replace(delim,"")){
    case 'ddmmmyyyy':
      return padZero(day) + this.dateDelim + this.months[month].substr(0,3) + this.dateDelim + year;
    case 'ddmmyyyy':
      return padZero(day) + this.dateDelim + padZero(month+1) + this.dateDelim + year;
    case 'mmddyyyy':
      return padZero((month+1)) + this.dateDelim + padZero(day) + this.dateDelim + year;
    case 'yyyymmdd':
      return year + this.dateDelim + padZero(month+1) + this.dateDelim + padZero(day);
    default:
      alert('unsupported date format');
  }
}
Calendar.prototype.writeString = function(str){
  if (browser.ns4){
    this.containerLayer.document.open();
    this.containerLayer.document.write(str);
    this.containerLayer.document.close();
  } 
  if (browser.dom || browser.ie4){
    this.containerLayer.innerHTML = str;
  }
}
	
Calendar.prototype.show = function(event, target, bHasDropDown, dateFormat, dateFrom, dateTo){
  // calendar can restrict choices between 2 dates, if however no restrictions
  // are made, let them choose any date between 1900 and 3000
  this.dateFrom = dateFrom || new Date(1900,0,1);
  this.dateFromDay = padZero(this.dateFrom.getDate());
  this.dateFromMonth = padZero(this.dateFrom.getMonth());
  this.dateFromYear = this.dateFrom.getFullYear();
  this.dateTo = dateTo || new Date(3000,0,1);
  this.dateToDay = padZero(this.dateTo.getDate());
  this.dateToMonth = padZero(this.dateTo.getMonth());
  this.dateToYear = this.dateTo.getFullYear();
  this.hasDropDown = bHasDropDown;
  this.dateFormat = dateFormat || 'dd-mmm-yyyy';
  switch (this.dateFormat){
    case 'dd-mmm-yyyy':
    case 'dd-mm-yyyy':
    case 'yyyy-mm-dd':
      this.dateDelim = '-';
      break;
    case 'dd/mm/yyyy':
    case 'mm/dd/yyyy':
    case 'dd/mmm/yyyy':
      this.dateDelim = '/';
      break;
  }
	
  if (browser.ns4) {
    if (!this.containerLayer.hidden) {
      this.containerLayer.hidden=true;
      return;
    }
  }
  if (browser.dom || browser.ie4){
    if (this.containerLayer.style.visibility=='visible') {
      this.containerLayer.style.visibility='hidden';
      return;
    }  
  }

  if (browser.ie5 || browser.ie4){
    var event = window.event;
  }
  if (browser.ns4){
    this.containerLayer.x = event.x+10;
    this.containerLayer.y = event.y-5;
  }
  if (browser.ie5 || browser.ie4){
    var obj = event.srcElement;
    x = 0;
    while (obj.offsetParent != null) {
      x += obj.offsetLeft;
      obj = obj.offsetParent;
    }
    x += obj.offsetLeft;
    y = 0;
    var obj = event.srcElement;
    while (obj.offsetParent != null) {
      y += obj.offsetTop;
      obj = obj.offsetParent;
    }
    y += obj.offsetTop;
		
    this.containerLayer.style.left = x+35;
    if (event.y>0)this.containerLayer.style.top = y;
  }
  if (browser.ns6){
    this.containerLayer.style.left = event.pageX+10;
    this.containerLayer.style.top = event.pageY-5;
  }
  this.target = target;
  var tmp = eval('document.' + this.target);
  if (tmp && tmp.value && tmp.value.split(this.dateDelim).length==3 && tmp.value.indexOf('d')==-1){
    var atmp = tmp.value.split(this.dateDelim)
    switch (this.dateFormat){
      case 'dd-mmm-yyyy':
      case 'dd/mmm/yyyy':
        for (var i=0;i<this.months.length;i++){
          if (atmp[1].toLowerCase()==this.months[i].substr(0,3).toLowerCase()){
            this.month = this.oMonth = i;
            break;
          }
        }
        this.day = parseInt(atmp[0],10);
        this.year = this.oYear = parseInt(atmp[2],10);
        break;
      case 'dd/mm/yyyy':
      case 'dd-mm-yyyy':
        this.month = this.oMonth = parseInt(atmp[1]-1,10); 
        this.day = parseInt(atmp[0],10);
        this.year = this.oYear = parseInt(atmp[2],10);
        break;
      case 'mm/dd/yyyy':
      case 'mm-dd-yyyy':
        this.month = this.oMonth = parseInt(atmp[0]-1,10);
        this.day = parseInt(atmp[1],10);
        this.year = this.oYear = parseInt(atmp[2],10);
        break;
      case 'yyyy-mm-dd':
        this.month = this.oMonth = parseInt(atmp[1]-1,10);
        this.day = parseInt(atmp[2],10);
        this.year = this.oYear = parseInt(atmp[0],10);
        break;
    }
  } else { // no date set, default to today
    var theDate = new Date();
    this.year = this.oYear = theDate.getFullYear();
    this.month = this.oMonth = theDate.getMonth();
    this.day = this.oDay = theDate.getDate();
  }
  this.writeString(this.buildString());
	  
  // and then show it!
  if (browser.ns4) {
    this.containerLayer.hidden=false;
  }
  if (browser.dom || browser.ie4){
    this.containerLayer.style.visibility='visible';
  }
}
	
Calendar.prototype.hide = function(){
  if (browser.ns4) this.containerLayer.hidden = true;
  if (browser.dom || browser.ie4){
    this.containerLayer.style.visibility='hidden';
  }
}
	
function handleDocumentClick(e){
  if (browser.ie4 || browser.ie5) e = window.event;

  if (browser.ns6){
    var bTest = (e.pageX > parseInt(g_Calendar.containerLayer.style.left,10) && e.pageX <  (parseInt(g_Calendar.containerLayer.style.left,10)+125) && e.pageY < (parseInt(g_Calendar.containerLayer.style.top,10)+125) && e.pageY > parseInt(g_Calendar.containerLayer.style.top,10));
    if (e.target.name!='imgCalendar' && e.target.name!='month'  && e.target.name!='year' && e.target.name!='calendar' && !bTest){
      g_Calendar.hide(); 
    }
  }
  if (browser.ie4 || browser.ie5){
    // extra test to see if user clicked inside the calendar but not on a valid date, we don't want it to disappear in this case
    var bTest = (e.x > parseInt(g_Calendar.containerLayer.style.left,10) && e.x <  (parseInt(g_Calendar.containerLayer.style.left,10)+125) && e.y < (parseInt(g_Calendar.containerLayer.style.top,10)+125) && e.y > parseInt(g_Calendar.containerLayer.style.top,10));
    if (e.srcElement.name!='imgCalendar' && e.srcElement.name!='month' && e.srcElement.name!='year' && !bTest & typeof(e.srcElement)!='object'){
      g_Calendar.hide(); 
    }
  }
  if (browser.ns4) g_Calendar.hide();
}
	
// utility function
function padZero(num) {
  return ((num <= 9) ? ("0" + num) : num);
}
// Finally licked extending  native date object;
Date.isLeapYear = function(year){
  if (year%4==0 && ((year%100!=0) || (year%400==0))) return true; else return false;
}
Date.daysInYear = function(year){
  if (Date.isLeapYear(year)) return 366; else return 365;
}
var DAY = 1000*60*60*24;
Date.prototype.addDays = function(num){
  return new Date((num*DAY)+this.valueOf());
}	
	  
// events capturing, careful you don't override this by setting something in the onload event of 
// the body tag
window.onload=function(){ 
  new Calendar(new Date());
  if (browser.ns4){
    if (typeof document.NSfix == 'undefined'){
      document.NSfix = new Object();
      document.NSfix.initWidth=window.innerWidth;
      document.NSfix.initHeight=window.innerHeight;
    }
  }
}
if (browser.ns4) window.onresize = function(){
  if (document.NSfix.initWidth!=window.innerWidth || document.NSfix.initHeight!=window.innerHeight) window.location.reload(false);
} // ns4 resize bug workaround
window.document.onclick=handleDocumentClick;
window.onerror = function(msg,url,line){
  /*
	  alert('******* an error has occurred ********' +
	  '\n\nPlease check that' + 
	  '\n\n1)You have not added any code to the body onload event,'
	  +  '\nif you want to run something as well as the calendar initialisation'
	  + '\ncode, add it to the onload event in the calendar library.'
	  + '\n\n2)You have set the parameters correctly in the g_Calendar.show() method '
	  + '\n\nSee www.totallysmartit.com\\examples\\calendar\\simple.asp for examples'
	  + '\n\n------------------------------------------------------'
	  + '\nError details'
	  + '\nText:' + msg + '\nurl:' + url + '\nline:' + line);
	*/
  }

function detailbox(id) {
  var detalheAberto = (document.getElementById('Detail_'+id).style.display == '');
  if(detalheAberto) {
    document.getElementById('Detail_'+id).style.display = 'none';
  }else{
    document.getElementById('Detail_'+id).style.display = '';
  }
}
-->