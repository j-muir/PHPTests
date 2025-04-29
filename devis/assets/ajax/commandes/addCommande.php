<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionshistoriques.php');
include('../../includes/fonctions/fonctionscommandes.php');
if(isAjax()) {
    if (isset($_POST)) {
        $ajoutCommande = insertCommande($connexion, $_POST);
        echo $ajoutCommande;
    }
}