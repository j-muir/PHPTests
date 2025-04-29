<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionshistoriques.php');
include('../../includes/fonctions/fonctionsencaissements.php');
include('../../includes/fonctions/fonctionscommandes.php');
if(isAjax()) {
    if (isset($_POST['id'])) {
        $getCommande = getCommande($connexion, $_POST['id']);
        echo json_encode($getCommande);
    }
}