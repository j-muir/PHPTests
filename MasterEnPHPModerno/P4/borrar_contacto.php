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

// Obtener el nombre de la categoría actual del contacto
    $categoriaNombre = '';

    if ($contacto) {
        $query = "SELECT nombre FROM categorias WHERE id = :idCategoria";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idCategoria', $contacto->categoria, PDO::PARAM_INT);
        $stmt->execute();
        $categoria = $stmt->fetch(PDO::FETCH_OBJ);

        if ($categoria) {
            $categoriaNombre = $categoria->nombre;
        }
    }
    
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
    <div class="col-sm-12">
        <?php if(isset($_GET['error'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['error']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>    
</div>
<div class="row">
        <div class="col-sm-6">
            <h3>Borrar Contacto</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="borrar_contacto.php?id=<?php echo $idContacto; ?>">
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
                <label class="form-label">Categoría:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($categoriaNombre); ?>" readonly>
            </div>
            <br />
            <button type="submit" name="borrarContacto" class="btn btn-danger w-100"><i class="bi bi-person-bounding-box"></i> Borrar Contacto</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       