<?php

$servidor = [
    "Host" => $_SERVER["SERVER_NAME"],
    "Encabezado" => $_SERVER["HTTP_HOST"],
    "Software" => $_SERVER["SERVER_SOFTWARE"],
    "Encabezado host" => $_SERVER["DOCUMENT_ROOT"],
    "Págin actual" => $_SERVER["PHP_SELF"],
    "Nombre Script" => $_SERVER["SCRIPT_NAME"],
    "Root" => $_SERVER["SCRIPT_FILENAME"]
];

print_r($servidor);

?>