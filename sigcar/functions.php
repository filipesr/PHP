<?php

/* * ****************************************************************************
  BANCO DE FUN��ES
 * **************************************************************************** */
/*
  Esta funcao verifica se uma variavel $_REQUEST possui valor e retorna seu valor ou o valor default
  $var - nome da variavel
  $prefix - valor incluido antes do valor da variável
  $posfix - valor incluido depois do valor da variável
  $val	- valor default
 */

function retRequest($var, $prefix = "", $posfix = "", $val = "") {
  if(isset($_REQUEST[$var]) && ($_REQUEST[$var] != ""))
    return $prefix.$_REQUEST[$var].$posfix;
  else
    return $val;
}

/*
  Esta fun��o executa um comando SQL no banco de dados MySQL
  $id - Ponteiro da Conex�o
  $sql - Cl�usula SQL a executar
  $erro - Especifica se a fun��o exibe ou n�o(0=n�o, 1=sim)
  $res - Resposta
 */

function sqlexec($id, $sql, $oper = "0", $modulotab = "", $erro = 1) {
  if (empty($sql))
    return 0; //Erro na conex�o ou no comando SQL   
  include "connection.php"; // Conecta ao banco de dados
  if (!($res = @mysql_query($sql, $id))) {
    if ($erro)
      echo "Ocorreu um erro na execu&ccedil;&atilde;o do Comando SQL no banco de dados. Favor Contactar o Administrador.<br>$sql";
    exit;
  }else {
    if (($oper != "0") && (RetVar("select count(idaud) from taud where active = 1 and idmodulo = (select idmodulo from tmodulo where modulotab = '" . $modulotab . "') and a" . $oper . " = 1 -- $sql") == 1)) {
      sqlexec($id, 'INSERT INTO taudreg (iduser, idmodulo, dtreg, sqlreg) Values (' . $_SESSION['iduser'] . ',(select idmodulo from tmodulo where modulotab = "' . $modulotab . '"),now(), "' . $sql . '")');
    }
  }
  return $res;
}

/*
  Esta funcao cria um Select Combo dinamico
  $nome - nome do select combo
  $val	- valor atual
  $sql 	- sql de conexao
 */

function selComb($nome, $val, $sql) {
  //Executa a consulta
  include "connection.php"; // Conecta ao banco de dados
  $res = sqlexec($id, $sql);
  //Exibe as linhas encontradas na consulta
  echo "<select name='$nome' id='$nome'>";
  echo "  <option value=''> </option>";
  while ($row = mysql_fetch_array($res)) {
    echo "  <option value='" . $row[0] . "'";
    echo $row[0] == $val ? "selected>" : ">";
    echo $row[1] . "</option>";
  }
  echo "</select>";
}

/*
  Esta funcao cria um Select Combo SIM(1)/NAO(0)
  $nome - nome do select combo
  $val	- valor atual
 */

function selCombSN($nome, $val) {
  echo "<select name='$nome' id='$nome'>";
  echo "  <option value=''> </option>";
  echo "  <option value='0' ";
  echo $val == '0' ? "selected>" : ">";
  echo "n&atilde;o</option>";
  echo "  <option value='1' ";
  echo $val == '1' ? "selected>" : ">";
  echo "sim</option>";
  echo "</select>";
}

/*
  Esta funcao cria um Select Combo SIM(1)/NAO(0) somente
  $nome - nome do select combo
  $val	- valor atual
  $titulo - nome antes do combo
 */

function selCombSNX($nome, $val, $titulo = "") {
  echo "<select name='$nome' id='$nome'>";
  echo "  <option value='0' ";
  echo $val == '0' ? "selected>" : ">";
  echo "n&atilde;o</option>";
  echo "  <option value='1' ";
  echo $val == '1' ? "selected>" : ">";
  echo "sim</option>";
  echo "</select>" . $titulo;
}

/*
  Esta funcao cria uma CheckBox Checked(1)/Unchecked(0)
  $nome - nome do CheckBox
  $val	- valor atual
  $txt	- texto posterior
 */

