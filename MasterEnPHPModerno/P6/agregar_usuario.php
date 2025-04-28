<?php include "includes/header.php" ?>

<?php

  if(isset($_POST["crearEmpleado"])){

    $cedula = $_POST["cedula"];
    $email = $_POST["email"];
    $nombre = $_POST["nombre"];
    $esAdmin = $_POST["es_admin"];

    $query = "SELECT * FROM empleado WHERE cedula = :cedula";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":cedula", $cedula);
    $resultado = $stmt->execute();

    $registroCedula = $stmt->fetch(PDO::FETCH_ASSOC);

    if($registroCedula){
        $error = "Error, el número de cédula ya se encuenta registrado.";
    }else{
        $query = "INSERT INTO empleado (cedula, email, nombre, es_admin) VALUES (:cedula, :email, :nombre, :es_admin)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":es_admin", $esAdmin, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if($resultado){
            $mensaje = "Empleado creado con éxito.";
        }else{
            $error = "Error, no se pudo crear el empleado.";
            };
        };
    };

?>


        <div class="row">
            <div class="col-sm-12">
                <?php if(isset($mensaje)) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?php echo $mensaje; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>    
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if(isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?php echo $error; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>    
        </div>
              <div class="card-header">               
                <div class="row">
                  <div class="col-md-9">
                    <h3 class="card-title">Lista de todos los registros usuarios</h3>
                  </div>
                
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="cedula"># de Cédula:</label>
                        <input type="number" class="form-control" name="cedula" placeholder="Ingresa el # de cédula">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="name@example.com">
                    </div>                 
                    <div class="form-group">
                        <label for="esAdmin">Es Administrador</label>
                        <select class="form-control" name="es_admin">
                        <option value="">--Selecciona un valor--</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>                        
                        </select>
                    </div>
                    <button type="submit" name="crearEmpleado" class="btn btn-primary w-100"><i class="fas fa-user"></i> Crear Nuevo Empleado</button>
                    </form>
              </div>
              <!-- /.card-body -->
<?php include "includes/footer.php" ?>
            