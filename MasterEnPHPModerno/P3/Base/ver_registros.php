<?php

//Conexion
include_once __DIR__ . "/conexion.php";

//Mostrar registros
$query = "SELECT * FROM registros";
$stmt = $baseDatos->query($query);

$registros = $stmt->fetchAll(PDO::FETCH_OBJ);

var_dump($registros);

?>