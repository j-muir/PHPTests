<?php 

//Encabezados (HEADERS)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Basemysql.php';
    include_once '../../models/Producto.php';

//Instanciamos la base de datos y conexión
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

//Instanciamos el objeto categoría
    $producto = new Producto($db);

    //Get id
    $producto->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get producto
    $producto->leer_individual();

    $producto_arr = array(
        'id' => $producto->id,
        'titulo' => $titulo,
        'texto' => $texto,
        'categoria_id' => $categoria_id,
        'nombre_categoria' => $nombre_categoria 
    );

    //Crear json
        print_r(json_encode($producto_arr));

    ?>