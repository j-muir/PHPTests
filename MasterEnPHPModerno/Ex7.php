<?php

// Ejercicio: Calcular la suma de los dígitos de un número
$numero = 12345; // Cambia este valor para calcular la suma de los dígitos de otro número
$sumaDigitos = 0;

// Utiliza un ciclo do-while para calcular la suma de los dígitos

// Tu código aquí
do {
    $digito = $numero % 10;
    $sumaDigitos += $digito;
    $numero = (int)($numero / 10);
}while($numero > 0);

// Imprime el resultado

echo $sumaDigitos;

?>