<?php 
  require_once('functions.php'); 
  edit();
  $acao = '';
  if (isset($_GET['a']))
    $acao = $_GET['a'];
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Atualizar os dados de <?php echo $crianca['nome']; ?></h2>

<form action="edit.php?id=<?php echo $crianca['id']; ?>" method="post">

  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-2">
        <img src="<?php echo $crianca['foto']?$crianca['foto']:"../imagens/ico.png"; ?>" class="card-img" alt="...">
      </div>
      <div class="col-md-10">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="name">Nome</span>
                </div>
                <input <?php echo $acao=='r'?"readonly":""; ?> type="text" class="form-control" aria-describedby="name" name="crianca['name']" value="<?php echo $crianca['nome']; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="data_nascimento">Data de Nascimento</span>
                </div>
                <input <?php echo $acao=='r'?"readonly":""; ?> type="text" class="form-control" aria-describedby="data_nascimento" name="crianca['data_nascimento']" value="<?php echo $crianca['data_nascimento']; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <select class="custom-select" <?php echo $acao=='r'?"disabled":""; ?> name="crianca['genero']">
                <option value="1" <?php echo $crianca['genero']==1?"selected":""; ?>>Menino</option>
                <option value="2" <?php echo $crianca['genero']!=1?"selected":""; ?>>Menina</option>
              </select>            
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="input-group form-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="foto">Foto</span>
                </div>
                <input <?php echo $acao=='r'?"readonly":""; ?> type="text" class="form-control" aria-describedby="foto" name="crianca['foto']" value="<?php echo $crianca['foto']; ?>">
              </div>
            </div>
            <div id="actions" class="col-md-4">
            <?php if($acao!='r'){ ?>
              <button type="submit" class="btn btn-primary">Salvar</button>
              <a href="./edit.php?a=r&id=<?php echo $crianca['id']; ?>" class="btn btn-secondary">Cancelar</a>
            <?php }else{ ?>
              <a href="./edit.php?id=<?php echo $crianca['id']; ?>" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</a>
              <a href="./" class="btn btn-secondary">Voltar</a>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>