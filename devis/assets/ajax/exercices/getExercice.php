<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsexercices.php');
if(isAjax()) {
    if (isset($_POST['id'])) {

        $getExercice = getExercice($connexion, $_POST['id']);

        echo json_encode($getExercice);
    }
}