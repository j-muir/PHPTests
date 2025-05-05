<?php 

//Encabezados (HEADERS)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Basemysql.php';
    include_once '../../models/Categoria.php';

//Instanciamos la base de datos y conexión
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

//Instanciamos el objeto categoría
    $categoria = new Categoria($db);

    //Get id
    $categoria->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get categoria
    $categoria->leer_individual();

    $categoria_arr = array(
        'id' => $categoria->id,
        'nombre' => $categoria->nombre
    );

    //Crear json
        print_r(json_encode($categoria_arr));

    ?>