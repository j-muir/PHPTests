<?php
// Ejercicio 1: Calcular el promedio
function calcularPromedio($numeros) {
    $suma = array_sum($numeros);           
    $cantidad = count($numeros);           
    if ($cantidad === 0) {
        return 0;                         
    }
    return $suma / $cantidad;              
}

$numeros = [10, 20, 30, 40];
$promedio = calcularPromedio($numeros);
echo "El promedio es: $promedio";

// Ejercicio 2: Encontrar el número máximo
function encontrarMaximo($numeros) {
    $maximo = $numeros[0]; 
    foreach ($numeros as $numero) {
        if ($numero > $maximo) {
            $maximo = $numero;
        }
    }
    return $maximo;
}

$numerosTotales = [109, 23, 325, 1237];
$maximo = encontrarMaximo($numerosTotales);
echo "Número máximo: $maximo";

// Ejercicio 3: Contar palabras en una cadena
function contarPalabras($cadena) {
    return str_word_count($cadena);
}

$cadenaTexto = "Cadena de Texto";
$cantidad = contarPalabras($cadenaTexto);
echo "Cantidad de palabras: $cantidad";

// Ejercicio 4: Calcular el factorial de un número
function calcularFactorial($numero) {
    $factorial = 1;
    for ($i = 1; $i <= $numero; $i++) {
        $factorial *= $i;
    }

    return $factorial;
}

$numero = 5;
$resultado = calcularFactorial($numero);
echo "El factorial de $numero es: $resultado";
?>


