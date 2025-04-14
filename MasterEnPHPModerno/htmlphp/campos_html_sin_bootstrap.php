<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campos de formulario y PHP</title>
</head>
<body>

    <!--Ejemplo 1 sin bootstrap-->
    <form action="campos_html.php">
    <label for="fname">Nombre:</label>
    <input type="text" id="nombre" name="fname"><br><br>
    <label for="lname">Apellido:</label>
    <input type="text" id="apellido" name="lname"><br><br>
    <input type="submit" value="Enviar">
    </form>
    
</body>
</html>