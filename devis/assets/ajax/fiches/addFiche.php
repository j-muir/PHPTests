<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsfiches.php');

if(isAjax()) {
    $dateToday = date('Y-m-d');
    $dateEnvoi = addJoursOuvres($dateToday, 3);
    $addFiche = addFiche($connexion, $dateToday, $dateEnvoi, $_SESSION['user']['prenom'].' '.$_SESSION['user']['nom']);
    deleteUserBlocage($connexion, $_SESSION['user']['login']);
    addBlocage($connexion, $addFiche['idFicheAdded'], 'fiche', $_SESSION['user']['login']);
    echo json_encode(array('status' => true, 'infoFicheAdded' => 'Fiche réalisée par '.$_SESSION['user']['prenom'].' '.$_SESSION['user']['nom'].' le '.date('d/m/Y'), 'idFicheAdded' => $addFiche['idFicheAdded'], 'numeroFicheAdded' => $addFiche['numeroFicheAdded'], 'dateDemandeFicheAdded' => $dateToday, 'datePourFicheAdded' => $dateEnvoi));
}

?>