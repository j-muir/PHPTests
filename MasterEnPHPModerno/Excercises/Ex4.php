<?php

// Ejercicio: Calcular el día de la semana
$numeroDia = 3; // 1 representa Lunes, 2 Martes, ... 7 Domingo
$nombreDia = "";

// Utiliza un switch para asignar el nombre del día correspondiente al número
switch ($numeroDia) {
    case '1':
        $nombreDia = "Lunes";
        break;
    case '2':
        $nombreDia = "Martes";
        break;    
    case '3':
        $nombreDia = "Miércoles";
        break;
    case '4':
        $nombreDia = "Jueves";
        break;
    case '5':
        $nombreDia = "Viernes";
        break;
    case '6':
        $nombreDia = "Sábado";
        break;
    case '7':
        $nombreDia = "Domingo";
        break;
    default:
        // code...
        break;
}

// Tu código aquí

echo $nombreDia;

// Imprime el nombre del día de la semana

?>

