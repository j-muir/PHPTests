<?php include("includes/header.php") ?>

<?php

    // Configurar Zona horara
    date_default_timezone_set('Europe/Paris');

    //Mostrar registros
    $query = "SELECT * FROM categorias";
    $stmt = $pdo->query($query);

    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

    /*var_dump($categorias);*/

    ?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Categorías</h3>
    </div> 
    <div class="col-sm-4 offset-2">
        <a href="crear_categoria.php" class="btn btn-success w-100"><i class="bi bi-plus-circle-fill"></i> Nueva Categoría</a>
    </div>    
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblCategorias" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de Creación</th>                       
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($categorias as $fila) : ?>
                    <tr>
                        <td><?php echo $fila->id; ?></td>
                        <td><?php echo $fila->nombre; ?></td>
                        <td><?php echo $fila->fecha_creacion; ?></td>
                        <td>
                            <a href="editar_categoria.php?id=<?php echo $fila->id; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Editar</a>                                                
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>       
            </table>
    </div>
</div>
<?php include("includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblCategorias').DataTable();
    });
</script>