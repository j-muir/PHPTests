<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
if(isAjax()) {
    if (isset($_POST['id'])) {
        $arrayPrestation = getPrestationByIds($connexion, $_POST['id']);

        echo json_encode($arrayPrestation);
    }
}