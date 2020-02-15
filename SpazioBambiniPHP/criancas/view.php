<?php 
	require_once('functions.php'); 
	view($_GET['id']);
?>

<?php include(HEADER_TEMPLATE); ?>

<h2><?php echo $crianca['nome']; ?></h2>
<hr>

<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
<?php endif; ?>

<dl class="dl-horizontal">
	<dt>Nome:</dt>
	<dd><?php echo $crianca['nome']; ?></dd>

	<dt>Data de Nascimento:</dt>
	<dd><?php echo $crianca['data_nascimento']; ?></dd>

	<dt>Gênero:</dt>
	<dd><?php echo $crianca['genero']==1?"Menino":"Menina"; ?></dd>
</dl>

<dl class="dl-horizontal">
	<dt>Foto:</dt>
	<dd><?php echo $crianca['foto']; ?></dd>
</dl>


<div id="actions" class="row">
	<div class="col-md-12">
	  <a href="edit.php?id=<?php echo $crianca['id']; ?>" class="btn btn-primary">Editar</a>
	  <a href="./" class="btn btn-secondary">Voltar</a>
	</div>
</div>

<?php include(FOOTER_TEMPLATE); ?>