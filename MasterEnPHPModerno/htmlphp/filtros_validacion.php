<?php

/*//Validar el envio por $_POST
if(filter_has_var(INPUT_POST, "info")){
    echo "Información enviada";
}else {
    echo "No se envió información";
}*/

/*//Validar Email
if(filter_has_var(INPUT_POST, "info")){
    if (filter_input(INPUT_POST, "info", FILTER_VALIDATE_EMAIL))
    echo "Email Válido";
}else {
    echo "No es un email válido";
}*/

/*//Validar Email
if(filter_has_var(INPUT_POST, "info")){
    $email = $_POST["info"];
    
    //eliminar caracteres invalidos
    $emailLimpio = filter_var($email, FILTER_SANITIZE_EMAIL);

    echo "$emailLimpio";
}else {
    echo "No es un email válido";
};*/

$numero = 56;

if(filter_var($numero, FILTER_VALIDATE_INT)){
    echo "$numero es un número entero";
}else {
    echo "$numero NO es un número entero";
};

//Sanear número entero
$numero2 = '5ddd6221jdk$6#';
var_dump(filter_var($numero2, FILTER_SANITIZE_NUMBER_INT));

//Ejercicio prevenir ejecución de scripts
$nombre = '<script>alert("Hola")</script>';
//echo $nombre;
echo filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//Filter input array
$filtros = array(
    "info" => FILTER_VALIDATE_EMAIL,
    "info2" => array(
        "filter" => FILTER_VALIDATE_INT,
        "options" => array (
            "min_range" => 1,
            "max_range" => 50
        )
    )
);
print_r(filter_input_array(INPUT_POST, $filtros));

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">

<input type ="text" name="info">
<input type ="text" name="info2">

<button type="submit">Enviar</button>

</form>