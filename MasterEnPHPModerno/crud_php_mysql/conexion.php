<?php 

//Connectar a Mysql

$con = mysqli_connect("localhost:3306", "dbadmin", "3tI*a5s46", "admin_");

//probar conexión
if(mysqli_connect_errno()){
    echo "Fallo al conectarse a Mysql." . mysqli_connect_error();
}else {
    echo "Connectado correctamente.";
}

?>