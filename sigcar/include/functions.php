<?php
/******************************************************************************
	BANCO DE FUN��ES
******************************************************************************/
/*
Esta fun��o executa um comando SQL no banco de dados MySQL
$id - Ponteiro da Conex�o
$sql - Cl�usula SQL a executar
$erro - Especifica se a fun��o exibe ou n�o(0=n�o, 1=sim)
$res - Resposta
*/
function sqlexec($id,$sql,$erro = 1) {
    if(empty($sql) OR !($id))
       return 0; //Erro na conex�o ou no comando SQL   
   if (!($res = @mysql_query($sql,$id))) {
      if($erro)
        echo "Ocorreu um erro na execu&ccedil;&atilde;o do Comando SQL no banco de dados. Favor Contactar o Administrador.<br>";
				echo $sql;
      exit;
   }
	 	//echo $sql;
    return $res;
 }
 
/*
Esta funcao cria um Select Combo dinamico
$nome - nome do select combo
$val	- valor atual
$sql 	- sql de conexao
*/
function selComb($nome,$val,$sql){
	//Executa a consulta
	$res = sqlexec($id,$sql);
	//Exibe as linhas encontradas na consulta
	echo "<select name='$nome' id='$nome'>";
	echo "  <option value='0'> </option>";
	while ($row = mysql_fetch_array($res)) {
		echo "<option value='".$row[0]."'";
		echo $row[0]==$val?"selected":"";
		echo ">".$row[1]."</option>";
	}
	echo "</select>";
}
?>