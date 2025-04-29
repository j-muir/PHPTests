<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsdemandes.php');
if (isAjax()) {
    if (isset($_POST)) {
        $mod = modDemande($connexion, $_POST);
        echo json_encode($mod);
    }
}