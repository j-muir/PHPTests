<?php
    //Definir clase
    class Usuario{

        //Crear propiedades (atributos, variables)
        public $nombre;
        public $email;

        //Crear métodos (funciones)
        public function presentacion(){
            return $this->nombre . " Hola a todos";
        }

    }

    //Instanciar la clase para poder acceder a las propiedas
    $usuario1 = new Usuario;
    $usuario1->nombre = "José";
    echo "<br />";
    $usuario1->email = "admin@render2web.com";
    echo "<br />";
    echo $usuario1->presentacion();

    $usuario2 = new Usuario;
    $usuario2->nombre = "Carlos";
    echo "<br />";
    $usuario2->email = "carlos@gmail.com";
    echo "<br />";
    echo $usuario2->presentacion();