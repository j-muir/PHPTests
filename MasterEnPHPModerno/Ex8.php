<?php
// Ejercicio 1: Combinar strings usando (.)
$nombre = "José ";
$apellidos = 'Montoya';

$nombreCompleto = $nombre . " " . $apellidos;
echo $nombreCompleto;
echo "<br>";

// Ejercicio 2: Concatenar diferentes tipos de variables
$calificacion = 9;
$mayorEdad = true;

$infoUsuario = "El usuario: AQUINOMBRECOMPLETO, tiene una calificación de: " . $calificacion . " y es mayor de edad: " . $mayorEdad;
echo $infoUsuario;
echo "<br>";

/* 
Ejercicio 4: Funciones para trabajar con cadenas
*/

$nombres = "Jose";
$longitud = strlen($nombres);
echo $longitud;
echo "<br>";

// Ejercicio 5: Encuentra la posición de un string
$texto = "It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.";
$textoABuscar = "combined";
$posicion = strpos($texto, $textoABuscar);
echo $posicion;

// Ejercicio 6: Reemplazar strings
$texto3 = "written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. popular";
$textoReemplazado = str_replace('popular', 'MASIVO', $texto3);
echo $texto3;
echo "<br>";

// Ejercicio 7: Contar palabras
$articulo = "written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. popular";
$cantidadPalabras = str_word_count($articulo);
echo $cantidadPalabras;
echo "<br>";

// Ejercicio 8: Reordenar aleatoriamente un string
$producto = "Acetaminofen x 500 mg";
$productoDesordenado = str_shuffle($cantidadPalabras);
echo $cantidadPalabras;
echo "<br>";

// Ejercicio 9: Convertir a mayúsculas y minúsculas
$texto5 = "Written in 45 BC. This book is a treatise on the theory of ethics, very popular during the RENA. popular";
$mayusculas = strtoupper($texto5);
echo $mayusculas;
echo "<br>";
$minusculas =  strtolower($texto5);
echo $minusculas;
echo "<br>";

// Ejercicio 10: Envolver cantidad de caracteres
$texto6 = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.";
$textoWrap = wordwrap($texto6, 40, "<br />\n");
echo $textoWrap;
echo "<br>";

// Ejercicio 11: Eliminar espacios en blanco en el texto
$texto7 = " There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. ";
$textoSinEspacios = trim($texto7);
echo $textoSinEspacios;
?>
