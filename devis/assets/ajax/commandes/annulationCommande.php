<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionshistoriques.php');
include('../../includes/fonctions/fonctionsplanning.php');
include('../../includes/fonctions/fonctionsequipes.php');
include('../../includes/fonctions/fonctionscommandes.php');
if(isAjax()) {
    if (isset($_POST['id']) && isset($_POST['commentaire'])) {
        $annulationCommande = annulerCommande($connexion, $_POST['id'], $_POST['commentaire']);
        echo json_encode($annulationCommande);
    }
}