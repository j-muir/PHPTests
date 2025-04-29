<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');

if(isAjax()) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $cle = pg_escape_string($_POST['cle']);
        $email = pg_escape_string($_POST['email']);
        $password = pg_escape_string($_POST['password']);

        if(loginExist($connexion, $email)){
            $requete = "UPDATE utilisateurs SET password_utilisateur = SHA1('" . $password . "') WHERE email_utilisateur = '" . $email . "'";
            $res = $connexion->query($requete);

            $requete = "DELETE FROM reinitialisation_motdepasse WHERE cle_reinitialisation = '" . $_POST['cle'] . "'";
            $res = $connexion->query($requete);

            insertLog($connexion, '[REINITIALISATION] Mot de passe changé', $email);

            echo 'ok';
        }
    }
}