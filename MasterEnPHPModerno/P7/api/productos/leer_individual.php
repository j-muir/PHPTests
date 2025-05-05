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
    if ($producto->leer_individual()) {
        $producto_arr = array(
            'id' => $producto->id,
            'titulo' => $producto->titulo,
            'texto' => $producto->texto,
            'categoria_id' => $producto->categoria_id,
            'nombre_categoria' => $producto->nombre_categoria,
            'fecha_creacion' => $producto->fecha_creacion
        );

        echo json_encode($producto_arr);
    } else {
        echo json_encode(['message' => 'Producto no encontrado']);
    }
    ?>