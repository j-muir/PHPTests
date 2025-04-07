<?php

// Ejercicio: Encontrar el primer número par mayor o igual a un valor dado
$valorDado = 7; // Cambia este valor para establecer tu objetivo
$numero = 1; // Iniciamos desde el primer número entero positivo

// Utiliza un ciclo while para encontrar el primer número par

// Tu código aquí

while ($numero % 2 !== 0 || $numero < $valorDado){
    $numero++;
} 

// Imprime el resultado
echo $numero;
?>
