<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionscommandes.php');
if(isAjax()) {
    if (isset($_GET)) {
        $getAnomalie = getAnomalieCommande($connexion);
        echo json_encode($getAnomalie);
    }
}