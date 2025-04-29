<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsclients.php');
if(isAjax()) {
    if (isset($_POST['data'])) {
        $array = array();
        parse_str($_POST['data'], $array);
        $ajoutClient = insertClient($connexion, $array);

        echo json_encode($ajoutClient);
    }
}