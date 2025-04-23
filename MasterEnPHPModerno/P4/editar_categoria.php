<?php include("includes/header.php") ?>

<?php

    //Validar id de la categoria por url
    if(isset($_GET["id"])){
        $idCategoria = $_GET["id"];
    };

    //Obtener la el nombre de la categoría
    $query = "SELECT * FROM categorias WHERE id=:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_OBJ);

    //Editar datos
    if(isset($_POST["editarCategoria"])){
        //Obtener valores
        $nombre = $_POST["nombre"];

        //Validar si está vacío
        if(empty($nombre)){
            $error = "Error, algunos campos obligatorios están vacíos.";
            header('Location: editar_categoria.php?error=' . $error);
        }else{
            //Insersión de datos en bdd
            $fechaActual = date("Y-m-d");
            $query = "UPDATE categorias SET nombre = :nombre WHERE id = :id";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":id", $idCategoria, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            if($resultado){
                $mensaje = "Categoría editada con éxito.";
                header('Location: categorias.php?mensaje=' . $mensaje);
                exit();
            }else{
                $error = "Error, no se pudo editar la categoría.";
                header('Location: categorias.php?error=' . $error);
                exit();
            };
        };
    }

?>

    <div class="row">
        <div class="col-sm-6">
            <h3>Editar Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php if($categoria){ echo $categoria->nombre; }; ?>">               
            </div>          

            <button type="submit" name="editarCategoria" class="btn btn-primary w-100">Editar Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       