<?php

function insertUtilisateur($connexion, $array){
    if(loginExist($connexion, $array['email'])){
        insertLog($connexion, '[UTILISATEUR] Echec ajout utilisateur. Adresse email existante : '.$array['email'], $_SESSION['user']['login']);
        return false;
    }

    $codeNumTel = "";
    $codeNumPortable = "";

    $numtel = '';
    if ($array['numtel'] !== '') {
        $numtel = $array['numtel'];
        if (!substr($array['numtel'], 0, 1) == '0') {
            $numtel = '0' . $array['numtel'];
        }
    }

    $numportable = '';
    if ($array['numportable'] !== ''){
        $numportable = $array['numportable'];
        if (!substr($array['numportable'], 0, 1) == '0'){
            $numportable = '0' . $array['numportable'];
        }
    }

    $requeteInsertUtilisateur = "INSERT INTO utilisateurs (nom_utilisateur, prenom_utilisateur, numtel_utilisateur, numportable_utilisateur, fonction_utilisateur, email_utilisateur, password_utilisateur, date_utilisateur, codenumtel_utilisateur, codenumportable_utilisateur, typeutilisateur_utilisateur)
    VALUES ('" . mb_strtoupper(pg_escape_string($array['nom'])) . "', '" . ucfirst(mb_strtolower(pg_escape_string($array['prenom']))) . "', '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numtel), 2, ' ')) . "', '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numportable), 2, ' ')) . "', '" . pg_escape_string($array['fonction']) . "', '" . pg_escape_string($array['email']) . "', '" . sha1($array['password']) . "', NOW(), '" . pg_escape_string($codeNumTel) . "', '" . pg_escape_string($codeNumPortable) . "', '" . pg_escape_string($array['typeutilisateur']) . "')";
    $connexion->query($requeteInsertUtilisateur);
    insertLog($connexion, '[UTILISATEUR] Ajout utilisateur : '.$connexion->lastInsertId().' - '.urlencode($requeteInsertUtilisateur), $_SESSION['user']['login']);

    return true;
}

function modUtilisateur($connexion, $array){
    if(loginExist($connexion, $array['email'], $array['id'])){
        insertLog($connexion, '[UTILISATEUR] Echec modification utilisateur. Adresse email existante : '.$array['email'], $_SESSION['user']['login']);
        return false;
    }

    $codeNumTel = "";
    $codeNumPortable = "";

    $numtel = '';
    if ($array['numtel'] !== '') {
        $numtel = $array['numtel'];
        if (!substr($array['numtel'], 0, 1) == '0') {
            $numtel = '0' . $array['numtel'];
        }
    }

    $numportable = '';
    if ($array['numportable'] !== ''){
        $numportable = $array['numportable'];
        if (!substr($array['numportable'], 0, 1) == '0'){
            $numportable = '0' . $array['numportable'];
        }
    }

    if($array['password'] == "") {
        $requeteModUtilisateur = "UPDATE utilisateurs SET nom_utilisateur = '" . mb_strtoupper(pg_escape_string($array['nom'])) . "', prenom_utilisateur = '" . ucfirst(mb_strtolower(pg_escape_string($array['prenom']))) . "', numtel_utilisateur = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numtel), 2, ' ')) . "', numportable_utilisateur = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numportable), 2, ' ')) . "', fonction_utilisateur = '" . pg_escape_string($array['fonction']) . "', email_utilisateur = '" . pg_escape_string($array['email']) . "', codenumtel_utilisateur = '" . pg_escape_string($codeNumTel) . "', codenumportable_utilisateur = '" . pg_escape_string($codeNumPortable) . "', typeutilisateur_utilisateur = '" . pg_escape_string($array['typeutilisateur']) . "' WHERE id_utilisateur = '" . $array['id'] . "'";
        insertLog($connexion, '[UTILISATEUR] Modification utilisateur sans changement de pwd : '.$array['id'].' - '.urlencode($requeteModUtilisateur), $_SESSION['user']['login']);
    }else{
        $requeteModUtilisateur = "UPDATE utilisateurs SET nom_utilisateur = '" . mb_strtoupper(pg_escape_string($array['nom'])) . "', prenom_utilisateur = '" . ucfirst(mb_strtolower(pg_escape_string($array['prenom']))) . "', numtel_utilisateur = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numtel), 2, ' ')) . "', numportable_utilisateur = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numportable), 2, ' ')) . "', fonction_utilisateur = '" . pg_escape_string($array['fonction']) . "', email_utilisateur = '" . pg_escape_string($array['email']) . "', password_utilisateur = '". sha1($array['password']) . "', codenumtel_utilisateur = '" . pg_escape_string($codeNumTel) . "', codenumportable_utilisateur = '" . pg_escape_string($codeNumPortable) . "', typeutilisateur_utilisateur = '" . pg_escape_string($array['typeutilisateur']) . "' WHERE id_utilisateur = '" . $array['id'] . "'";
        insertLog($connexion, '[UTILISATEUR] Modification utilisateur avec changement de pwd : '.$array['id'].' - '.urlencode($requeteModUtilisateur), $_SESSION['user']['login']);
    }
    $connexion->query($requeteModUtilisateur);

    return true;
}

function getUtilisateur($connexion, $id){
    $requeteGetUtilisateur = "SELECT * FROM utilisateurs WHERE id_utilisateur = '".pg_escape_string($id)."'";
    $resGetUtilisateur = $connexion->query($requeteGetUtilisateur);
    $rowGetUtilisateur = $resGetUtilisateur->fetch(PDO::FETCH_ASSOC);

    $array['nom'] = $rowGetUtilisateur['nom_utilisateur'];
    $array['prenom'] = $rowGetUtilisateur['prenom_utilisateur'];
    $array['email'] = $rowGetUtilisateur['email_utilisateur'];
    $array['fonction'] = $rowGetUtilisateur['fonction_utilisateur'];
    $array['numtel'] = str_replace(' ', '', $rowGetUtilisateur['numtel_utilisateur']);
    $array['numportable'] = str_replace(' ', '', $rowGetUtilisateur['numportable_utilisateur']);
    $array['codenumtel'] = $rowGetUtilisateur['codenumtel_utilisateur'];
    $array['codenumportable'] = $rowGetUtilisateur['codenumportable_utilisateur'];
    $array['typeUtilisateur'] = $rowGetUtilisateur['typeutilisateur_utilisateur'];

    return $array;
}

?>