function cbS($nome, $val, $txt) {
  echo "<input class='campoCK' name='$nome' type='checkbox' value='1'";
  echo $val == '1' ? "checked>" : ">";
  echo $txt;
}

/*
  Esta fun��o cria um input e um botao para selecionar uma data
  $table- tabela
  $nome - nome do input
  $val	- valor atual
 */

function dtCal($table, $nome, $val) {
  echo "<input class='campoData' name='$nome' type='text' class='form03' value='" . $val . "'>";
  echo "<a href='javascript: void(0);' onmouseover='if (timeoutId) clearTimeout(timeoutId);window.status=\"Mostar Calendario\";return true;' onmouseout='if (timeoutDelay) calendarTimeout();window.status=\"\";' onclick='g_Calendar.show(event,\"$table.$nome\",true,\"yyyy-mm-dd\"); return false;'><img src='../imagens/calendar.gif' name='imgCalendar' width='34' height='21' border='0' alt=''></a>";
}

/*
  Esta fun��o cria um input para digitar a hora e um input e um botao para selecionar uma data
  $table- tabela
  $nomeHr - nome do input da hora
  $nomeDr - nome do input da Data
  $val	- valor atual
 */

function dtCalHor($table, $nomeHr, $nomeDt, $val) {
  echo "Hora <input class='campoData' name='$nomeHr' type='text' class='form03' value='" . $val . "'> ";
  echo "Data <input class='campoData' name='$nomeDt' type='text' class='form03' value='" . $val . "'>";
  echo "<a href='javascript: void(0);' onmouseover='if (timeoutId) clearTimeout(timeoutId);window.status=\"Mostar Calendario\";return true;' onmouseout='if (timeoutDelay) calendarTimeout();window.status=\"\";' onclick='g_Calendar.show(event,\"$table.$nomeDt\",true,\"yyyy-mm-dd\"); return false;'><img src='../imagens/calendar.gif' name='imgCalendar' width='34' height='21' border='0' alt=''></a>";
}

/*
  Esta fun��o retorna a string 'NULL' caso o valor passado esteja vazio
  $val - valor a ser verificado
 */

function retNULL($val) {
  if (($val == "") || ($val == "''")) {
    return "NULL";
  }
  else {
    return "'" . $val . "'";
  };
}

/*
  Esta funcao retorna um valor �nico na consulta
  $sql
 */

function RetVar($sql) {
  // echo("$sql <BR>");
  //Executa a consulta
  include "connection.php"; // Conecta ao banco de dados
  $res = sqlexec($id, $sql);
  //Exibe as linhas encontradas na consulta
  $row = mysql_fetch_array($res);
  return $row[0];
}

/*
  Esta funcao retorna o proximo valor de um campo autoincremento de uma tabela
  $table - nome da tabela
 */

function NextAI($table) {
  //Executa a consulta
  include "connection.php"; // Conecta ao banco de dados
  $sql = 'SELECT AUTO_INCREMENT FROM information_schema.tabLES where tabLE_SCHEMA = "' . $dbname . '" AND tabLE_NAME = "' . $table . '"';
  return RetVar($sql);
}

/*
  Esta funcao compara vr com eq e retorna vr se forem diferentes e vr2 se forem iguais
  $vr		- valor um
  $eq 	- valor de compara�ao
  $vr2	- valor dois
 */

function vrIF($vr, $eq, $vr2) {
  if ($vr == $eq) {
    return $vr2;
  }
  else {
    return $vr;
  }
}

/*
  Esta funcao verifica se ja existe um modulo na posi�ao e abre espa�o
  $ord - nova ordem
  $idmodulo
 */

function AjustaOrd($ord, $idmodulo) {
  //Executa a consulta
  include "connection.php"; // Conecta ao banco de dados
  $sql = "SELECT count(ord) from tmodulo where ord = $ord";
  if ($idmodulo != "") {
    $sql.=" and idmodulo <> " . $idmodulo;
  };
  return RetVar($sql);
}

/*
  Esta funcao cria o link de ordena��o do menu
  $valor - o valor pego
  $nome - Nome q aparecera no link
 */

