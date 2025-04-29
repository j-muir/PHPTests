<?php

function insertClient($connexion, $array){
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

    $email = $array['email'];
    $requeteInsertClient = "INSERT INTO clients (type_client, societe_client, nom_client, prenom_client, civilite_client, adresse_client, code_postal_client, ville_client, code_numtel_client, numtel_client, code_numportable_client, numportable_client, email_client, date_client)
    VALUES ('" . pg_escape_string($array['type']) . "', '" . ucfirst(mb_strtolower(pg_escape_string($array['societe']))) . "', '" . mb_strtoupper(pg_escape_string($array['nom'])) . "', '" . ucfirst(mb_strtolower(pg_escape_string($array['prenom']))) . "', '" . pg_escape_string($array['civilite']) . "', '" . pg_escape_string($array['adresse']) . "', '" . pg_escape_string($array['codepostal']) . "', '" . pg_escape_string($array['ville']) . "', '" . pg_escape_string($codeNumTel) . "', '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numtel), 2, ' ')) . "', '" . pg_escape_string($codeNumPortable) . "', '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numportable), 2, ' ')) . "', '" . pg_escape_string($email) . "', NOW())";
    $connexion->query($requeteInsertClient);
    $lastId = $connexion->lastInsertId();

    insertLog($connexion, '[CLIENT] Ajout client : '.$lastId.' - '.urlencode($requeteInsertClient), $_SESSION['user']['login']);

    return array('prenom' => ucfirst($array['prenom']), 'nom' => mb_strtoupper($array['nom']), 'id' => $lastId);
}

function modClient($connexion, $array, $id){
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

    $email = $array['email'];
    $requeteModClient = "UPDATE clients SET type_client = '" . pg_escape_string($array['type']) . "', societe_client = '" . ucfirst(strtolower(pg_escape_string($array['societe']))) . "', nom_client = '" . strtoupper(pg_escape_string($array['nom'])) . "', prenom_client = '" . ucfirst(strtolower(pg_escape_string($array['prenom']))) . "', civilite_client = '" . pg_escape_string($array['civilite']) . "', adresse_client = '" . pg_escape_string($array['adresse']) . "', code_postal_client = '" . pg_escape_string($array['codepostal']) . "', ville_client = '" . pg_escape_string($array['ville']) . "', code_numtel_client = '" . pg_escape_string($codeNumTel) . "', numtel_client = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numtel), 2, ' ')) . "', code_numportable_client = '" . pg_escape_string($codeNumPortable) . "', numportable_client = '" . pg_escape_string(chunk_split(str_replace(array(' ','/',',','.','-'), '', $numportable), 2, ' ')) . "', email_client = '" . pg_escape_string($email) . "' WHERE id_client = '" . $id . "'";
    insertLog($connexion, '[CLIENT] Modification client : ' . $id . ' - ' . urlencode($requeteModClient), $_SESSION['user']['login']);
    $connexion->query($requeteModClient);

    return array('prenom' => $array['prenom'], 'nom' => $array['nom'], 'id' => $id, "req" => $requeteModClient);
}

function getClient($connexion, $id, $commandesclients = 'commandesClient'){
    $requeteGetClient = "SELECT * FROM clients WHERE id_client = '".pg_escape_string($id)."'";
    $resGetClient = $connexion->query($requeteGetClient);
    $rowGetClient = $resGetClient->fetch(PDO::FETCH_ASSOC);

    $array['type'] = $rowGetClient['type_client'];
    $array['societe'] = $rowGetClient['societe_client'];
    $array['nom'] = $rowGetClient['nom_client'];
    $array['prenom'] = $rowGetClient['prenom_client'];
    $array['civilite'] = $rowGetClient['civilite_client'];
    $array['adresse'] = $rowGetClient['adresse_client'];
    $array['codepostal'] = $rowGetClient['code_postal_client'];
    $array['ville'] = $rowGetClient['ville_client'];
    $array['codenumtel'] = $rowGetClient['code_numtel_client'];
    $array['numtel'] = str_replace(' ', '', $rowGetClient['numtel_client']);
    $array['codenumportable'] = $rowGetClient['code_numportable_client'];
    $array['numportable'] = str_replace(' ', '', $rowGetClient['numportable_client']);
    $array['email'] = $rowGetClient['email_client'];

    $commandesHtml = "";
    $commandes = getCommandesByClient($connexion, $id);

    foreach ($commandes as $idCommande => $commande){
        $commandesHtml .= '<tr class="'.$commandesclients.'" data-id="'.$idCommande.'">
            <td class="tdadmin">'.$commande['numero'].'</td>
            <td>'.$commande['date'].'</td>
            <td class="tdcommercial">'.$commande['objet'].'</td>
            <td>'.$commande['montantht'].'</td>
            <td class="tdadmin">'.$commande['etat'].'</td>
        </tr>';
    }

    $array['commandes'] = $commandes;
    $array['commandeshtml'] = $commandesHtml;

    $array['adresseClient'] = getAdresseClient($connexion, $id);

    return $array;
}

function getAdresseClient($connexion, $id){
    $requeteGetClient = "SELECT id_client, adresse_client, code_postal_client, ville_client FROM clients WHERE id_client = '".pg_escape_string($id)."'";
    $resGetClient = $connexion->query($requeteGetClient);
    $rowGetClient = $resGetClient->fetch(PDO::FETCH_ASSOC);

    $array['adresse'] = $rowGetClient['adresse_client'];
    $array['codepostal'] = $rowGetClient['code_postal_client'];
    $array['ville'] = $rowGetClient['ville_client'];

    return $array;
}


function deleteClient($connexion, $id){
    $commandes = getCommandesByClient($connexion, $id);
    if (empty($commandes)){
        $requeteClient = "DELETE FROM clients WHERE id_client = '".pg_escape_string($id)."'";
        $resClient = $connexion->query($requeteClient);
        insertLog($connexion, '[CLIENT] SUPPRESSION ID : ' . $id . ' - ' . urlencode($requeteClient), $_SESSION['user']['login']);
        $message = 'Client supprimé.';
        $status = true;
    }else{
        $message = 'Impossible de supprimer un client ayant des devis ou des demandes dans son historique.';
        $status = false;
    }

    return array('message' => $message, 'status' => $status);
}

?>