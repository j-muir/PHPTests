<?php

session_start();

include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');

if(isAjax()) {
    if (isset($_POST['data'])) {
        $blocage = addBlocage($connexion, $_POST['data'], $_POST['table'], $_SESSION['user']['login']);
        echo json_encode(array('status' => $blocage));
    }
}

?>