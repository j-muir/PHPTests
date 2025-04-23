<?php include("includes/header.php") ?>
<div class="row">
        <div class="col-sm-6">
            <h3>Crear una Nueva Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">               
            </div>          

            <button type="submit" name="crearCategoria" class="btn btn-primary w-100">Crear Nueva Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       