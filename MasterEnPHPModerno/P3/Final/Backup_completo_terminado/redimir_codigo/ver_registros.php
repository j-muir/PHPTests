<?php 
     //Incluir la conexion
     include_once __DIR__ . "/conexion_sqlite.php";

     //Mostrar registros
     $query = "SELECT * FROM registros";
     $stmt = $baseDatos->query($query);

     $registros = $stmt->fetchAll(PDO::FETCH_OBJ);

     //Mostrarlos en pantalla
     var_dump($registros);