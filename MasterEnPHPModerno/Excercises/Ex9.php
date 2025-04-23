<?php
// 1. Crear un array llamado $colores con los siguientes valores: Rojo, Verde, Azul
$colores = ["rojo", "verde", "azul"];
var_dump($colores);

// 2. Agregar el color Amarillo al array anterior
$colores[] = "amarillo";
var_dump($colores);

// 3. Obtener el primer color en una variable llamada $primerColor
$primerColor = $colores[0];
var_dump($primerColor);


// 4. Contar colores en una variable llamada $cantidadColores
$cantidadColores = count($colores);
var_dump($cantidadColores);

// 5. Comprobar existencia de un color en una variable llamada $existeColor pero primero crea una variable para guardar el color que se neceista encontrar en una variable llamada $colorBuscado y que busque el color Verde y que busque en el array $colores
$colorBuscado = "verde";
$existeColor = in_array($colorBuscado, $colores);
var_dump($existeColor);

// 6. Eliminar el último color
array_pop($colores);
var_dump($colores);

?>
