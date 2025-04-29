<?php

function insertCommande($connexion, $array){
    $date = $array['date'];
    if($date == ""){
        $date = date("Y-m-d");
    }

    if(!array_key_exists('clients', $array)){
        $clients = 0;
    }else{
        $clients = $array['clients'];
    }

    $etat = "En cours";

    $array['listePrestation'] = str_replace('\r\n', '<br />', $array['listePrestation']);
    $array['listePrestation'] = str_replace('\r', '<br />', $array['listePrestation']);
    $array['listePrestation'] = str_replace('\n', '<br />', $array['listePrestation']);

    if (!array_key_exists('adresseTravaux', $array)) {
        $adresse = $array['ruetravaux'];
        $cp = $array['cptravaux'];
        $ville = $array['villetravaux'];
    } else {
        $adresse = '';
        $cp = '';
        $ville = '';
    }

    $requeteCommande = "INSERT INTO commandes (id_client, listeprestations, totalht_commande, total_commande, totaltva_commande, totalttc_commande, date_commande, remise_commande, numero_commande, timestamp_commande, info_commande, lieu_commande, adressetravaux_commande, numerotravaux_commande, ruetravaux_commande, cptravaux_commande, villetravaux_commande, etat_commande, dateprevu_commande, travauxaexecuter_commande, modepaiement_commande, nbmensualites_commande, montantmensualites_commande, remisepourcent_commande, montantfinance_commande, apport_commande, numerodevis_commande, solde_commande) 
    VALUES('".pg_escape_string($clients)."', '".pg_escape_string($array['listePrestation'])."', '".pg_escape_string($array['totalHT'])."', '".pg_escape_string($array['totalNet'])."', '".pg_escape_string($array['totalTVA'])."', '".pg_escape_string($array['totalTTC'])."', '".pg_escape_string($date)."', '".pg_escape_string($array['totalRemise'])."', '".pg_escape_string($array['numero'])."', '".pg_escape_string(strtotime($date))."', '".pg_escape_string($array['info'])."', '".pg_escape_string($array['lieu'])."', '".pg_escape_string($array['adresseTravaux'])."', '".pg_escape_string($array['numerotravaux'])."', '".pg_escape_string($adresse)."', '".pg_escape_string($cp)."', '".pg_escape_string($ville)."', '".pg_escape_string($etat)."', '".pg_escape_string($array['dateprevu'])."', '".pg_escape_string($array['travauxaexecuter'])."', '".pg_escape_string($array['modepaiement'])."', '".pg_escape_string($array['nbmensualites'])."', '".pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['montantmensualites'])))."', '".pg_escape_string($array['totalRemisePourcent'])."', '".pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['montantfinance'])))."', '".pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['apport'])))."', '".pg_escape_string($array['numerodevis'])."', '".pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['totalTTC'])))."');";
    $connexion->query($requeteCommande);

    $lastID = $connexion->lastInsertId();
    insertLog($connexion, '[COMMANDE] Ajout devis : ' . $lastID . ' - ' . urlencode($requeteCommande), $_SESSION['user']['login']);
    addHistoriqueToCommande($connexion, $lastID, 'Création du devis');

    return true;
}

function modCommande($connexion, $array){
    if (isset($array['date'])){
        $date = $array['date'];
        if($date == ""){
            $date = date("Y-m-d");
        }
    }

    if(!array_key_exists('clients', $array)){
        $clients = 0;
    }else{
        $clients = $array['clients'];
    }

    $array['listePrestation'] = str_replace('\r\n', '<br />', $array['listePrestation']);
    $array['listePrestation'] = str_replace('\r', '<br />', $array['listePrestation']);
    $array['listePrestation'] = str_replace('\n', '<br />', $array['listePrestation']);

    $soldeencaisse = getTotalEncaissementsByCommandes($connexion, $array['id']);
    $solde = stringToGoodStringFloat($array['totalTTC']) - stringToGoodStringFloat($soldeencaisse);

    if (!array_key_exists('adresseTravaux', $array)) {
        $adresse = $array['ruetravaux'];
        $cp = $array['cptravaux'];
        $ville = $array['villetravaux'];
    } else {
        $adresse = '';
        $cp = '';
        $ville = '';
    }

    if (isset($array['numero'])) {
        $requeteModCommande = "UPDATE commandes SET id_client = '" . pg_escape_string($clients) . "', listeprestations = '" . pg_escape_string($array['listePrestation']) . "', totalht_commande = '" . pg_escape_string($array['totalHT']) . "', total_commande = '" . pg_escape_string($array['totalNet']) . "', totaltva_commande = '" . pg_escape_string($array['totalTVA']) . "', totalttc_commande = '" . pg_escape_string($array['totalTTC']) . "', date_commande = '" . $date . "', remise_commande = '" . pg_escape_string($array['totalRemise']) . "', numero_commande = '" . pg_escape_string($array['numero']) . "', timestamp_commande = '" . strtotime($array['date']) . "', info_commande = '" . pg_escape_string($array['info']) . "', lieu_commande = '" . pg_escape_string($array['lieu']) . "', adressetravaux_commande = '" . pg_escape_string($array['adresseTravaux']) . "', numerotravaux_commande = '" . pg_escape_string($array['numerotravaux']) . "', ruetravaux_commande = '" . pg_escape_string($adresse) . "', cptravaux_commande = '" . pg_escape_string($cp) . "', villetravaux_commande = '" . pg_escape_string($ville) . "', dateprevu_commande = '" . pg_escape_string($array['dateprevu']) . "', travauxaexecuter_commande = '" . pg_escape_string($array['travauxaexecuter']) . "', modepaiement_commande = '" . pg_escape_string($array['modepaiement']) . "', nbmensualites_commande = '" . pg_escape_string($array['nbmensualites']) . "', montantmensualites_commande = '" . pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['montantmensualites']))) . "', remisepourcent_commande = '" . pg_escape_string($array['totalRemisePourcent']) . "', montantfinance_commande = '" . pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['montantfinance']))) . "', apport_commande = '" . pg_escape_string(floatval(str_replace([' ', ','], ['', '.'], $array['apport']))) . "',numerodevis_commande = '" . pg_escape_string($array['numerodevis']) . "', solde_commande = '" . pg_escape_string($solde) . "' WHERE id_commande = '" . $array['id'] . "'";
        insertLog($connexion, '[COMMANDE] Modification devis : ' . $array['id'] . ' - ' . urlencode($requeteModCommande), $_SESSION['user']['login']);

    }

    $connexion->query($requeteModCommande);

    return true;
}

