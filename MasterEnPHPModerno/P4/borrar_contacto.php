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
    
//Edicion de Datos
    if(isset($_POST["borrarContacto"])){

            $query = "DELETE FROM contactos WHERE id = :id";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":id", $idContacto, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            if($resultado){
                $mensaje = "Contacto borrado con éxito.";
                header('Location: contactos.php?mensaje=' . $mensaje);
                exit();
            }else{
                $error = "Error, no se pudo borrar el contacto.";
                header('Location: borrar_contacto.php?error=' . $error);
                exit();
            };
        };
?>

<div class="row">
        <div class="col-sm-6">
            <h3>Borrar Contacto</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="editar_contacto.php?id=<?php echo $idContacto; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php if($contacto){ echo $contacto->nombre; }; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingresa los apellidos" value="<?php if($contacto){ echo $contacto->apellidos; }; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono" value="<?php if($contacto){ echo $contacto->telefono; }; ?>" readonly>               
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php if($contacto){ echo $contacto->email; }; ?>" readonly>               
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
            <button type="submit" name="borrarContacto" class="btn btn-danger w-100"><i class="bi bi-person-bounding-box"></i> Editar Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       