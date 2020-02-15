<?php
/*
 *Enquete criada por Fernando Villela - Montepage coisas legais
 *e-mail: contato@montepage.com.br
 *divulgue, compartilhe, use, altere e mantenha os créditos.
*/
class Html extends Bancodedados{
    function options($nome, $id=false){
        $res = false;
        $sql = $this->consultas($nome);
        $result = $this->executaConsulta($sql);
        if($result){
            while ($row = mysql_fetch_array($result)) {
                $res .= '<option value="'.$row['id'].'" '.($id?($id==$row['id']?'selected="selected"':''):'').'>'.$row['nome'].'</option>';
            }
        }
        return $res;
    }
    function novaEnquete(){
        echo '<fieldset><legend>Nova Enquete</legend><h2>Criar nova Enquete</h2>'.$this->formulario('pergunta').'</fieldset>';
    }
    function novaOpcao($id){
        echo '<h3>Criar nova Opção de Resposta para a Enquete</h3>'.$this->formulario('opcao',$id);
    }
    function formulario($nome=false, $id=false){
        $res = false;
        if($nome){
            $campos = $this->arraycampos($nome);
            $res = '<form name="'.$nome.'" method="post" action="" id="senddata">';
            $res .= '<input type="hidden" value="'.$nome.'" name="formulario" />';
            for($i=0;$i<count($campos);$i++){
                $res .= '<label for="'.$campos[$i][1].'">'.$campos[$i][0].'</label>';
                if($campos[$i][2] == 'text'){
                    $res .= '<input type="text" value="" name="'.$campos[$i][1].'" size="80" />';
                }
                if($campos[$i][2] == 'select'){
                    $res .= '<select name="'.$campos[$i][1].'">'.$this->options($campos[$i][1], ($id?$id:false)).'</select>';
                }
                $campo = $campos[$i][1];
                if(isset($this->_errors[$campo])){
                   $res .= '<div class="erro">'.$this->_errors[$campo].'</div>';
                }
                $res .= '<br />';
            }
            $res .= '<input type="submit" name="Salvar" value="Salvar" />';
            $res .= '</form>';
        }
        return $res;
    }
    function mostraOpcoes($where=false){
        $arraycampos = $this->arraycampos('mostraOpcoes');
        $sql = $this->consultas('opcao',array('idpergunta' => $where));
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            //echo 'result: '.mysql_num_rows($result);
            $res = '<table border=1>';
                $res .= '<tr>';
            for($i=0;$i<count($arraycampos);$i++){
                $campo = $arraycampos[$i][0];
                $res .= '<th>'.$campo.'</th>';
            }
            $res .= '</tr>';        
            while ($row = mysql_fetch_array($result)) {
                $res .= '<tr>';
                for($i=0;$i<count($arraycampos);$i++){
                    if($arraycampos[$i][2] == 'acao'){
                        $res .= '<td><a href="cadastrar.php?page=op_excluir&idopcao='.$row['id'].'&id='.$where.'">Excluir</a></td>';
                    }else{
                        $campo = $arraycampos[$i][1];
                        $res .= '<td>'.$this->formatarIndex($row["$campo"], $campo).'</td>';
                    }
                }
                $res .= '</tr>';
            }
            $res .= '</table>';
        }else{
            $res = '<p>Nenhuma Opção Cadastrada.</p>';
        }
        return $res;
    }
    function mostraEnquetes($where=false){
        $arraycampos = $this->arraycampos('mostraEnquetes');
        $sql = $this->consultas('pergunta');
        $result = $this->executaConsulta($sql);
        if(is_resource($result) && mysql_num_rows($result) > 0){
            //echo 'result: '.mysql_num_rows($result);
            $res = '<table border=1>';
                $res .= '<tr>';
            for($i=0;$i<count($arraycampos);$i++){
                $campo = $arraycampos[$i][0];
                $res .= '<th>'.$campo.'</th>';
            }
            $res .= '</tr>';        
            while ($row = mysql_fetch_array($result)) {
                $res .= '<tr>';
                for($i=0;$i<count($arraycampos);$i++){
                    if($arraycampos[$i][2] == 'acao'){
                        $res .= '<td><a href="cadastrar.php?page=editar&id='.$row['id'].'">Editar</a> - <a href="cadastrar.php?page=excluir&id='.$row['id'].'">Excluir</a></td>';
                    }else{
                        $campo = $arraycampos[$i][1];
                        $res .= '<td>'.$this->formatarIndex($row["$campo"], $campo).'</td>';
                    }
                }
                $res .= '</tr>';
            }
            $res .= '</table>';
        }else{
            $res = '<p>Nenhuma Enquete Cadastrada.</p>';
        }
        return $res;
    }

    function mostraresultados($id){
        $total = $this->totaldaenquete($id);
            foreach($total['opcao'] as $key => $value){
                    $percent=round(($value*100)/$total['total']);
                    echo '<div class="option" ><p>'.utf8_encode($this->getNome('opcao',$key)).' : (<em>'.$percent.'%, '.$value.' votos</em>)</p>';
                    echo '<div class="bar ';
                    if(isset($_POST['poll']) && $_POST['poll']==$key) echo ' seu voto';
                    echo '" style="width: '.$percent.'%; " ></div></div>';
            }
            if($total['total'])
                echo '<p>Total de Votos: '.$total['total'].'</p>';
    }
    function mostraOpcoesComRadio($poll_id){
        $query = $this->consultas('opcao', array('idpergunta'=>$poll_id));
	$result = $this->executaConsulta($query);
	if(is_resource($result) && mysql_num_rows($result) > 0){
	    echo '<div id="formcontainer" ><form method="post" id="pollform" action="'.$_SERVER['PHP_SELF'].'" >';
            echo '<input type="hidden" name="pollid" value="'.$poll_id.'" />';
	    while ($row = mysql_fetch_array($result)) {
		echo '<p><input type="radio" name="poll" value="'.$row['id'].'" id="option-'.$row['id'].'" /> 
		<label for="option-'.$row['id'].'" >'.utf8_encode($row['nome']).'</label></p>';
	    }
	    echo '<p><input type="submit"  value="Votar" /></p></form>';
	    echo '<p><a href="'.$_SERVER['PHP_SELF'].'?result=1" id="viewresult">Ver Resultados</a></p></div>';
	}
    }
}
?>