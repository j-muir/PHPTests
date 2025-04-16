<?php

    //Valores iniciales
    $valor = '';
    $desde = '';
    $hasta = '';

    //Convertir a la medida estandar (metros)
    function convertir_a_metros($valor, $unidad_desde){
        switch ($unidad_desde) {
            case 'Milimetro':
                return $valor / 1000;
                break;
            case 'Centimetro':
                return $valor / 100;
                break;
            case 'Decimetro':
                return $valor / 10;
                break;
            case 'Metro':
                return $valor * 1;
                break;
            case 'Decametro':
                return $valor * 10;
                break;
            case 'Hectometro':
                return $valor * 100;
                break;
            case 'Kilometro':
                return $valor * 1000;
                break;
            
            default:
                return 'Unidad de medida no soportada.';
                break;
        }
    }

        //Convertir desde metros
        function convertir_desde_metros($valor, $unidad_hasta){
            switch ($unidad_hasta) {
                case 'Milimetro':
                    return $valor * 1000;
                    break;
                case 'Centimetro':
                    return $valor * 100;
                    break;
                case 'Decimetro':
                    return $valor * 10;
                    break;
                case 'Metro':
                    return $valor * 1;
                    break;
                case 'Decametro':
                    return $valor / 10;
                    break;
                case 'Hectometro':
                    return $valor / 100;
                    break;
                case 'Kilometro':
                    return $valor / 1000;
                    break;
                
                default:
                    return 'Unidad de medida no soportada.';
                    break;
            }
        }

    if(isset($_POST['convertir'])){

        //Obtener valores
        $valor = $_POST['valor'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];

        $calculoDesde = convertir_a_metros($valor, $desde);

        $calculoHasta = convertir_desde_metros($calculoDesde, $hasta);

        $resultado = number_format($calculoHasta, 2);
    };

?>

<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Conversor de Longitud</title>
  </head>
  <body>
    <h1 class="text-center">Conversor de Longitud</h1>

    <div class="container">
        <form method="POST">
            <div class="row mt-4">

                <div class="col-sm-4">
                    <div>
                        <label for="valor" class="form-label">Valor :</label>
                        <input type="number" name="valor" class="form-control" value="<?php if(isset($_POST['valor'])) { echo $_POST['valor']; }; ?>">
                    </div>                
                </div>
            
                    <div class="col-sm-4">
                        <label for="desde" name="desde" class="form-label">Desde :</label>
                        <select class="form-select" name="desde">    
                            <option value="">--Selecciona un valor--</option>                       
                            <option value="Milimetro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Milimetro') echo 'selected'; ?>>Milímetro</option>
                            <option value="Centimetro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Centimetro') echo 'selected'; ?>>Centímetro</option>
                            <option value="Decimetro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Decimetro') echo 'selected'; ?>>Decímetro</option>
                            <option value="Metro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Metro') echo 'selected'; ?>>Metro</option>
                            <option value="Decametro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Decametro') echo 'selected'; ?>>Decámetro</option>
                            <option value="Hectometro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Hectometro') echo 'selected'; ?>>Hectómetro</option>
                            <option value="Kilometro" <?php if(isset($_POST['desde']) && $_POST['desde'] == 'Kilometro') echo 'selected'; ?>>Kilómetro</option>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <label for="hasta" name="hasta" class="form-label">Hasta :</label>
                        <select class="form-select" name="hasta">    
                            <option value="">--Selecciona un valor--</option>                       
                            <option value="Milimetro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Milimetro') echo 'selected'; ?>>Milímetro</option>
                            <option value="Centimetro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Centimetro') echo 'selected'; ?>>Centímetro</option>
                            <option value="Decimetro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Decimetro') echo 'selected'; ?>>Decímetro</option>
                            <option value="Metro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Metro') echo 'selected'; ?>>Metro</option>
                            <option value="Decametro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Decametro') echo 'selected'; ?>>Decámetro</option>
                            <option value="Hectometro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Hectometro') echo 'selected'; ?>>Hectómetro</option>
                            <option value="Kilometro" <?php if(isset($_POST['hasta']) && $_POST['hasta'] == 'Kilometro') echo 'selected'; ?>>Kilómetro</option>
                        </select>
                    </div>
            </div>  

        <div class="row mt-4">
            <div class="col-sm-6">
                <button type="submit" name="convertir" class="btn btn-primary w-100 py-4">CONVERTIR</button>
            </div>
                
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="resultado" class="form-label">RESULTADO:</label>
                    <input type="text" value="<?php if(isset($resultado)) echo $resultado; ?>" name="resultado" class="form-control">                
                </div>
            </div>
        </div> 

         </form>     
    </div>
    
  </body>
</html>