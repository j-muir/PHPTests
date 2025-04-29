<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');

if(isAjax()) {
    if (isset($_POST['id']) && isset($_POST['type'])) {
        $blocage = getBlocage($connexion, $_POST['id'], $_POST['type'], $_SESSION['user']['login']);

        echo json_encode($blocage);
    }
}

?>