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

    $resultado = $categoria->leer();

//Contar filas
    $num = $resultado->rowCount();

//Validamos si existe una categoria
    if($num > 0){
        //array de categorias
        $categoria_arr = array();
        $categoria_arr['data'] = array();

        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $categoria_item = array(
                'id' => $id,
                'nombre' => $nombre
            );

            //Enviar datos
            array_push($categoria_arr['data'], $categoria_item);
        };
     //Enviar en formato json
        echo json_encode($categoria_arr);
    }else {
        echo json_encode(array('message' => 'No hay categorias.'));
    }
?>