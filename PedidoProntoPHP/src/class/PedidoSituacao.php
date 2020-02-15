<?php

/**
 * <b>PedidoSituacao</b>
 * Esta classe foi criada para relacionar o Pedido com Situação
 *
 * @copyright (c) year, Filipe Salvarez Rezende FSRezende.com.br
 */
class PedidoSituacao extends Pai {

    private $situacao;
    private $pedido;
    private $dtPedidoSituacao;

    public function set(Situacao $situacao, Pedido $pedido, DateTime $dtPedidoSituacao) {
        if (isset($situacao))
            $this->situacao = $situacao;
        if (isset($pedido))
            $this->pedido = $pedido;
        if (isset($dtPedidoSituacao))
            $this->dtPedidoSituaca = $dtPedidoSituacao;
    }

}
