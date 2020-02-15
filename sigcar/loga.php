<?php
session_name("SigCarlogin");
session_start();

include "connection.php"; // Conecta ao banco de dados
include "functions.php"; // Banco de fun��es
if (retRequest('lnome') != "") {
    //Executa a consulta
    $lnome = retRequest('lnome');
    $lsenha = retRequest('lsenha');
    $q_user = RetVar("SELECT count(iduser) FROM tuser WHERE login='$lnome' AND pass='$lsenha'");

    if ($q_user == 1) {
        sqlexec($id, "UPDATE tuser SET dtua = NOW( ) WHERE login='$lnome' AND pass='$lsenha'");
        $_SESSION['llogin'] = $lnome;
        $_SESSION['lsenha'] = $lsenha;
        $_SESSION['iduser'] = RetVar("SELECT iduser FROM tuser WHERE login='$lnome' AND pass='$lsenha'");
        $_SESSION['SigCarlogin'] = true;
        //session_register("SigCarlogin");
        header("Location: " . $home . "/cad/testoque.php");
        exit;
    } else {
        header("Location: " . $home . "/login.php?login=falhou&causa=" . urlencode('Usu&aacute;rio ou Senha Inv&aacute;lidos!'));
        exit;
    }
}

//agora a parte que verifica se o login j� foi feito
if (!isset($_SESSION['SigCarlogin'])) {
    header("Location: " . $home . "/login.php?login=falhou&causa=" . urlencode('Usu&aacute;rio n&atilde;o logado!'));
} else {
    include "css/css.php"; // insere o arquivo de css
}

//agora a parte que verifica se tem acesso
$oper = retRequest('oper');
$llogin = $_SESSION['llogin'];
$lsenha = $_SESSION['lsenha'];
if (RetVar("SELECT idgrupoacesso FROM tuser WHERE login='" . $_SESSION['llogin'] . "' AND pass='" . $_SESSION['lsenha'] . "'") != 1) {
    if ($oper == "") {
        $oper = "Ler";
    };
    if ($modulotab != "") {
        if (RetVar("select a.a" . $oper . " from tuser u ,tacesso a ,tmodulo m where u.idgrupoacesso=a.idgrupoacesso and a.idmodulo=m.idmodulo and m.modulotab='$modulotab' and u.login='$llogin' and u.pass='$lsenha' and a.dtvalidade > now();") == 0) {
            echo "<div align=center><br><br><br><img src='$home/imagens/Symbol-Stop.jpg'></font></div>"; //se n�o tem permiss�o aparece essa mensagem
            echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif><br><br><br>Voc&ecirc; n&atilde;o tem permiss&atilde;o de acessar essa p&aacute;gina.</font></div>"; //se n�o tem permiss�o aparece essa mensagem
            echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif><br><br><br><a href='$home/login.php'>Logar com outro usu&aacute;rio.</a></font></div>"; //se n�o tem permiss�o aparece essa mensagem
            echo "<div align=center><font size=2 face=Verdana, Arial, Helvetica, sans-serif><br><br><br><a href=javascript:history.back(1)>Voltar.</a></font></div>"; //se n�o tem permiss�o aparece essa mensagem
            exit;
        }
    }
}
include "include_cab2.php";
?>
<script language="JavaScript" src="funcoes.js" type="text/javascript"></script>
