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
       