<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsfiches.php');

if(isAjax()) {
    $getFiche = getFichesDatatable($connexion);
    echo json_encode($getFiche);
}

?>