<?php

function getHistorique($connexion, $idCommande){
    $requete = "SELECT * FROM historiques WHERE id_commande = '".$idCommande."' ORDER BY date_historique DESC";
    $res = $connexion->query($requete);
    $arrayHistorique = array();
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        $arrayHistorique[$row['id_historique']]['message'] = $row['message_historique'];
        $arrayHistorique[$row['id_historique']]['date'] = date('d/m/Y H:i:s', strtotime($row['date_historique']));
    }

    return $arrayHistorique;
}

function addHistoriqueToCommande($connexion, $idCommande, $message){
    $requete = "INSERT INTO historiques (message_historique, id_commande, date_historique) VALUES ('".pg_escape_string($message)."', '".pg_escape_string($idCommande)."', NOW())";
    $res = $connexion->query($requete);
}


?>