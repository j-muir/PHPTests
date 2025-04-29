<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsprestations.php');
if(isAjax()) {
    if (isset($_POST['id'])) {
        $getPrestation = getPrestation($connexion, $_POST['id']);
        echo json_encode($getPrestation);
    }
}