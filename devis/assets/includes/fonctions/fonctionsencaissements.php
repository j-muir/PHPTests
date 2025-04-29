<?php

function insertEncaissement($connexion, $array){
    $solde = '0.00';
    $requete = "INSERT INTO encaissements (idcommande_encaissement, dateencaissement_encaissement, typepaiement_encaissement, montantencaissement_encaissement, date_encaissement)
    VALUES('" . pg_escape_string($array['idcommande']) . "', '" . pg_escape_string($array['dateencaissement']) . "', '" . pg_escape_string($array['typepaiementencaissement']) . "', '" . pg_escape_string($array['montantencaissement']) . "', NOW())";
    $res = $connexion->query($requete);

    if (!$res) {
        $status = false;
    }else{
        $lastID = $connexion->lastInsertId();
        insertLog($connexion, '[COMMANDE] Ajout d\'un encaissement : ' . $lastID . ' - ' . urlencode($requete), $_SESSION['user']['login']);
        addHistoriqueToCommande($connexion, $array['idcommande'], 'Ajout d\'un encaissement ('.$array['typepaiementencaissement'] . ' : ' . $array['montantencaissement'] . ' €)');

        // on mets à jours le solde restant
        $solde = stringToGoodStringFloat($array['solde']) - stringToGoodStringFloat($array['montantencaissement']);

        $req = "UPDATE commandes SET solde_commande = '" . $solde . "' WHERE id_commande = '" . pg_escape_string($array['idcommande']) . "'";
        $resUpdate = $connexion->query($req);

        if (!$resUpdate){
            $status = false;
        }else{
            $status = true;
        }
    }

    return array('status' => $status, 'solde' => $solde, 'dateencaissement' => date('d/m/Y', strtotime($array['dateencaissement'])));
}

function getEncaissementsByCommandes($connexion, $idCommande){
    $array = array();
    $requete = "SELECT * FROM encaissements WHERE idcommande_encaissement = '".$idCommande ."' ORDER BY dateencaissement_encaissement ASC";
    $res = $connexion->query($requete);

    $i = 0;
    while($rowEncaissement = $res->fetch(PDO::FETCH_ASSOC)){
        $array[$i]['idcommande'] = $rowEncaissement['idcommande_encaissement'];
        $array[$i]['dateencaissement'] = date('d/m/Y', strtotime($rowEncaissement['dateencaissement_encaissement']));
        $array[$i]['typepaiementencaissement'] = $rowEncaissement['typepaiement_encaissement'];
        $array[$i]['montantencaissement'] = number_format($rowEncaissement['montantencaissement_encaissement'], 2, ',', ' ').'&nbsp;€';
        $i++;
    }

    return $array;
}

function getTotalEncaissementsByCommandes($connexion, $idCommande){
    $requete = "SELECT SUM(montantencaissement_encaissement) as montanttotal FROM encaissements WHERE idcommande_encaissement = '".$idCommande ."'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if(empty($row['montanttotal'])) {
        $montanttotal = '0';
    } else {
        $montanttotal = $row['montanttotal'];
    }

    return $montanttotal;
}

?>