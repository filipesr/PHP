<?php

$id = intval($_REQUEST['id']);
$table = $_REQUEST['class'];

include 'conn.php';

$sql = "delete from $table where id=$id";
@mysql_query($sql);
echo json_encode(array('success'=>true));
?>