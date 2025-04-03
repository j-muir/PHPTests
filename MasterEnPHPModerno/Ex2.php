<?php

// Ejercicio 1: Calcular el área de un triángulo
$baseTriangulo = 8;
$alturaTriangulo = 12;
// Completa el código para calcular el área del triángulo y asignarlo a $areaTriangulo.
$areaTriangulo = $baseTriangulo * $alturaTriangulo;
$areaTriangulo = $areaTriangulo / 2;
echo $areaTriangulo;

// Ejercicio 2: Calcular el descuento en una compra
$precioProducto = 50;
$descuentoPorcentaje = 20;
// Completa el código para calcular el precio con descuento y asignarlo a $precioConDescuento.
$precioConDescuento = $precioProducto * $descuentoPorcentaje;
$precioConDescuento = $precioConDescuento / 100;
$precioConDescuento = $precioProducto - $precioConDescuento;
echo $precioConDescuento;

// Ejercicio 3: Verificar si un número es par o impar
$numero = 15;
// Completa el código para verificar si $numero es par o impar y asignar el resultado a $esPar.
$esPar = ($numero % 15) ? true : false;
echo ($esPar) ? "impar" : "par";


// Ejercicio 4: Concatenar texto
$nombre = "Juan";
$apellido = "Pérez";
// Completa el código para concatenar $nombre y $apellido y asignarlo a $nombreCompleto.
$nombreCompleto = $nombre . " " . $apellido;
echo $nombreCompleto;

// Ejercicio 5: Incremento
$contador = 5;
// Completa el código para incrementar $contador en 1.
$contador++;
echo $contador;

// Ejercicio 6: Decremento
$contadorDecremento = 10;
// Completa el código para decrementar $contadorDecremento en 1.
$contadorDecremento--;
echo $contadorDecremento;

// Ejercicio 7: Módulo
$numerator = 19;
$denominator = 5;
// Completa el código para calcular el residuo de la división de $numerator por $denominator y asignarlo a $remainder.
$remainder = $numerator % $denominator;
echo $remainder;

// Ejercicio 8: Precedencia de Operadores
// Completa el código para calcular el resultado de 2 + 3 * 4 y asignarlo a $resultadoPrecedencia.
$resultadoPrecedencia = 2 + 3 * 4;
echo $resultadoPrecedencia;
?>
