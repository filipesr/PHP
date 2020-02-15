<?php
require_once('../config.php');
require_once(DBAPI);
$criancas = null;
$crianca = null;
/**
 *  Listagem
 */
function index() {
	global $criancas;
	$criancas = find_all('criancas');
}

/**
 *  Cadastro
 */
function add() {
  if (!empty($_POST['crianca'])) {
    $crianca = $_POST['crianca'];
    
    save('criancas', $crianca);
    header('location: index.php');
  }
}

/**
 *	Atualizacao/Edicao
 */
function edit() {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['crianca'])) {
      $crianca = $_POST['crianca'];
      update('criancas', $id, $crianca);
      header('location: index.php');
    } else {
      global $crianca;
      $crianca = find('criancas', $id);
    } 
  } else {
    header('location: index.php');
  }
}

/**
 *  Visualização
 */
function view($id = null) {
  global $crianca;
  $crianca = find('criancas', $id);
}
?>