<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');

if(isAjax()) {
    $_SESSION['anneeExercice'] = $_POST['data'];
}