function atit($valor, $nome) {
  //Executa a consulta
  $ordem = retRequest('ordem');
  $w = retRequest('w', "&w=");
  $desc = retRequest('desc');
  $pesq = retRequest('pesq', "&pesq=");
  
  if ($ordem == "order by " . $valor)
    $str.= $desc == "" ? "^" : "v";
  $str.= "<a href='?ordem=order by " . $valor . $w;
  if ($ordem == "order by " . $valor)
    $str.= $desc == "" ? "&desc=Desc" : "";
  $str.= $pesq . "'>" . $nome . "</a>";
  echo $str;
}

/*
  Esta funcao cria uma sa�da padr�o para os arquivos envia_cad
  $sqlret - Retorno do SQL execudado
  $home - home
  $modulotab - modulotab
  $PRI = chave primaria para insers�o em sequencia
 */

function SaidaEnvia_cad($sqlret, $home, $modulotab, $PRI) {
  $pesq = retRequest('pesq');
  if ($sqlret == 1) {
    if ($pesq != "") {
      echo "<script language= \"JavaScript\">";
      echo "	location.href=\"" . $home . "/cad/" . $modulotab . ".php?" . $PRI . "&pesq=" . $pesq . "\"";
      echo "</script>";
    };
    echo "<div align=center>";
    echo "	<font size=2 face=Verdana, Arial, Helvetica, sans-serif>";
    echo "		<br><br><br>";
    echo "		Opera&ccedil;&atilde;o realizada com sucesso.";
    //if ($oper!="Excluir") {
    //		echo "		<br><br>";
    //		echo "		<a href='javascript:history.back(1)'>";
    //		echo "			Editar novamente";
    //		echo "		</a>";
    //	};
    if ($oper == "Inserir") {
      echo "		<br><br>";
      echo "		<a href='cad" . $modulotab . ".php?oper=Inserir'>";
      echo "			Inserir outro";
      echo "		</a>";
    };
    echo "		<br><br>";
    echo "		<a href='" . $modulotab . ".php'>";
    echo "			Voltar";
    echo "		</a>";
    echo "	</font>";
    echo "</div>"; //se cadastrou com sucesso o usu�rio aparece essa mensagem
  }
  else {
    echo "<div align=center>";
    echo "	<font size=2 face=Verdana, Arial, Helvetica, sans-serif>";
    echo "		<br><br><br>";
    echo "		Ocorreu um erro no servidor ao tentar realizar essa opera&ccedil;&atilde;o.";
    echo "		<br><br>";
    echo "		<a href='" . $modulotab . ".php'>";
    echo "			Voltar";
    echo "		</a>";
    echo "	</font>";
    echo "</div>"; //caso houver um erro quanto as configura��es aparece essa mensagem
  }
}

/*
  Esta funcao cria a tabela de relat�rio
  $idrel - id do relat�rio a ser criado
  $Cabwhere - where da linha quando o relatorio � um detalhe
 */

function Criarelatorio($idrel, $Cabwhere = "") {
  $tabNome = RetVar("select reltab from trel where idrel = " . $idrel);
  $tabwhere = RetVar("select relwhere from trel where idrel = " . $idrel) . $Cabwhere;
  if ($tabwhere != "") {
    $tabwhere = " where " . $tabwhere;
  };
  $sel = "Select ";
  $g = "";
  $r = 0;
  $ord = " order by ";
  //Executa a consulta
  $sql = "select * from trelcol where idrel = $idrel order by ord ";
  include "connection.php"; // Conecta ao banco de dados
  $res = sqlexec($id, $sql);
  //Exibe as linhas encontradas na consulta
  while ($row = mysql_fetch_array($res)) {
    $campo = $row['relcol'];
    if ("0" . $row['idrelfunc'] != "0") {
      $campo = RetVar("select CONCAT(funcpre,'" . $campo . "',funcpos) from trelfunc where idrelfunc = " . $row['idrelfunc']);
    };
    if ($ord != " order by ") {
      $ord.=", ";
    };
    $ord.=$campo;
    if ($row['mostrar'] == 1) {
      if ($sel != "Select ") {
        $sel.=", ";
      };
      $r++;
      $tit.="<td><strong>" . $row['relcoltit'] . "</strong></td>";
      $sel.=$campo;
    };

    if ($row['Agrup'] == 1) {
      if ($g != "") {
        $g.=", ";
      };
      $g.=$campo;
    };
  };
  if ($g != "") {
    $g = " group by " . $g;
  };
  $sql = $sel . " from " . $tabNome . $tabwhere . $g . $ord;
  echo " <table border='1'><tr>" . $tit . "</tr>";
  include "connection.php"; // Conecta ao banco de dados
  $res = sqlexec($id, $sql);
  //Exibe as linhas encontradas na consulta
  while ($row = mysql_fetch_array($res)) {
    echo "<tr>";
    for ($i = 0; $i < $r; $i++) {
      echo "<td>" . $row[$i] . "</td>";
    };
    echo "</tr>";
  }
  echo "</table>";
}

