<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsfiches.php');

if(isAjax()) {
    if($_POST['elementMod'] === 'date_visite'){
        $_POST['value'] = str_replace('T', ' ', $_POST['value']);
    }

    if($_POST['elementMod'] === 'numero_telephone'){
        $_POST['value'] = chunk_split(str_replace(array(' ', '/', ',', '.', '-'), '', $_POST['value']), 2, ' ');
    }

    $getFiche = modFiche($connexion, $_POST['elementMod'], $_POST['value'], $_POST['idFiche']);
    echo json_encode(array('status' => true));
}

?>