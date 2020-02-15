<?php
/**
* Template de redirecionamento para o getway de pagamento
*
* N�o visto pelo usu�rio, ao entrar nesta p�gina, o formul�rio � submetido
* automaticamente.
* @package pagseguro_opencart
* @author ldmotta - ldmotta@gmail.com
* @link motanet.com.br
*/
?>
<div class="buttons">
<table>
<tr>
<td align="left"><a onclick="location='<?php echo $back; ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
<td align="right" id="checkout"><?php echo $this->form; ?></td>
</tr>
</table>
</div>

<script type="text/javascript"><!--
$('#checkout form').submit(function() {
    $.ajax({
        type: 'GET',
        url: 'index.php?route=payment/pagseguro/confirm',
        success: function(t) {
            location = '<?php echo $continue; ?>'
        }
    });
})
//--></script>