/*
  Esta funcao faz o tratamento do envio de arquivo e o move para a pasta correta
  $arquivo['name'] - $_FILES['foto1']
  &$nomeArquivo - Passagem por referencia para preencher o nome do arquivo
 */
function trataFoto($arquivo, &$nomeArquivo){
  echo "<BR>Arquivo: " . $arquivo['name'] . ": ";

  // Pasta onde o arquivo vai ser salvo
  $_UP['pasta'] = 'imagens/fotos/';

  // Tamanho máximo do arquivo (em Bytes)
  $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
  
  // Array com as extensões permitidas
  $_UP['extensoes'] = array('jpg', 'png', 'gif');
  
  // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
  $_UP['renomeia'] = true;
  
  // Array com os tipos de erros de upload do PHP
  $_UP['erros'][0] = 'Não houve erro';
  $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
  $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
  $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
  $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($arquivo['error'] != 0) {
	die("Não foi possível fazer o upload, erro:"
		 . "<br />foto: " . $_UP['erros'][$arquivo['error']] . "<br />"
	);
	return false; // Para a execução do script
  }

  // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
  // Faz a verificação da extensão do arquivo
  $extensao1 = strtolower(end(explode('.', strtolower($arquivo['name']))));

  if (array_search($extensao1, $_UP['extensoes']) === false) {
	echo "Erro foto 1: Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif<br />";
	return false;
  }
  
  // Faz a verificação do tamanho do arquivo
  else if ($_UP['tamanho'] < $arquivo['size']) {
	echo "Erro foto 1: O arquivo enviado é muito grande, envie arquivos de até 2Mb.<br />";
	return false;
  }
  
  // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
  else {
	// Primeiro verifica se deve trocar o nome do arquivo
	if ($_UP['renomeia'] == true) {
	  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
	  $nomeArquivo = time().'.'.$extensao1;
	} else {
	  // Mantém o nome original do arquivo
	  $nomeArquivo = $arquivo['name'];
	}
	
	// Depois verifica se é possível mover o arquivo para a pasta escolhida
	if (file_exists(str_replace("cad","", getcwd()) . $_UP['pasta']) && is_writable(str_replace("cad","", getcwd()) . $_UP['pasta'])) {
	  if (move_uploaded_file($arquivo['tmp_name'], str_replace("cad","", getcwd()) . $_UP['pasta'] . $nomeArquivo)) {
		// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		echo "Upload efetuado com sucesso!";
	  } else {
		// Não foi possível fazer o upload, provavelmente a pasta está incorreta
		echo "Não foi possível enviar o arquivo, tente novamente!";
		return false;
	  }
	} else {
	  // Não foi possível fazer o upload, provavelmente a pasta não existe ou não tem permissão de escrita
	  echo $_UP['pasta'] . "<BR>Pasta existe: " . (file_exists($_UP['pasta'])?"sim":"nao") . "<BR>Permissão de escrita: " . (is_writable($_UP['pasta'])?"sim":"nao");
	  return false;
	}

  return true;
  }
}


?>