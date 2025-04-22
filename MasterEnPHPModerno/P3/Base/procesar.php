<?php

//Conexion
include_once __DIR__ . "/conexion.php";

//Zona horaria
date_default_timezone_set('Europe/Paris');

//Inserción datos

if(isset($_POST["btnRegistrarse"])){
    
    //Obtener valores
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];

    //Validar campos
    if(empty($cedula || $nombre || $telefono || $email || $direccion || $departamento || $ciudad)){
        $error = "Error, algunos campos obligatorios están vacíos.";
        header('Location: index.php?error=' . $urlencode($error));
    }else{
        //Validar si ya existe la cédula
        $query = "SELECT * FROM registros WHERE cedula = :cedula";
        $stmt = $baseDatos->prepare($query);
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $resultado = $stmt->execute();

        $registroCedula = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registroCedula) {
            $error = "Error, el número de cédula se encuentra ya registrado.";
            header('Location: index.php?error=' . $urlencode($error));
        }else{
            //Si la cédula no existe
            $query = "INSERT INTO registros(cedula, nombre, telefono, email, direccion, departamento, ciudad) VALUES (:cedula, :nombre, :telefono, :email, :direccion, :departamento, :ciudad)";
           
            $stmt = $baseDatos->prepare($query);
            $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
            $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
            $stmt->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            if($resultado){
                //Validar creación y obtener el último ID (sería el código)
                $codigoID = $baseDatos->lastInsertId();
                $mensaje = "Registro creado correctamente";
                header('Location: index.php?mensaje=' . $urlencode($mensaje) . '&codigo=' . urlencode($codigoID));
                exit();
            } else {
                $error = "Error, no se pudo crear el registro.";
                header('Location: index.php?error=' . $urlencode($error));
                exit();
            };
        };
    }
};

?>