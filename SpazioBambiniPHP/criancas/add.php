<?php 
  require_once('functions.php'); 
  add();
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Cadastrar uma criança</h2>

<form action="add.php" method="post">
  <!-- area de campos do form -->
  <hr />
  <div class="row">
    <div class="form-group col-md-7">
      <label for="nome">Nome</label>
      <input type="text" class="form-control" name="crianca['name']">
    </div>

    <div class="form-group col-md-3">
      <label for="data_nascimento">Data de Nascimento</label>
      <input type="text" class="form-control" name="crianca['data_nascimento']">
    </div>

    <div class="form-group col-md-2">
      <label for="genero">Gênero</label>
      <input type="text" class="form-control" name="crianca['genero']">
    </div>
  </div>
  
  <div class="row">
    <div class="form-group col-md-12">
      <label for="foto">Foto</label>
      <input type="text" class="form-control" name="crianca['foto']">
    </div>
  </div>
  <div id="actions" class="row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="./" class="btn btn-secondary">Voltar</a>
    </div>
  </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>