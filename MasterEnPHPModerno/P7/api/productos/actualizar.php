<?php

//Encabezados (HEADERS)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Basemysql.php';
    include_once '../../models/Producto.php';

//Instanciamos la base de datos y conexión
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

//Instanciamos el objeto categoría
    $producto = new Producto($db);

    $data = json_decode(file_get_contents("php://input"));

    $producto->id = $data->id;
    $producto->titulo = $data->titulo;
    $producto->texto = $data->texto;
    $producto->categoria_id = $data->categoria_id;

//Crear categorias
    if($producto->actualizar()){
        echo json_encode(
        array('message' => 'producto actualizado.')
    );
    }else {
        echo json_encode(
            array('message' => 'producto no actualizado.')
        );
    }

?>