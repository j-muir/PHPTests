<?php
    //PHP DATA OBJECTS(Extensión PHP)
    //Una manera mejor y más segura de acceder a una base de datos
    //Permite trabajar con muchos motores de base de datos como Mysql, SQlite, Postgress, SqlServer.
    //Contiene una capa de acceso a datos
    //Es orientada a objetos

    //Ventajas
    //Multiples bases de datos
    //Seguridad a traves de sentencias preparadas (Prepared Statements)
    //Usabilidad y Reusabilidad
    //Manejador de errores avanzada

    //Conexión Mysql
    $host = "localhost";
    $usuario = "root";
    $password = "";
    $baseDatos = "crud_php_mysql";

    //Configurar dsn
    $dsn = 'mysql:host=' . $host . ';dbname=' . $baseDatos;

    //Crear instancia PDO
    $pdo = new PDO($dsn, $usuario, $password);

    //Agregar el setattribute de manejara global
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    //Primer query con PDO
    $query = $pdo->query('SELECT * FROM usuarios');

    //Ejemplo 1
    /* while($fila = $query->fetch()){
        echo $fila['nombre'];
        echo "<br />";
    } */

    //Ejemplo 2, especificanco el modo
    /* while($fila = $query->fetch()){
        echo $fila->nombre;
        echo "<br />";
    } */

    //Ejemplo 3
    $nombre = "Martha";

    //Manera insegura
    /* $query2 = "SELECT * FROM usuarios WHERE nombre = '$nombre' "; */

    //Ejemplo 3
    $nombre2 = "Alejandro";

    /* //Parametros posicionales anónimos
    $query3 = "SELECT * FROM usuarios WHERE nombre = ? ";
    $stmt = $pdo->prepare($query3);

    //Execute
    $stmt->execute([$nombre2]);

    $usuarios = $stmt->fetch();

    var_dump($usuarios);
 */

 //Parametros posicionales anónimos
 $query3 = "SELECT * FROM usuarios WHERE nombre = :nombre ";
 $stmt = $pdo->prepare($query3);

 //Execute
 $stmt->execute([':nombre' => $nombre2]);

 $usuarios2 = $stmt->fetchAll();

/*  var_dump($usuarios2); */

/* foreach ($usuarios2 as $usuario) {
   echo $usuario->nombre;
}
 */

//Traer un único registro
/* $id = 3;
$query5 = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($query5);

//Opción fetch un solo registro
$stmt->execute([':id' => $id]);
$usuario4 = $stmt->fetch();
echo $usuario4->telefono; */

//Contar filas con ROW COUNT
/* $id = "4";
$query6 = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($query6);
$stmt->execute([':id' => $id]);

//Accedemos al rowCount()
$totalUsuarios = $stmt->rowCount();
echo "<br />";
echo "Total usuarios: " . $totalUsuarios; */

//Insertar datos
/* $nombre = "Carlos";
$apellidos = "Marín";
$telefono = "4444444";
$email = "carlosm@gmail.com"; */


/* $query7 = "INSERT INTO usuarios(nombre, apellidos, telefono, email)values(:nombre, :apellidos, :telefono, :email)";

$stmt = $pdo->prepare($query7);

$stmt->execute(['nombre' => $nombre, 'apellidos' => $apellidos, 'telefono' => $telefono, 'email' => $email]);
echo "<br />";
echo "Usuario creado correctamente"; */

/* $query8 = "INSERT INTO usuarios(nombre, apellidos, telefono, email)values(:nombre, :apellidos, :telefono, :email)";

$stmt = $pdo->prepare($query8);

//Bind params o vinculación de parametros
$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
$stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

$stmt->execute();
echo "<br />";
echo "Usuario creado correctamente"; */

//Actualizar datos con PDO
/* $id = 10; 
$nombre = "Harold";
$apellidos = "Monsalve";
$telefono = "55555555";
$email = "haroldm@hotmail.com";

$query9 = "UPDATE usuarios set nombre=:nombre, apellidos=:apellidos, telefono=:telefono, email=:email WHERE id=:id";

$stmt = $pdo->prepare($query9);

$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
$stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();
echo "<br />";
echo "Usuario actualizado correctamente"; */

/* $id = 10; 
$nombre = "Gina";
$apellidos = "López";
$telefono = "666666666";
$email = "gina6@hotmail.com";

$query9 = "UPDATE usuarios set nombre=?, apellidos=?, telefono=?, email=? WHERE id=?";

$stmt = $pdo->prepare($query9);

$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
$stmt->bindParam(2, $apellidos, PDO::PARAM_STR);
$stmt->bindParam(3, $telefono, PDO::PARAM_STR);
$stmt->bindParam(4, $email, PDO::PARAM_STR);
$stmt->bindParam(5, $id, PDO::PARAM_INT);

$stmt->execute();
echo "<br />";
echo "Usuario actualizado correctamente"; */

/* //Borrar datos
$id = 4;

$query10 = "DELETE FROM usuarios WHERE id=:id";

$stmt = $pdo->prepare($query10);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();
echo "<br />";
echo "Usuario borrado correctamente"; */

//Borrar datos
$textoBuscar = "%gi%";

$query11 = "SELECT * FROM usuarios WHERE nombre like :nombre";

$stmt = $pdo->prepare($query11);

$stmt->bindParam(':nombre', $textoBuscar, PDO::PARAM_STR);

$stmt->execute();
$usuarios = $stmt->fetchAll();
var_dump($usuarios);

