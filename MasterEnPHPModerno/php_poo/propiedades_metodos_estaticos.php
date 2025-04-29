<?php

    class Usuario{
        public $nombre;
        public static $edadMinima = 18;

        public static function validarEdad($edad){
            if($edad >= self::$edadMinima){
                return true;
            }else{
                return false;
            }
        }
    }

    $edad = 18;

    if (Usuario::validarEdad($edad)) {
        echo "Puede ingresar";
    }else{
        echo "No puede ingresar";
    }