<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionscommandes.php');
include('../../includes/fonctions/fonctionsclients.php');
if(isAjax()) {
    if (isset($_POST['id'])) {

        $getClient = getClient($connexion, $_POST['id']);

        echo json_encode($getClient);
    }
}