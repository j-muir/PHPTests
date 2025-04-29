<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsdemandes.php');
if (isAjax()) {
    if (isset($_POST)) {
        $get = getDemande($connexion, $_POST['id']);
        echo json_encode($get);
    }
}