<?php

session_start();
include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionsexercices.php');
if(isAjax()) {
    if (isset($_POST['qrcode'])) {
        /* on décrypte le qrcode */
        $key = 'keycryptvdmaactcs54gestionticket';
        $qrcodeDecrypt = decrypt($_POST['qrcode'], $key);
        $qrcodeDecrypt = explode('||', $qrcodeDecrypt);

        $email = pg_escape_string($qrcodeDecrypt[0]);
        $password = $qrcodeDecrypt[1];
        $requeteUtilisateur = "SELECT * FROM utilisateurs WHERE email_utilisateur = '" . $email . "' AND password_utilisateur = '" . sha1($password) . "'";
        $resUtilisateur = $connexion->query($requeteUtilisateur);
        if ($resUtilisateur->rowCount() > 0) {
            $rowUtilisateur = $resUtilisateur->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user']['login'] = $rowUtilisateur['email_utilisateur'];
            $_SESSION['user']['nom'] = $rowUtilisateur['nom_utilisateur'];
            $_SESSION['user']['prenom'] = $rowUtilisateur['prenom_utilisateur'];
            $_SESSION['user']['fonction'] = $rowUtilisateur['fonction_utilisateur'];
            $_SESSION['user']['typeutilisateur'] = $rowUtilisateur['typeutilisateur_utilisateur'];

            $infosExerciceActif = getExerciceActif($connexion);
            $_SESSION['idExercice'] = $infosExerciceActif['idExercice'];
            $_SESSION['anneeExercice'] = $infosExerciceActif['anneeExercice'];

            insertLog($connexion, '[CONNEXION UTILISATEUR] Réussie', $_SESSION['user']['login']);
            echo json_encode(array('status' => true, 'typeutilisateur' => $_SESSION['user']['typeutilisateur']));
        } else{
            insertLog($connexion, '[CONNEXION] Echec - Email : '.$email.' - Pwd : '.$password, $_SESSION['user']['login']);
            echo json_encode(array('status' => false));
        }
    }
}