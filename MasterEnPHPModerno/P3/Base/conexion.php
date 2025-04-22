<?php

    //Instancia PDO
    //Creación de bdd usuarios.db, queda en el mismo directorio

    $baseDatos = new PDO("sqlite:" . __DIR__ . "/usuarios.db");
    $baseDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Definición de la tabla

    /*$definicionTabla = "CREATE TABLE IF NOT EXISTS registros(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cedula TEXT NOT NULL,
        nombre TEXT NOT NULL,
        telefono TEXT NOT NULL,
        email TEXT NOT NULL,
        direccion TEXT NOT NULL,
        departamento TEXT NOT NULL,
        ciudad TEXT NOT NULL,
        fecha_creacion DATE
    );";

    $resultado = $baseDatos->exec($definicionTabla);
    echo "Tabla creada correctamente";*/

?>