<?php
    //Definir clase
    class Usuario{

        //Crear propiedades (atributos, variables)
        private $nombre;
        private $email;     

        public function __construct($nombre, $email){
            $this->nombre = $nombre;
            $this->email = $email;
        }

        //Método mágicos personalizados getters y setters
        public function getNombre(){
            return $this->nombre;
        }

        public function setNombre($nombre){
           $this->nombre = $nombre;
        }


        //Se usa para cerra conexiones a base de datos, limpiar o cerrar
        //Carga al final si no hay más elementos
        /* public function __destruct(){
            echo " Corriendo destructor";
        }   
         */
        
        //Métodos mágicos de php __get __set
        public function __get($propiedad){
            if(property_exists($this, $propiedad)){
                return $this->$propiedad;
            }
        }

        public function __set($propiedad, $valor){
            if(property_exists($this, $propiedad)){
                $this->$propiedad = $valor;
            }
            return $this;
        }

    }

    //Instanciar la clase para poder acceder a las propiedas
    $usuario1 = new Usuario("Jose", "admin@render2web.com");

    //Con getters y setters personalizados
    /* echo $usuario1->getNombre(); */
    echo "<br />";
    /* echo $usuario1->setNombre("Julian");
    echo $usuario1->getNombre(); */
    echo $usuario1->__get('email');
    $usuario1->__set("email", "carlos54@hotmail.com");
    echo $usuario1->__get('email');

  