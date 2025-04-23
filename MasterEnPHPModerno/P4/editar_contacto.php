<?php include("includes/header.php") ?>

<?php

//Validar id del contacto por url
    if(isset($_GET["id"])){
        $idContacto = $_GET["id"];
    };

    $query = "SELECT * FROM contactos WHERE id=:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $idContacto, PDO::PARAM_INT);
    $stmt->execute();
    $contacto = $stmt->fetch(PDO::FETCH_OBJ);
    
//Validar id de la categoria por url
    if(isset($_GET["idCategoria"])){
        $idCategoria = $_GET["idCategoria"];
    };

    $query2 = "SELECT * FROM categorias";
    $stmt = $pdo->prepare($query2);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

//Edicion de Datos
    if(isset($_POST["editarContacto"])){
        //Obtener valores
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $categoria = $_POST["categoria"];

        //Validar si está vacío
        if(empty($nombre) || empty($apellidos) || empty($telefono) || empty($email) || empty($categoria)){
            $error = "Error, algunos campos obligatorios están vacíos.";
            header('Location: editar_contacto.php?error=' . urlencode($error));
            exit();
        }else{
            //Insersión de datos en bdd
            $query = "UPDATE contactos SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, email = :email, categoria = :categoria WHERE id = :id";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":id", $idContacto, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":categoria", $categoria, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            if($resultado){
                $mensaje = "Contacto editado con éxito.";
                header('Location: contactos.php?mensaje=' . $mensaje);
                exit();
            }else{
                $error = "Error, no se pudo editar el contacto.";
                header('Location: editar_contacto.php?error=' . $error);
                exit();
            };
        };
    }
?>

<div class="row">
        <div class="col-sm-6">
            <h3>Editar Contacto</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="editar_contacto.php?id=<?php echo $idContacto; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php if($contacto){ echo $contacto->nombre; }; ?>">               
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingresa los apellidos" value="<?php if($contacto){ echo $contacto->apellidos; }; ?>">               
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono" value="<?php if($contacto){ echo $contacto->telefono; }; ?>">               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php if($contacto){ echo $contacto->email; }; ?>">               
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Categoría:</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
                    <option value="">--Selecciona una Categoría--</option>
                    <?php foreach($categorias as $fila) : ?>
                        <option value="<?php echo $fila->id; ?>">
                            <?php echo isset($fila->nombre) ? htmlspecialchars($fila->nombre) : 'Categoría sin nombre'; ?>
                        </option>
                    <?php endforeach; ?>             
                </select>
            </div>
            <br />
            <button type="submit" name="editarContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Editar Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       