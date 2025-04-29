<?php
    //Definir clase
    class Usuario{

        //Crear propiedades (atributos, variables)
        public $nombre;
        public $email;

        //Constructor
        /* public function __construct(){
            echo "carga el constructor";
        } */

        public function __construct($nombre, $email){
            $this->nombre = $nombre;
            $this->email = $email;
        }

        //Crear métodos (funciones)
        public function presentacion(){
            return $this->nombre . " Hola a todos";
        }

        //Se usa para cerra conexiones a base de datos, limpiar o cerrar
        //Carga al final si no hay más elementos
        public function __destruct(){
            echo "Corriendo destructor";
        }

    }

    //Instanciar la clase para poder acceder a las propiedas
    $usuario1 = new Usuario("Jose", "admin@render2web.com");

    echo $usuario1->nombre . " y el email es: " . $usuario1->email;

    $usuario2 = new Usuario("Carlos", "carlos@gmail.com");
    echo "<br />";
    echo $usuario2->nombre . " y el email es: " . $usuario2->email;
  