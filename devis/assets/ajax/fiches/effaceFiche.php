<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsfiches.php');

if(isAjax()) {
    $dateToday = date('Y-m-d');
    $addFiche = archiveFiche($connexion, $dateToday, $_SESSION['user']['prenom'].' '.$_SESSION['user']['nom'], $_POST['idFiche']);
    echo json_encode(array('status' => true));
}

?>