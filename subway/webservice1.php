<?php  
include "connection.php"; // Conecta ao banco de dados
//http://localhost:8080/sample1/webservice1.php?uf=ES


  /* soak in the passed variable or set our own */
  $format = isset($_GET['format']) ? (strtolower($_GET['format']) == 'xml' ? 'xml' : 'json'): 'json'; //json is the default
  $uf = strtoupper(isset($_GET['uf']) ? $_GET['uf'] : 'ES'); //ES is the default

  $query = "SELECT numero, detalhe, uf FROM `subway`.`subway` where `uf` = '$uf';";
  $result = mysql_query($query,$id);
  /* create one master array of the records */
  $lojas = array();
  if(mysql_num_rows($result)) {
    while($loja = mysql_fetch_assoc($result)) {
      $lojas[] = array('loja'=>$loja);
    }
  }
  /* output in necessary format */
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('lojas'=>$lojas));
  }
  else {
    header('Content-type: text/xml');
    echo '';
    foreach($lojas as $index => $loja) {
      if(is_array($loja)) {
        foreach($loja as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }
  /* disconnect from the db */
  @mysql_close($id);

?>