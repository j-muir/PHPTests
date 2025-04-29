<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsprestations.php');
if(isAjax()) {
    if (isset($_POST['data']) && isset($_POST['id'])) {
        $array = array();
        parse_str($_POST['data'], $array);

        $modPrestation = modPrestation($connexion, $array, $_POST['id']);

        echo $modPrestation;
    }
}