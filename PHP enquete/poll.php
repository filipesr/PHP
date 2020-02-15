<?php
/*
 *Enquete criada por Fernando Villela - Montepage coisas legais
 *e-mail: contato@montepage.com.br
 *divulgue, compartilhe, use, altere e mantenha os créditos.
*/
require_once('bancodedados.php');
require_once('html.php');
$html = new Html;
if(!isset($_POST['poll'])){
	$res = $html->ultimaenquete();
	//print_r($res);
	if($res['id']){
		echo "<p class=\"pollques\">".utf8_encode($res['nome'])."</p>";
		$poll_id=$res['id'];
	}
	if(isset($_GET["result"]) && ($_GET["result"]==1 || $_COOKIE["voted".$poll_id]=='yes')){
		//if already voted or asked for result
		$html->mostraresultados($poll_id);
		exit;
	}else{
		//display options with radio buttons
		$html->mostraOpcoesComRadio($poll_id);
	}
}else{
	if(isset($_POST['pollid'])){
		$post_pollid = $_POST['pollid'];
		if(!isset($_COOKIE["voted".$post_pollid]) || $_COOKIE["voted".$post_pollid]!='yes'){
			//echo 'aqui';
			$res = $html->inserir(array($_POST["poll"], date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], 'votos'));
			if($res){
				//Voto adicionado e criando cookie
				setcookie("voted".$_POST['pollid'], 'yes', time()+86400*300);				
			}else{
				echo utf8_encode("Voto inválido: ").mysql_error();
			}
			
		}
	}		
	$html->mostraresultados(intval($_POST['pollid']));
}