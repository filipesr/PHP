<?php

class Cliente {

    private $idcliente;
    private $nome;
    private $login;
    private $admin;

    public function __construct($registry) {
        $this->db = $registry->get('db');

        if (isset($_SESSION['idcliente'])) {
            $cliente_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cliente WHERE idcliente = '" . (int) $_SESSION['idcliente'] . "'");

            if ($cliente_query->num_rows) {
                $this->idcliente = $cliente_query->row['idcliente'];
                $this->nome = $cliente_query->row['nome'];
                $this->login = $cliente_query->row['login'];
                $this->admin = $cliente_query->row['admin'];
            } else {
                $this->logout();
            }
        }
    }

    public function login($login, $pass) {
        $cliente_query = $this->db->query("SELECT * 
                                             FROM " . DB_PREFIX . "cliente 
                                            WHERE login = '" . $login . "' 
                                              AND pass = '" . $pass . "'");

        if ($cliente_query->num_rows) {
            $this->session->data['idcliente'] = $cliente_query->row['idcliente'];
            $this->idcliente = $cliente_query->row['idcliente'];
            $this->nome = $cliente_query->row['nome'];
            $this->login = $cliente_query->row['login'];
            $this->admin = $cliente_query->row['admin'];
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($_SESSION['idcliente']);

        $this->idcliente = '';
        $this->nome = '';
        $this->login = '';
    }

    public function isLogged() {
        return $this->idcliente;
    }

    public function getId() {
        return $this->idcliente;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLogin() {
        return $this->login;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function getCategorias($idcliente = 0) {
        if ($idcliente){
            $sql = "Select *
                      from " . DB_PREFIX . "categoria
                     where idcategoria in ( select idcategoria
                                              from arquivo
                                             where (ativo = 1 or 1 = '" . $this->admin . "')
                                               and idcliente = '" . $idcliente . "')
                     order by nome";
        } else {
            $sql = "Select *
                      from " . DB_PREFIX . "categoria
                     order by nome";
        }
        $categoria_query = $this->db->query($sql);

        $return = array();
        foreach ($categoria_query->rows as $item) {
            $return[$item['idcategoria']] = array(
                'idcategoria' => $item['idcategoria'],
                'nome' => $item['nome'],
                'icone' => $item['icone'],
                'cor' => $item['cor']
            );
        }
        return $return;
    }

    public function getArquivos($idcliente) {
        $arquivo_query = $this->db->query("Select a.*
                                             from " . DB_PREFIX . "arquivo a
                                            inner join " . DB_PREFIX . "categoria c
                                                    on c.idcategoria = a.idcategoria
                                            where (a.ativo = 1 or 1 = '" . $this->admin . "')
                                              and a.idcliente = '" . $idcliente . "'
                                            order by c.nome, a.ativo desc, a.srcarquivo");


        $return = array();
        foreach ($arquivo_query->rows as $item) {
            $return[$item['idcategoria']][$item['idarquivo']] = array(
                'idarquivo' => $item['idarquivo'],
                'dtarquivo' => $item['dtarquivo'],
                'srcarquivo' => $item['srcarquivo'],
                'ativo' => $item['ativo'],
                'idcategoria' => $item['idcategoria'],
                'idcliente' => $item['idcliente']
            );
        }
        return $return;
    }

    public function getIdClientes() {
        $return = array();
        if ($this->admin) {
            $categoria_query = $this->db->query("Select idcliente, nome
                                                   from " . DB_PREFIX . "cliente
                                                  order by nome");

            foreach ($categoria_query->rows as $item) {
                $return[$item['idcliente']] = array(
                    'idcliente' => $item['idcliente'],
                    'nome' => $item['nome']
                );
            }
        } else {
            $return[$this->idcliente] = array(
                'idcliente' => $this->idcliente,
                'nome' => $this->nome
            );
        }
        return $return;
    }

}

?>