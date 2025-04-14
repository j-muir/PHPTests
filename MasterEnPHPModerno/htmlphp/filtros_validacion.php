<?php

//Validar el envio por $_POST
if(filter_has_var(INPUT_POST, "info")){
    echo "Información enviada";
}else {
    echo "No se envió información";
}

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">

<input type ="text" name="info">

<button type="submit">Enviar</button>

</form>