<?php

function reinitialisation($connexion, $login, $cle){
    $requete = "INSERT INTO reinitialisation_motdepasse (login_reinitialisation, cle_reinitialisation, date_reinitialisation) VALUES ('".pg_escape_string($login)."','".$cle."',NOW())";
    insertLog($connexion, '[MOT DE PASSE] Demande de réinitialisation : '.$login.' - '.$requete, $login);

    $res = $connexion->query($requete);
}

function checkIfCanReinitialise($connexion, $cle){
    $requete = "SELECT * FROM reinitialisation_motdepasse WHERE cle_reinitialisation = '".$cle."' AND TIMESTAMPDIFF(MINUTE, date_reinitialisation, NOW()) < 20";
    $res = $connexion->query($requete);
    $count = $res->rowCount();

    if($count > 0){
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $login = $row['login_reinitialisation'];
        return $login;
    }else{
        return false;
    }
}

?>