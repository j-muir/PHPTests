<?php 

if (isset($_POST['enviar'])) {
    $usuario = htmlentities($_POST['usuario']);
    
    setcookie('usuario', $usuario, time()+3600);

    header("Location: pagina2.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies PHP</title>
</head>
<body>

    <form method="POST">

    <input type="text" name="usuario" placeholder="Ingresa el Usuario">
    <input type="submit" name="enviar" value="Enviar">

    </form>

</body>
</html>