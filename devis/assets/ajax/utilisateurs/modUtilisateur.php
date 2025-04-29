<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsutilisateurs.php');
if(isAjax()) {
    if (isset($_POST)) {

        $modUtilisateur = modUtilisateur($connexion, $_POST);
        echo $modUtilisateur;
    }
}