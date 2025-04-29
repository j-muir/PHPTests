<?php

function insertExercice($connexion, $array){
    $requete = "INSERT INTO exercices (nom_exercice, annee_exercice)
VALUES ('" . pg_escape_string($array['nomexercice']) . "', '".pg_escape_string($array['annee'])."')";

    $connexion->query($requete);
    insertLog($connexion, '[EXERCICE] Ajout exercice : ' . $connexion->lastInsertId() . ' - ' . urlencode($requete), $_SESSION['user']['login']);

    return true;
}

function modExercice($connexion, $array){

    $requete = "UPDATE exercices SET nom_exercice = '" . pg_escape_string($array['nomexercice']) . "', annee_exercice = '" . pg_escape_string($array['annee']) . "' WHERE id_exercice = '" . $array['id']. "'";

    insertLog($connexion, '[EXERCICE] Modification exercice : ' . $array['id'] . ' - ' . urlencode($requete), $_SESSION['user']['login']);
    $connexion->query($requete);

    return true;
}

function getExercice($connexion, $id){
    $requete = "SELECT * FROM exercices WHERE id_exercice = '" . pg_escape_string($id) . "'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $array['id'] = $row['id_exercice'];
    $array["nomexercice"] = $row["nom_exercice"];
    $array["annee"] = $row["annee_exercice"];

    return $array;
}

function changeExerciceActif($connexion, $id){
    $req = "UPDATE parametres SET exerciceactif_parametre = '" . $id . "' WHERE id_parametre = 1";
    $connexion->query($req);

    insertLog($connexion, '[PARAMETRE] Change exercice actif : ' . $id . ' - ' . urlencode($req), $_SESSION['user']['login']);

    $req = "SELECT exerciceactif_parametre FROM parametres WHERE id_parametre = 1";
    $res = $connexion->query($req);
    $row = $res->fetch(PDO::FETCH_ASSOC);
    $_SESSION['exercice'] = $row['exerciceactif_parametre'];

    return true;
}

function getExerciceActif($connexion){
    $reqParametre = "SELECT exerciceactif_parametre FROM parametres WHERE id_parametre = 1";
    $resParametre = $connexion->query($reqParametre);
    $rowParametre = $resParametre->fetch(PDO::FETCH_ASSOC);

    $requeteExercice = "SELECT * FROM exercices WHERE id_exercice = '".$rowParametre['exerciceactif_parametre']."'";
    $resExercice = $connexion->query($requeteExercice);
    $rowExercice = $resExercice->fetch(PDO::FETCH_ASSOC);

    return array('idExercice' => $rowParametre['exerciceactif_parametre'], 'anneeExercice' => $rowExercice['annee_exercice']);
}

