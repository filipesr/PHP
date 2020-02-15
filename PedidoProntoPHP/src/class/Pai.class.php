<?php

/**
 * <b>Pai</b>
 * Esta classe foi criada para ser a base das outras classes
 *
 * @copyright (c) year, Filipe Salvarez Rezende FSRezende.com.br
 */
class Pai {

    /** @var int identificador */
    private $id;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

}
