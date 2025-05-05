<?php

//Encabezados (HEADERS)
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Basemysql.php';
    include_once '../../models/Categoria.php';

//Instanciamos la base de datos y conexión
    $baseDatos = new Basemysql();
    $db = $baseDatos->connect();

//Instanciamos el objeto categoría
    $categoria = new Categoria($db);

    $data = json_decode(file_get_contents("php://input"));

    $categoria->id = $data->id;

//Crear categorias
    if($categoria->borrar()){
        echo json_encode(
        array('message' => 'Categoría borrada.')
    );
    }else {
        echo json_encode(
            array('message' => 'Categoria no borrada.')
        );
    }

?>