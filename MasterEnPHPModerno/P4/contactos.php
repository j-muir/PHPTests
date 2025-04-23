<?php include("includes/header.php") ?>

<?php

    // Configurar Zona horara
    date_default_timezone_set('Europe/Paris');

    //Mostrar registros
    $query = "SELECT cat.nombre AS nombrecategoria, con.id AS id, con.nombre AS nombre, con.apellidos AS apellidos, con.telefono AS telefono, con.email AS email, con.categoria AS categoria_id FROM categorias cat INNER JOIN contactos con ON con.categoria = cat.id";
    $stmt = $pdo->query($query);

    $contactos = $stmt->fetchAll(PDO::FETCH_OBJ);

    /*var_dump($categorias);*/

    ?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Contactos</h3>
    </div> 
    <div class="col-sm-4 offset-2">
        <a href="crear_contacto.php" class="btn btn-success w-100"><i class="bi bi-plus-circle-fill"></i> Nuevo Contacto</a>
    </div>    
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblContactos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th> 
                        <th>Categoría</th>                    
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($contactos as $fila) : ?>
                    <tr>
                        <td><?php echo $fila->id; ?></td>
                        <td><?php echo $fila->nombre; ?></td>
                        <td><?php echo $fila->apellidos; ?></td>
                        <td><?php echo $fila->telefono; ?></td>
                        <td><?php echo $fila->email; ?></td>
                        <td><?php echo $fila->nombrecategoria; ?></td>
                        <td>
                            <a href="editar_contacto.php?id=<?php echo $fila->id; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i> Editar</a>
                            <a href="borrar_contacto.php?id=<?php echo $fila->id; ?>" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Borrar</a>                                                    
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
        $('#tblContactos').DataTable();
    });
</script>