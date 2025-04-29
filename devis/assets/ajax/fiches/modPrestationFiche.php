<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsfiches.php');

if(isAjax()) {
    $getFiche = modFiche($connexion, 'prestations_complementaire', json_encode($_POST['value']), $_POST['idFiche']);
    echo json_encode(array('status' => true));
}

?>