<?php  
include "connection.php"; // Conecta ao banco de dados
// http://www.codeproject.com/Articles/267023/Send-and-receive-json-between-android-and-php

//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;

mysql_query("INSERT INTO `subway`.`subway` (numero, uf, detalhe) VALUES ('".$obj->{'numero'}."', '".$obj->{'uf'}."', '".$obj->{'detalhe'}."')");
mysql_close($con);
//
  //$posts = array($json);
  $posts = array(1);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts)); 
  ?>