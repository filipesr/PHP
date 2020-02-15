<?php
session_name("SigRelatorio");
session_start();
// Configuration
require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application Classes
require_once(DIR_SYSTEM . 'library/cliente.php');

// Registry
$registry = new Registry();

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Valida Usuário
$usuario = new Cliente($registry);

if (!$usuario->isLogged()) {
    header("Location: " . HTTP_SERVER . "index.php?msgErro=" . urlencode("Acesso não autorizado ou sessão expirada!"));
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            *{
                font-family: monospace;
                color: black;
            }
            div{
                width: 500px;
            }
            .painelMenu{
                text-align: center;
                border-radius: 10px;
                margin: 10px;
                padding: 10px;
                border: 1px solid black;
                background-color: #ccffcc;
            }
            .painelEnviarArquivo{
                border-radius: 10px;
                margin: 10px;
                padding: 10px;
                border: 1px solid black;
                background-color: #cccccc;
            }
            .selClienteCategoria{}
            .fileArquivo{}
            .btEnviar{
                text-align: center;
            }
            .painelCategoria{
                border-radius: 10px;
                margin: 10px;
                padding: 10px;
                border: 1px olivedrab dashed;
                background-color: #DDFFDD;
            }
            .titCategoria{
                color: darkgreen;
                font-weight: bolder;
                font-size: 18px;
            }
            .listaCategoria{
                margin-top: 5px;
                border-bottom: 1px black dotted;
                border-right: 1px black dotted;
                border-left: 1px black dotted;
            }
            .categoria{
                font-family: Arial;
                font-size: 20px;
            }
            .categoria, .arquivo{
                border-top: 1px black dotted;
            }
            .categoria img{
                width: 20px;
            }
            .painelArquivo{}
            .arquivo{}
            .arquivo img{
                height: 12px;
            }
        </style>
        <title>SigRelatorio</title>
    </head>
    <body>
        <?php if ($usuario->isAdmin()) { ?>
            <div class="painelMenu">
                <a href="listaArquivos.php">Arquivos</a> ||
                <a href="listaCategorias.php">Categorias</a> ||
                <a href="listaUsuarios.php">Usuarios</a>
            </div>
            <div class="painelEnviarArquivo">
                <form method="POST">
                    <div class="selClienteCategoria">
                        Cliente: <select>
                            <?php foreach ($usuario->getIdClientes() as $cliente) { ?>
                                <option value="<?php echo $cliente["idcliente"]; ?>"><?php echo $cliente["nome"]; ?></option>
                            <?php } ?>
                        </select>
                        Categoria: <select>
                            <?php foreach ($usuario->getCategorias() as $categoria) { ?>
                                <option value="<?php echo $categoria["idcategoria"]; ?>"><?php echo $categoria["nome"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="fileArquivo">
                        Arquivo: <input type="file">
                    </div>
                    <div class="btEnviar">
                        <input type="submit" value="Enviar">
                    </div>
                </form>
            </div>
            <?php
        }
        // lista de categorias
        foreach ($usuario->getIdClientes() as $cliente) {
            ?>
            <div class="painelCategoria">
                <div class="titCategoria">
                    Lista de Arquivos de <?php echo $cliente["nome"]; ?>
                </div>
                <?php
                // lista de categorias
                foreach ($usuario->getCategorias($cliente["idcliente"]) as $categoria) {
                    ?>
                    <div class="listaCategoria" style="background-color: #<?php echo $categoria['cor']; ?>">
                        <div class="categoria">
                            <img src="<?php echo HTTP_IMAGE . $categoria['icone']; ?>"><?php echo $categoria['nome']; ?>
                        </div>
                        <div class="painelArquivo">
                            <?php
                            // lista de arquivos
                            foreach ($usuario->getArquivos($cliente["idcliente"])[$categoria['idcategoria']] as $arquivo) {
                                ?>
                                <div class="arquivo">
                                    <img src="<?php echo HTTP_IMAGE; ?>cat_dir_1_linhaSub.png">
                                    <?php if ($usuario->isAdmin()) { ?>
                                        <img title="Esta arquivo está <?php echo ($arquivo['ativo'] == 1 ? '' : 'in'); ?>ativo, clique aqui para mudar seu status" src="<?php echo HTTP_IMAGE . ($arquivo['ativo'] == 1 ? '' : 'in'); ?>ativo.png">
                                    <?php } ?>
                                    <img title="Arquivo do tipo PDF" src="<?php echo HTTP_IMAGE . "plus_pdf.png"; ?>">
                                    <a title="Clique aqui para baixar este arquivo" href="<?php echo HTTP_SRC . $arquivo['idarquivo'] ?>.pdf">
                                        <?php echo $arquivo['dtarquivo']; ?> - <?php echo $arquivo['srcarquivo']; ?>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </body>
</html>
