<?php
    //Obtener los datos GET
    var_dump($_POST);

    //Obtener el nombre
    $nombreEnviado = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    echo $nombreEnviado;

     //Obtener contraseña
    /*  $password = $_GET['contrasenia'];
     echo $password; */


     //Obtener valor de un select
     echo "<br />";
     echo $tipoDocumento = $_POST['tipoDocumento'];

      //Obtener desde un textarea
      echo "<br />";
      echo $observacion = $_POST['observacion'];

      //Obtener checkboxes
      echo "<br />";
      echo $cocina = isset($_POST['cocina']) ? "Cocina: " . $_POST['cocina'] : '';
      echo "<br />";
      echo $cine = isset($_POST['cine']) ? "Cine: " . $_POST['cine'] : '';
      echo "<br />";
      echo $lectura = isset($_POST['lectura']) ? "Lectura: " .$_POST['lectura'] : '';

      //Obtener desde un select multiple
      echo "<br />";
      $vehiculo = $_POST['vehiculo'];
      print_r($vehiculo);

      //Obtener desde un radio button
      echo "<br />";
      $genero = $_POST['genero'];
      echo $genero;    
      
      
      //Para el input file, no olvidar en el html: enctype="multipart/form-data" y el form debe ser tipo POST
      var_dump($_FILES);


 

?>