<?php 

/*Escribe un programa en PHP que determine la calificación de un estudiante según su puntaje.

Utiliza la variable $nota para almacenar el puntaje del estudiante. Puedes cambiar el valor de $nota para probar diferentes puntajes.

Utiliza condicionales if, else if y else para determinar la calificación basada en el siguiente criterio:

    Si la nota es mayor o igual a 90, muestra "Calificación: A".

    Si la nota es mayor o igual a 80 pero menor que 90, muestra "Calificación: B".

    Si la nota es mayor o igual a 70 pero menor que 80, muestra "Calificación: C".

    Si la nota es mayor o igual a 60 pero menor que 70, muestra "Calificación: D".

    Si la nota es menor que 60, muestra "Calificación: F". */

// Obtener la calificación del estudiante, te dejo la nota puedes cambiarla a otra
$nota = 75;

// Evaluar y mostrar la calificación. Escribe aquí debajo las condiciones

if ($nota >= 90){
    echo "Calificación: A";
}elseif ($nota >= 80 || $nota < 90){
    echo "Calificación: B";
}elseif ($nota >= 70 || $nota < 80){
    echo "Calificación: C";
}elseif ($nota >= 60 || $nota < 70){
    echo "Calificación: D";
}else {
    echo "Calificación: F";
}

?>