<?php

function insertDemande($connexion, $array){
    // Si c'est un nouveau prospect on créé un client
    if (array_key_exists('nouveau_prospect', $array)) {
        $idClient = insertClient($connexion, $array);
    } else {
        $idClient = $array['clients'];
    }

    $accueil_pmr = 0;
    if (array_key_exists('accueil_pmr', $array)) {
        $accueil_pmr = 1;
    }

    $guidage_benevole = 0;
    if (array_key_exists('guidage_benevole', $array)) {
        $guidage_benevole = 1;
    }

    $guide_professionnel = 0;
    if (array_key_exists('guide_professionnel', $array)) {
        $guide_professionnel = 1;
    }

    $date_visite = str_replace('T', ' ', $array['date_visite']);

    $exercice_demande = date('Y', strtotime($array['date_demande']));

    $req = "INSERT INTO demandes (date_demande, date_a_envoyer_demande, type_demande, autres_type_demande, id_client, date_visite_demande, nombre_participant_demande, nombre_accompagnateur_demande, accueil_pmr_demande, specificite_groupe_demande, autres_specificite_groupe_demande, guidage_benevole_demande, guide_professionnel_demande, location_salle_demande, statut_demande, exercice_demande) 
    VALUES('" . pg_escape_string($array['date_demande']) . "', '" . pg_escape_string($array['date_a_envoyer']) . "', '" . pg_escape_string($array['type_demande']) . "', '" . pg_escape_string($array['autres_type_demande']) . "', '" . pg_escape_string($idClient) . "', '" . pg_escape_string($date_visite) . "', '" . pg_escape_string($array['nombre_participant']) . "', '" . pg_escape_string($array['nombre_accompagnateur']) . "', '" . pg_escape_string($accueil_pmr) . "', '" . pg_escape_string($array['specificite_groupe']) . "', '" . pg_escape_string($array['autres_specificite_groupe']) . "', '" . pg_escape_string($guidage_benevole) . "', '" . pg_escape_string($guide_professionnel) . "', '" . pg_escape_string($array['location_salle']) . "', '0', '" . pg_escape_string($exercice_demande) . "');";
    $connexion->query($req);

    $lastID = $connexion->lastInsertId();
    insertLog($connexion, '[DEMANDE] Ajout demande : ' . $lastID . ' - ' . urlencode($req), $_SESSION['user']['login']);

    return true;
}

function modDemande($connexion, $array){
    // Si c'est un nouveau prospect on créé un client
    if (array_key_exists('nouveau_prospect', $array)) {
        $idClient = insertClient($connexion, $array);
    } else {
        $idClient = $array['clients'];
    }

    $accueil_pmr = 0;
    if (array_key_exists('accueil_pmr', $array)) {
        $accueil_pmr = 1;
    }

    $guidage_benevole = 0;
    if (array_key_exists('guidage_benevole', $array)) {
        $guidage_benevole = 1;
    }

    $guide_professionnel = 0;
    if (array_key_exists('guide_professionnel', $array)) {
        $guide_professionnel = 1;
    }

    $date_visite = str_replace('T', ' ', $array['date_visite']);

    $req = "UPDATE demandes SET date_demande = '" . pg_escape_string($array['date_demande']) . "', date_a_envoyer_demande = '" . pg_escape_string($array['date_a_envoyer']) . "', type_demande = '" . pg_escape_string($array['type_demande']) . "', autres_type_demande = '" . pg_escape_string($array['autres_type_demande']) . "', id_client = '" . pg_escape_string($idClient) . "', date_visite_demande = '" . pg_escape_string($date_visite) . "', nombre_participant_demande = '" . pg_escape_string($array['nombre_participant']) . "', nombre_accompagnateur_demande = '" . pg_escape_string($array['nombre_accompagnateur']) . "', accueil_pmr_demande = '" . pg_escape_string($accueil_pmr) . "', specificite_groupe_demande = '" . pg_escape_string($array['specificite_groupe']) . "', autres_specificite_groupe_demande = '" . pg_escape_string($array['autres_specificite_groupe']) . "', guidage_benevole_demande = '" . pg_escape_string($guidage_benevole) . "', guide_professionnel_demande = '" . pg_escape_string($guide_professionnel) . "', location_salle_demande = '" . pg_escape_string($array['location_salle']) . "' WHERE id_demande = '" . $array['id'] . "'";
    insertLog($connexion, '[DEMANDE] Modification demande : ' . $array['id'] . ' - ' . urlencode($req), $_SESSION['user']['login']);

    $connexion->query($req);

    return true;
}

function getDemande($connexion, $id){
    $array = array();
    $req = "SELECT * FROM demandes WHERE id_demande = '".$id ."'";
    $res = $connexion->query($req);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $array['id'] = $row['id_demande'];
    $array['date_demande'] = $row['date_demande'];
    $array['date_demande_fr'] = !empty($row['date_demande'])?date('d/m/Y', strtotime($row['date_demande'])):'';
    $array['date_a_envoyer'] = $row['date_a_envoyer_demande'];
    $array['date_a_envoyer_fr'] = !empty($row['date_a_envoyer_demande'])?date('d/m/Y', strtotime($row['date_a_envoyer_demande'])):'';
    $array['type_demande'] = $row['type_demande'];
    $array['clients'] = $row['id_client'];
    $array['date_visite'] = !empty($row['date_visite_demande'])?str_replace(' ', 'T', $row['date_visite_demande']):'';
    $array['date_visite_en'] = !empty($row['date_visite_demande'])?date('Y-m-d H:i', strtotime($row['date_visite_demande'])):'';
    $array['date_visite_fr'] = !empty($row['date_visite_demande'])?date('d/m/Y H:i', strtotime($row['date_visite_demande'])):'';
    $array['nombre_participant'] = $row['nombre_participant_demande'];
    $array['nombre_accompagnateur'] = $row['nombre_accompagnateur_demande'];
    $array['accueil_pmr'] = $row['accueil_pmr_demande'];
    $array['specificite_groupe'] = $row['specificite_groupe_demande'];
    $array['autres_specificite_groupe'] = $row['autres_specificite_groupe_demande'];
    $array['guidage_benevole'] = $row['guidage_benevole_demande'];
    $array['guide_professionnel'] = $row['guide_professionnel_demande'];
    $array['location_salle'] = $row['location_salle_demande'];
    $array['statut_demande'] = $row['statut_demande'];

    return $array;
}

function changeStatutDemande($connexion, $array){
    $req = "UPDATE demandes SET statut_demande = '" . $array['statut'] . "' WHERE id_demande = '" . $array['id'] . "'";
    insertLog($connexion, '[DEMANDE] Modification statut demande : ' . $array['id'] . ' - ' . urlencode($req), $_SESSION['user']['login']);

    $connexion->query($req);

    return true;
}

?>