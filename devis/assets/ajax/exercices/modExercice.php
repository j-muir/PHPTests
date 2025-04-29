<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsexercices.php');
if(isAjax()) {
    if (isset($_POST)) {

        $modExercice = modExercice($connexion, $_POST);

        echo $modExercice;
    }
}