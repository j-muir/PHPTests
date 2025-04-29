<?php

    class Usuario{
        protected $nombre = "José Montoya";
        protected $edad = 42;
    }

    class Cliente extends Usuario{
        public function ahorroCliente(){
            return $this->nombre . " tiene: " . $this->edad . " años y $ 300.000 ahorrados";
        }
    }

    $cliente1 = new Cliente;
    echo $cliente1->ahorroCliente();