<?php

    //Incluir la conexion
    include_once __DIR__ . "/conexion_sqlite.php";

    //Configurar la zona horaria
    date_default_timezone_set('America/Bogota');

    //Insertamos datos
    if(isset($_POST["btnRegistrarse"])){
        
        //Obtenemos los valores
        $cedula = $_POST["cedula"];
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $direccion = $_POST["direccion"];
        $departamento = $_POST["departamento"];
        $ciudad = $_POST["ciudad"];

        //Validar que los campos no estén vaciós
        if(empty($cedula) || empty($nombre) || empty($telefono) || empty($email) || empty($direccion) || empty($departamento) || empty($ciudad)){
            $error = "Error, algunos campos obligatorios están vacíos";
            header('Location: index.php?error=' . urlencode($error));
        }else{
            //Validar si ya existe cedula
            $query = "SELECT * FROM registros WHERE cedula = :cedula";
            $stmt = $baseDatos->prepare($query);
            $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            $resultado = $stmt->execute();

            $registroCedula = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($registroCedula) {
                $error = "Error, el número de cédula ya se encuentra registrado";
                header('Location: index.php?error=' . urlencode($error));
            }else{
                //Si entra por aquí, es porque la cédula no existe y se puede registrar
                $query = "INSERT INTO registros(cedula, nombre, telefono, email, direccion, departamento, ciudad)VALUES(:cedula, :nombre, :telefono, :email, :direccion, :departamento, :ciudad)";

                $stmt = $baseDatos->prepare($query);

                //Debemos pasar al bindParam las variables, no podemos pasar el datos directamente
                $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
                $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
                $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
                $stmt->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);

                $resultado = $stmt->execute();

                if($resultado == true){
                    //Validar creación y obtener el últim ID que sería el código
                    $codigoId = $baseDatos->lastInsertId();
                    $mensaje = "Registro creado correctamente";
                    header('Location: index.php?mensaje=' . urlencode($mensaje) . '&codigo=' .urlencode($codigoId));
                    exit();
                }else{
                    //Se genera un error y se envía al index
                    $error = "Error, no se pudo crear el registro";
                    header('Location: index.php?error=' . urlencode($error));
                    exit();
                }

            }
        }
    }