function modEtatCommande($connexion, $array){
    $requeteModEtatCommande = "UPDATE commandes SET etat_commande = '".pg_escape_string($array['etat'])."' WHERE id_commande = '".$array['id']."'";
    $connexion->query($requeteModEtatCommande);

    insertLog($connexion, '[COMMANDE] Modification état commande : ' . $array['id'] . ' - ' . urlencode($requeteModEtatCommande), $_SESSION['user']['login']);

    if($array['etat'] == 'Envoyé'){
        $requeteModEtatCommande = "UPDATE commandes SET dateenvoye_commande = NOW() WHERE id_commande = '".$array['id']."'";
        $connexion->query($requeteModEtatCommande);

        addHistoriqueToCommande($connexion, $array['id'], 'Envoi du devis');
    }else if($array['etat'] == 'Validé'){
        $requeteModEtatCommande = "UPDATE commandes SET datevalide_commande = NOW() WHERE id_commande = '".$array['id']."'";
        $connexion->query($requeteModEtatCommande);
        $dateRetour = date('Y-m-d H:i:s');

        addHistoriqueToCommande($connexion, $array['id'], 'Validation du devis');
    }

    return $dateRetour;
}

function getCommande($connexion, $id){
    $arrayCommande = array();
    $requete = "SELECT * FROM commandes WHERE id_commande = '".$id ."'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $arrayCommande['idclient'] = $row['id_client'];
    $arrayCommande['numero'] = $row['numero_commande'];
    $arrayCommande['numerodevis'] = $row['numerodevis_commande'];
    $arrayCommande['listePrestation'] = $row['listeprestations'];
    $arrayCommande['date'] = $row['date_commande'];
    $arrayCommande['info'] = $row['info_commande'];

    $arrayCommande['adressetravaux'] = $row['adressetravaux_commande'];
    $arrayCommande['numerotravaux'] = $row['numerotravaux_commande'];
    $arrayCommande['ruetravaux'] = $row['ruetravaux_commande'];
    $arrayCommande['cptravaux'] = $row['cptravaux_commande'];
    $arrayCommande['villetravaux'] = $row['villetravaux_commande'];

    $arrayCommande['totalRemise'] = $row['remise_commande'];
    $arrayCommande['totalRemisePourcent'] = $row['remisepourcent_commande'];
    $arrayCommande['totalHT'] = $row['totalht_commande'];
    $arrayCommande['totalNet'] = $row['total_commande'];
    $arrayCommande['totalTTC'] = $row['totalttc_commande'];
    $arrayCommande['totalTVA'] = $row['totaltva_commande'];

    $arrayCommande['dateprevu'] = $row['dateprevu_commande'];
    $arrayCommande['travauxaexecuter'] = $row['travauxaexecuter_commande'];
    $arrayCommande['modepaiement'] = $row['modepaiement_commande'];
    $arrayCommande['nbmensualites'] = $row['nbmensualites_commande'];
    $arrayCommande['apport'] = number_format($row['apport_commande'], 2, ',', ' ');
    $arrayCommande['montantfinance'] = number_format($row['montantfinance_commande'], 2, ',', ' ');
    $arrayCommande['montantmensualites'] = number_format($row['montantmensualites_commande'], 2, ',', ' ');
    $arrayCommande['solde'] = number_format($row['solde_commande'], 2, ',', ' ');
    $arrayCommande['encaissements'] = getEncaissementsByCommandes($connexion, $id);

    $html = '';
    if (empty($arrayCommande['encaissements'])){
        $html = '<tr id="addaucunencaissement">' .
            '<td class="text-center" colspan="3">Aucun encaissement</td>' .
         '</tr>';
    }else{
        foreach ($arrayCommande['encaissements'] as $kencaissement => $encaissement) {
            $html .= '<tr>' .
            '<td class="dateencaissementcell">' . $encaissement['dateencaissement'] . '</td>' .
            '<td class="typepaiementcell">' . $encaissement['typepaiementencaissement'] . '</td>' .
            '<td class="montantencaissementcell">' . $encaissement['montantencaissement'] . '</td>' .
            '</tr>';
        }
    }

    $arrayCommande['encaissementshtml'] = $html;
    $arrayCommande['dateEnvoye'] = $row['dateenvoye_commande'];
    $arrayCommande['dateValide'] = $row['datevalide_commande'];

    $etat = "";
    $arrayCommande['etathtml'] = $etat;
    $arrayCommande['etat'] = $row['etat_commande'];
    $arrayCommande['historique'] = getHistorique($connexion, $id);

    return $arrayCommande;
}

