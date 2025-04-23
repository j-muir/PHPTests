<?php
   
    /*//Configurar datos de acceso a la Base de datos
    $host = "localhost";
    $dbname = "admin_Psg";
    $dbuser = "user_Psg";
    $userpass = "2n1fh8_Q9";
    
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$dbuser;password=$userpass";
    
    try{
     //Crear conexión a postgress
     $conn = new PDO($dsn);
    
     //Mostgrar mensaje si la conexión es correcta
     if($conn){
      echo "Conectado a la base $dbname correctamente!"; 
     echo "\n";
     }
    }catch (PDOException $e){
     //Si hay error en la conexión mostrarlo
     echo $e->getMessage();
    }*/

        //Connectar a Mysql

        $con = mysqli_connect("localhost:3306", "dbadmin", "3tI*a5s46", "admin_");

        //probar conexión
        if(mysqli_connect_errno()){
            echo "Fallo al conectarse a Mysql." . mysqli_connect_error();
        }/*else {
            echo "Connectado correctamente.";
        }*/

?>