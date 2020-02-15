<?php
/*
 *Enquete criada por Fernando Villela - Montepage coisas legais
 *e-mail: contato@montepage.com.br
 *divulgue, compartilhe, use, altere e mantenha os créditos.
*/
class Bancodedados{
    private $_conexao = "";
    protected $_errors = array();
    
    function __construct(){
        $this->_conexao = $this->conexao();
    }    
    function where($sql, $where){
            $i = 1;
            $where_inc = ' WHERE ';
            $total = count($where);
            foreach($where as $key => $value){
                $where_inc .=  " $key = '$value'";
                if($i < $total)
                    $where_inc .= " AND ";
                $i++;
            } 
            return $sql.$where_inc;
    }
    function group($sql, $group){
            $j = 1;
            $group_inc = ' GROUP BY';
            $total = count($group_inc);
            for($i=0;$i<$total;$i++){
                $group_inc .=  " $group[$i]";
                if($j < $total)
                    $group_inc .= ", ";
                $j++;
            }
            return $sql.$group_inc;
    }
    function consultas($tabela, $where=false, $group=false){
        switch($tabela){
            case 'idpergunta':  
            case 'pergunta':
                $sql = 'SELECT * FROM pergunta p';
                break;
            case 'idopcao':  
            case 'opcao':
                $sql = 'SELECT * FROM opcao o';
                break;
            case 'idvotos':
            case 'votos':
                $sql = 'SELECT * FROM votos v';
                break;
            case 'total-de-votos':
                $sql = 'SELECT COUNT(*) as total, o.id as opcao FROM votos v INNER JOIN opcao o ON v.idopcao=o.id INNER JOIN pergunta p ON o.idpergunta=p.id';
                break;
            default:
                $sql = false;
                break;
        }
        if($sql && $where)
            $sql = $this->where($sql, $where);
        if($sql && $group)
            $sql = $this->group($sql, $group);
        return $sql;
    }
    function arraycampos($tabela, $tipo='php'){
        switch($tabela){
                case 'pergunta':
                $array = array(
                               array('Pergunta da Enquete','nome','text'),
                               );
                break;
                case 'opcao':
                $array = array(
                               array('Enquete','idpergunta','select'),
                               array('Opção','nome','text')
                               );
                break;
                case 'mostraEnquetes':
                $array = array(
                               array('Pergunta da Enquete','nome','text'),
                               array('Ação','acao','acao')
                               );
                break;
                case 'mostraOpcoes':
                $array = array(
                               array('Opção de resposta','nome','text'),
                               array('Ação','acao','acao')
                               );
                break;
        }
        return $array;
    }
    function formatarIndex($valor, $campo){
        if($campo == 'datahora'){
            $ret = $this->converter_data_bf(substr($valor, 0, 10));
	    $ret .= ' '.$this->converter_time_bf(substr($valor, 11, 8));
            $valor = $ret;
        }else{
            $valor = $valor;
        }
        return $valor;
    }
    function inserir($array = false){
        $sql = false;
        if($array && is_array($array)){
            $tabela = array_pop($array);
            if($this->validar($tabela, $array)){
                $sql = "INSERT INTO $tabela VALUES('', ";
                $total = count($array); $total--;
                for($i=0;$i<count($array);$i++){
                    $sql .= "'".$array["$i"]."'";
                    if($i < $total)
                        $sql .= ", ";
                    else
                        $sql .=')';
                }
            }
            $res = $this->executaConsulta($sql);
        }else{
            $res = false;
        }
        return ($res?true:false);
    }  
    function conexao(){
        $link = mysql_connect('localhost', 'root', '');
        if (!$link) {
            die('Não foi possível conectar: ' . mysql_error());
        }
        mysql_select_db('php_enquete', $link);
        return $link;
    }
    function executaConsulta($sql){
        $result = mysql_query($sql, $this->_conexao);
        if (!$result) {
            die('Consulta inválida: ' . mysql_error());
        }else{
            return $result;
        }
    }
    function excluir($array=false){
        $sql = false;
        if(is_array($array)){
            $tabela = array_pop($array);
                $sql = "DELETE FROM $tabela ";
                $sql .=' WHERE id = '.$array[0];
            $res = $this->executaConsulta($sql);
         return ($res?'Excluido com Sucesso!':'Erro');
        }  
    }
    function totaldaenquete($id){
        $total = array();
        $sql = $this->consultas('total-de-votos',array('p.id' => $id));
        //echo $sql;
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            $total['total'] = mysql_result($result,'0','total');
        }else{
            $total['total'] = false;
        }
        $sql = $this->consultas('total-de-votos', array('p.id' => $id), array('o.id'));
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            while ($row = mysql_fetch_array($result)) {
                $idopcao = $row['opcao'];
                $total['opcao'][$idopcao] = $row['total'];
            }
        }else{
            $total['opcao'] = false;
        }
        return $total;
    }
    function ultimaenquete(){
        $res = array();
        $sql = $this->consultas('pergunta');
        $sql .= ' ORDER BY id DESC LIMIT 1';
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            $res['id']=mysql_result($result,'0','id');
            $res['nome']=mysql_result($result,'0','nome');
            $res['datahora']=mysql_result($result,'0','datahora');
        }else{
            $res['id'] = false; $res['nome'] = false; $res['datahora'] = false;
        }
        return $res;
    }   
    function validar($tabela, $array){
        //print_r($array);
        switch ($tabela){
            case 'votos':
                $sql = $this->consultas('opcao', array('id'=>$array[0]));
                break;
            default:
                return true;
                break;
        }
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
        
    }
    function getNome($nome=false, $id=false){
        if($nome && $id){
            $sql = $this->consultas($nome, array ( 'id' => $id));
            $result = $this->executaConsulta($sql);
            if(is_resource($result) && mysql_num_rows($result) > 0){
                $nome = mysql_result($result, 0 ,'nome');
            }
        }
        return $nome;
    }
   function converter_data_bf($strData) {
      // Recebemos a data no formato: aaa-mm-dd
      // Convertemos a data para o formato: dd/mm/aaaa
      if ( preg_match("#-#",$strData) == 1 ) {
	 //$strDataFinal = "'";
	 $strDataFinal = implode('/', array_reverse(explode('-',$strData)));
	 //$strDataFinal .= "'";
      }
      return $strDataFinal;
   }
   function converter_time_bf($strTime) {
	// Recebemos a hora no formato: hh:mm:ss
	// Convertemos a hora para o formato: hh:mm
	list($time1, $time2, $time3) = explode(":", $strTime);	
	$strTimeFinal = $time1.':'.$time2;
	return $strTimeFinal;
   }
}
?>