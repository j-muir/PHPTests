<?php

include('./assets/includes/connexion.php');
include('./assets/includes/fonctions/fonctionsgeneral.php');

session_start();
insertLog($connexion, '[DECONNEXION] Réussie', $_SESSION['user']['login']);
session_destroy();

header('Location: ./index.php');

?>