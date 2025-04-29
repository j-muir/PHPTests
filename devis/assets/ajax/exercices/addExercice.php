<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsexercices.php');
if(isAjax()) {
    if (isset($_POST)) {

        $ajouteExercice = insertExercice($connexion, $_POST);

        echo $ajouteExercice;
    }
}