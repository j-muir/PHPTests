<?php

//Encabezados (HEADERS)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Basemysql.php';
    include_once '../../models/Producto.php';

//Instanciamos la base de datos y conexión
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

//Instanciamos el producto
    $producto = new Producto($db);

    $data = json_decode(file_get_contents("php://input"));

    $producto->id = $data->id;

//Borrar Producto
    if($producto->borrar()){
        echo json_encode(
        array('message' => 'Producto borrado.')
    );
    }else {
        echo json_encode(
            array('message' => 'Producto no borrado.')
        );
    }

?>