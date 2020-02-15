<?php
/*
 *Enquete criada por Fernando Villela - Montepage coisas legais
 *e-mail: contato@montepage.com.br
 *divulgue, compartilhe, use, altere e mantenha os créditos.
*/
require_once('bancodedados.php');
require_once('html.php');
$html = new Html;
    if(isset($_POST['formulario']) && $_POST['formulario']=='opcao'){
        if($html->inserir(array($_POST['idpergunta'], $_POST['nome'], 'opcao'))){
		echo '<p>Opção cadastrada com sucesso!</p>';
	}else{
		echo '<p>Falha no cadastro da Opção!</p>';
	}
    }
if(isset($_GET['page'])){
	if($_GET['page'] == 'editar'){
			echo '<fieldset><legend>Editar - Opções de respostas</legend>';
			echo $html->mostraOpcoes($_GET['id']);
			$html->novaOpcao($_GET['id']);
			echo '</fieldset>';
	}
	if($_GET['page'] == 'excluir'){
		if(isset($_GET['confirm'])){
			$html->excluir(array($_GET['id'], 'pergunta'));
		}else{
			echo '<fieldset><legend>confirmar</legend><p>Tem certeza que deseja excluir toda a enquete e seus respectivos votos e opções de repostas?</p>';
			echo '<a href="cadastrar.php?page=excluir&id='.$_GET['id'].'&confirm=1">Sim</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cadastrar.php">Não</a></fieldset>';
		}
	}
	if($_GET['page'] == 'op_excluir'){
		if(isset($_GET['confirm'])){
			$html->excluir(array($_GET['id'], 'opcao'));
		}else{
			echo '<fieldset><legend>confirmar</legend><p>Tem certeza que deseja excluir a opção de resposta e seus respectivos votos?</p>';
			echo '<a href="cadastrar.php?page=op_excluir&id='.$_GET['idopcao'].'&confirm=1">Sim</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cadastrar.php">Não</a></fieldset>';
		}
	}
	
}
    if(isset($_POST['formulario']) && $_POST['formulario']=='pergunta'){
        if($html->inserir(array($_POST['nome'], date('Y-m-d H:i:s'), 'pergunta'))){
		echo '<p>Enquete cadastrada com sucesso!</p>';
	}else{
		echo '<p>Falha no cadastro da Enquete!</p>';
	}
    }
echo '<fieldset><legend>Todas as Enquetes</legend>'.$html->mostraEnquetes().'</fieldset>';
$html->novaEnquete();