function getAnomalieCommande($connexion) {
    $reqGetAnomalie = "SELECT * FROM commandes ORDER BY to_date(date_commande, 'YYYY-MM-DD') DESC";

    $resGetAnomalie = $connexion->query($reqGetAnomalie);
    $array = array();
    while ($rowAnomalie = $resGetAnomalie->fetch(PDO::FETCH_ASSOC)) {
        $message = "";
        if ($rowAnomalie['numero_commande'] == "") {
            $message .= "Numéro de devis manquant<br/>";
            $array[$rowAnomalie['id_commande']]['numero'] = "?";
        }

        $prestas = json_decode($rowAnomalie['listeprestations'])[0];
        if (empty($prestas)) {
            $message .= "Aucune prestation n'est présente dans ce devis<br/>";
            $array[$rowAnomalie['id_commande']]['listeprestations'] = "Aucune prestation";
        }else{
            foreach ($prestas as $keyPresta => $valuePresta){
                if ($keyPresta == "code"){
                     $arrayPrestas[] = $valuePresta;
                }
            }
        }

        if($message != ""){
            if($rowAnomalie['numero_commande'] != ""){
                $array[$rowAnomalie['id_commande']]['numero'] = $rowAnomalie['numero_commande'];
            }
            if (!empty($prestas)) {
                $array[$rowAnomalie['id_commande']]['listeprestations'] = implode(', ', $arrayPrestas);
            }
            $array[$rowAnomalie['id_commande']]['message'] = $message;
        }
    }

    return $array;
}

function getCommandesByClient($connexion, $idClient){
    $array = array();
    $requete = "SELECT id_commande, date_commande, numero_commande, total_commande, etat_commande, isannulee_commande, travauxaexecuter_commande, id_client FROM commandes WHERE id_client = '".$idClient ."' ORDER BY to_date(date_commande, 'YYYY-MM-DD') DESC";
    $res = $connexion->query($requete);
    while($rowCommandes = $res->fetch(PDO::FETCH_ASSOC)){
        $array[$rowCommandes['id_commande']]['id'] = $rowCommandes['id_commande'];
        $array[$rowCommandes['id_commande']]['date'] = date('d/m/Y', strtotime($rowCommandes['date_commande']));
        $array[$rowCommandes['id_commande']]['objet'] = $rowCommandes['travauxaexecuter_commande'];
        $array[$rowCommandes['id_commande']]['numero'] = $rowCommandes['numero_commande'];
        $array[$rowCommandes['id_commande']]['montantht'] = number_format($rowCommandes['total_commande'], 2, ',', ' ').'&nbsp;€';

        switch ($rowCommandes['etat_commande']) {
            case 'En cours' :
                $array[$rowCommandes['id_commande']]['etat'] = 'En cours';
                break;
            case 'Envoyé' :
                $array[$rowCommandes['id_commande']]['etat'] = 'Envoyé';
                break;
            case 'Validé' :
                $array[$rowCommandes['id_commande']]['etat'] = 'Validé';
                break;
        }

        if ($rowCommandes['isannulee_commande'] == '1') {
            $array[$rowCommandes['id_commande']]['etat'] = 'Annulée';
        }

    }

    return $array;
}

function annulerCommande($connexion, $id, $commentaire){
    $status = true;
    $erreur = "";
    $req = "UPDATE commandes SET isannulee_commande = '1', dateannulation_commande = NOW(), commentaireannulation_commande = '".$commentaire."' WHERE id_commande = '" . $id . "'";
    $res = $connexion->query($req);

    if (!$res){
        $status = false;
        $erreur = 'Un erreur est survenue.';
    }else{
        addHistoriqueToCommande($connexion, $id, 'Annulation du devis');
    }

    insertLog($connexion, '[COMMANDE] Annulation du devis : ' . $id . ' - ' . urlencode($req), $_SESSION['user']['login']);
    return array('status' => $status, 'erreur' => $erreur);
}

?>