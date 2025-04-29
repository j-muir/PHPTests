<?php

function insertListeDeroulante($connexion, $tableConcernee, $array){
    $requeteInsertListeDeroulante = "INSERT INTO $tableConcernee (nom_$tableConcernee)
    VALUES ('" . ucfirst(pg_escape_string($array['nom'])) . "')";
    $resInsertListeDeroulante = $connexion->query($requeteInsertListeDeroulante);
    insertLog($connexion, '['.strtoupper($tableConcernee).'] Ajout '.$tableConcernee.' : '.$connexion->lastInsertId().' - '.urlencode($requeteInsertListeDeroulante), $_SESSION['user']['login']);
    
    return true;
}

function modListeDeroulante($connexion, $id, $tableConcernee, $array){
    $requeteModListeDeroulante = "UPDATE $tableConcernee SET nom_$tableConcernee = '" . ucfirst(pg_escape_string($array['nom'])) ."' WHERE id_$tableConcernee = '" . $id . "'";
    insertLog($connexion, '['.strtoupper($tableConcernee).'] Modification '.$tableConcernee.' : '.$id.' - '.urlencode($requeteModListeDeroulante), $_SESSION['user']['login']);
    $resModListeDeroulante = $connexion->query($requeteModListeDeroulante);

    return true;
}

function getDetailListeDeroulante($connexion, $id, $tableConcernee){
    $requeteGetListeDeroulante = "SELECT * FROM $tableConcernee WHERE id_$tableConcernee = '".pg_escape_string($id)."'";
    $resGetListeDeroulante = $connexion->query($requeteGetListeDeroulante);
    $rowGetListeDeroulante = $resGetListeDeroulante->fetch(PDO::FETCH_ASSOC);

    $array['nom'] = $rowGetListeDeroulante['nom_'.$tableConcernee];

    return $array;
}

?>