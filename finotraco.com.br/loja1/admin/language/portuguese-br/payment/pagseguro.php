<?php
// Heading
$_['heading_title']       			= 'PagSeguro';

// Text
$_['text_payment']        			= 'Pagamento';
$_['text_success']        			= 'Módulo PagSeguro atualizado com sucesso!';
$_['text_pagseguro'] 				= '<a onclick="window.open(\'http://www.pagseguro.com.br/\');"><img src="view/image/payment/pagseguro_uol.gif" alt="PagSeguro" title="PagSeguro" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_order_nao_efetivado'] 		= 'O pagamento no site do PagSeguro n&atilde;o foi conclu&iacute;do.';
$_['text_frete_loja']        		= 'pela loja';
$_['text_frete_pagseguro_pac']      = 'pelo PagSeguro usando PAC';
$_['text_frete_pagseguro_sedex']    = 'pelo PagSeguro usando Sedex';
$_['text_frete_pagseguro_nao_especificado'] = 'pelo PagSeguro. O cliente escolhe entre PAC e Sedex';

// Entry
$_['entry_token']         				= 'Token:<br /><span class="help">Token de Seguran&ccedil;a</span>';
$_['entry_email']         				= 'Email:<br /><span class="help">E-mail de cadastro no PagSeguro</span>';
$_['entry_posfixo']         			= 'Pós-fixo para o número do pedido:<br /><span class="help">Útil para identificar no PagSeguro de qual loja pertence o pedido. Ex. para pedido de nro. 15 e pós-fixo "loja01", a refer&ecirc;ncia do pedido no PagSeguro ser&aacute; "15_loja01" </span>';
$_['entry_tipo_frete']         			= 'C&aacute;lculo do frete feito:<br /><span class="help">Se optar pelo c&aacute;lculo feito pela loja, escolha "Frete fixo" em Prefer&ecirc;ncias de frete no PagSeguro sen&atilde;o marque "Frete por peso" para que o PagSeguro fa&ccedil;a os c&aacute;lculos.</span>';

$_['entry_order_aguardando_retorno'] 	= 'Status Aguardando retorno:<br /><span class="help">a loja aguarda o primeiro retorno da transa&ccedil;&atilde;o pelo PagSeguro.</span>';
$_['entry_order_aguardando_pagamento'] 	= 'Status Aguardando pagamento:<br /><span class="help">o comprador iniciou a transa&ccedil;&atilde;o, mas at&eacute; o momento o PagSeguro n&atilde;o recebeu nenhuma informa&ccedil;&atilde;o sobre o pagamento.</span>';
$_['entry_order_analise'] 				= 'Status Em an&aacute;lise:<br /><span class="help">o comprador optou por pagar com um cart&atilde;o de cr&eacute;dito e o PagSeguro est&aacute; analisando o risco da transa&ccedil;&atilde;o.</span>';
$_['entry_order_paga'] 					= 'Status Paga:<br /><span class="help">a transa&ccedil;&atilde;o foi paga pelo comprador e o PagSeguro j&aacute; recebeu uma confirma&ccedil;&atilde;o da institui&ccedil;&atilde;o financeira respons&aacute;vel pelo processamento.</span>';
$_['entry_order_disponivel'] 			= 'Status Dispon&iacute;vel:<br /><span class="help">a transa&ccedil;&atilde;o foi paga e chegou ao final de seu prazo de libera&ccedil;&atilde;o sem ter sido retornada e sem que haja nenhuma disputa aberta.</span>';
$_['entry_order_disputa'] 				= 'Status Disputa:<br /><span class="help">o comprador, dentro do prazo de libera&ccedil;&atilde;o da transa&ccedil;&atilde;o, abriu uma disputa.</span>';
$_['entry_order_devolvida'] 			= 'Status Devolvida:<br /><span class="help">o valor da transa&ccedil;&atilde;o foi devolvido para o comprador.</span>';
$_['entry_order_cancelada'] 			= 'Status Cancelada:<br /><span class="help">a transa&ccedil;&atilde;o foi cancelada sem ter sido finalizada.</span>';

$_['entry_geo_zone']      			= 'Regi&atilde;o geogr&aacute;fica:';
$_['entry_status']        			= 'Situa&ccedil;&atilde;o:';
$_['entry_sort_order']    			= 'Ordena&ccedil;&atilde;o:';
$_['entry_update_status_alert'] 	= 'Alertar sobre mudan&ccedil;a no status da transa&ccedil;&atilde;o:<br /><span class="help">Envia e-mail para o cliente avisando-o sobre mudan&ccedil;a no status do pedido.</span>';

// Error
$_['error_permission']    		= 'Aten&ccedil;&atilde;o: Voc&ecirc; n&atilde;o possui permiss&atilde;o para modificar o PagSeguro!';
$_['error_token']         		= 'Digite o token de seguran&ccedil;a';
$_['error_email']         		= 'Digite o e-mail de cadastro no PagSeguro';
?>