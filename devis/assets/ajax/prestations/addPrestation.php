<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsprestations.php');
if(isAjax()) {
    if (isset($_POST['data'])) {
        $array = array();
        parse_str($_POST['data'], $array);

        $ajoutPrestation = insertPrestation($connexion, $array);
        echo $ajoutPrestation;
    }
}
