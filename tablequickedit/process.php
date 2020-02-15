<?php
$mysqli = new mysqli('localhost', 'root', '', 'spazio_bambini');

if (mysqli_connect_errno()) {
  echo json_encode(array('mysqli' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
  exit;
}

$page = isset($_GET['p']) ? $_GET['p'] : '';
if ($page == 'view') {
  if (!isset($_GET['classe'])) {
    echo json_encode(array('Classe' => 'Uma classe deve ser solicitada para essa função!'));
    exit;
  }
  $classe = $_GET['classe'];
  $array_sql_select = [
      "colaboradores" => "SELECT id, nome, cpf, data_nascimento, telefone, foto FROM colaboradores",
      "criancas" => "SELECT id, nome, genero, DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data, foto, IF(restricao_acesso, 'sim', 'não') FROM criancas",
      "eventos" => "SELECT id, nome, DATE_FORMAT(data_evento,'%d/%m/%Y') AS data, tempo_permanencia, capacidade FROM eventos",
      "responsaveis" => "SELECT id, nome, telefone, telefone2, cpf, foto FROM responsaveis",
      "ocorrencias" => "SELECT id, nome, gravidade, resposta FROM ocorrencias",
      "ocorrencias_crianca" => "SELECT id, ocorrencia_id, crianca_id, colaborador_id, DATE_FORMAT(data_ocorrencia,'%d/%m/%Y') AS data, comentario, foto FROM ocorrencias_crianca",
      "responsaveis" => "SELECT id, nome, telefone, telefone2, cpf, foto FROM responsaveis",
      "tentativas_contato" => "SELECT id, visita_id, responsavel_id, colaborador_id, DATE_FORMAT(data_tentativa,'%d/%m/%Y') AS data, IF(atendeu, 'sim', 'não'), comentario FROM tentativas_contato",
      "visitas" => "SELECT id, nome, gravidade, resposta FROM visitas",
  ];
  if (!array_key_exists($classe, $array_sql_select)) {
    echo json_encode(array('mysqli' => 'Classe inexistente: ' . $classe));
    exit;
  }
  $result = $mysqli->query($array_sql_select[$classe]);
  $linha = 1;
  while ($row = $result->fetch_array(MYSQLI_NUM)) {
    ?>
    <tr>
      <?php
      for ($i = 0; $i < sizeof($row); $i++) {
        ?>
        <td><?php echo $row[$i] ?></td>
        <?php
      }
      ?>
    </tr>
    <?php
  }
} else {

  // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
  // Note that is just an example. Should take precautions such as filtering the input data.

  header('Content-Type: application/json');

  $input = filter_input_array(INPUT_POST);



  if ($input['action'] == 'edit') {
    $mysqli->query("UPDATE tabledit SET name='" . $input['nome'] . "', gender='" . $input['gender'] . "', email='" . $input['email'] . "', phone='" . $input['phone'] . "', address='" . $input['address'] . "' WHERE id='" . $input['id'] . "'");
  } else if ($input['action'] == 'delete') {
    $mysqli->query("UPDATE tabledit SET deleted=1 WHERE id='" . $input['id'] . "'");
  } else if ($input['action'] == 'restore') {
    $mysqli->query("UPDATE tabledit SET deleted=0 WHERE id='" . $input['id'] . "'");
  }

  mysqli_close($mysqli);

  echo json_encode($input);
}
?>