<?php

function insertPrestation($connexion, $array){
    $tva = $array['tva'];
    $ficheRenseignement = 0;
    if(array_key_exists('ficherenseignement', $array)){
        $ficheRenseignement = 1;
    }

    $prixTTC = 0;
    if(array_key_exists('prixTTC', $array)){
        $prixTTC = $array['prixTTC'];
    }

    $requeteInsertPrestation = "INSERT INTO prestations (designation_prestation, prix_ht_prestation, tva_prestation, ref_prestation, date_prestation, designation_complementaire_prestation, fiche_renseignement_prestation, prix_ttc_prestation)
    VALUES ('" . ucfirst(strtolower(pg_escape_string($array['designationSimple']))) . "', '" . pg_escape_string($array['prixHT']) . "', '" . pg_escape_string($tva) . "', '" . strtoupper(pg_escape_string($array['reference'])) . "', NOW(), '" . pg_escape_string($array['designationComplementaire']) . "', '".$ficheRenseignement."', '".$prixTTC."')";
    $connexion->query($requeteInsertPrestation);

    $lastId = $connexion->lastInsertId();

    insertLog($connexion, '[PRESTATION] Ajout prestation : '.$lastId.' - '.urlencode($requeteInsertPrestation), $_SESSION['user']['login']);
    return true;
}

function modPrestation($connexion, $array, $id){
    $tva = $array['tva'];
    $ficheRenseignement = 0;
    if(array_key_exists('ficherenseignement', $array)){
        $ficheRenseignement = 1;
    }

    $prixTTC = 0;
    if(array_key_exists('prixTTC', $array)){
        $prixTTC = $array['prixTTC'];
    }

    $requeteModPrestation = "UPDATE prestations SET designation_prestation = '" . ucfirst(strtolower(pg_escape_string($array['designationSimple']))) . "', prix_ht_prestation = '" . pg_escape_string($array['prixHT']) . "', tva_prestation = '" . pg_escape_string($tva) . "', ref_prestation = '" . strtoupper(pg_escape_string($array['reference'])) . "', fiche_renseignement_prestation = '".$ficheRenseignement."', prix_ttc_prestation = '".pg_escape_string($prixTTC)."' WHERE id_prestation = '" . $id . "'";
    insertLog($connexion, '[PRESTATION] Modification prestation : ' . $id . ' - ' . urlencode($requeteModPrestation), $_SESSION['user']['login']);

    $connexion->query($requeteModPrestation);

    return true;
}

function getPrestation($connexion, $id){
    $requeteGetPrestation = "SELECT * FROM prestations WHERE id_prestation = '".pg_escape_string($id)."'";
    $resGetPrestation = $connexion->query($requeteGetPrestation);
    $rowGetPrestation = $resGetPrestation->fetch(PDO::FETCH_ASSOC);
    $arrayTVA = explode('|', $rowGetPrestation['tva_prestation']);
    $array['designationSimple'] = $rowGetPrestation['designation_prestation'];
    $array['designationComplementaire'] = $rowGetPrestation['designation_complementaire_prestation'];
    $array['prixHT'] = $rowGetPrestation['prix_ht_prestation'];
    $array['prixTTC'] = $rowGetPrestation['prix_ttc_prestation'];
    $array['tva'] = $arrayTVA;
    $array['reference'] = $rowGetPrestation['ref_prestation'];
    $array['ficherenseignement'] = $rowGetPrestation['fiche_renseignement_prestation'];

    return $array;
}

?>