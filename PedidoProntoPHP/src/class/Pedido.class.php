<?php

/**
 * <b>Pedido</b>
 * Esta classe foi criada para armazenar as informações de cada pedido realizado pelo cliente.
 *
 * @copyright (c) year, Filipe Salvarez Rezende FSRezende.com.br
 */
class Pedido extends Pai {

    private $loja;
    private $cliente;
    private $dsPedido;
    private $dsAvaliacaoCliente;
    private $vlAvaliacaoCliente;

    public function set($dsPedido, $dsAvaliacaoCliente, $vlAvaliacaoCliente, Loja $loja, Cliente $cliente) {
        if (isset($dsPedido))
            $this->$dsPedido = $dsPedido;
        if (isset($dsAvaliacaoCliente))
            $this->$dsAvaliacaoCliente = $dsAvaliacaoCliente;
        if (isset($vlAvaliacaoCliente))
            $this->$vlAvaliacaoCliente = $vlAvaliacaoCliente;
        if (isset($loja))
            $this->$loja = $loja;
        if (isset($cliente))
            $this->$cliente = $cliente;
    }

}
