<?php
   
// Configuración de conexión
$host = 'localhost';
$port = '3306';
$dbname = 'admin_';
$username = 'dbadmin';
$password = '3tI*a5s46';

// DSN (Data Source Name)
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    // Crear una instancia PDO
    $pdo = new PDO($dsn, $username, $password);

    // Configurar el modo de error a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conectado correctamente.";
} catch (PDOException $e) {
    echo "Fallo al conectarse a MySQL: " . $e->getMessage();
}
?>
