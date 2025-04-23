<?php

// Ejercicio: Calcular el factorial de un número
$numero = 5; // Cambia este valor para calcular el factorial de otro número
$factorial = 1;

// Utiliza un ciclo for para calcular el factorial

// Tu código aquí

for($i = 1; $i <= $numero; $i++){
    $factorial *= $i;
}

// Imprime el resultado del factorial

echo $factorial;

?>