<?php

function getDetailFiche($connexion, $idFiche){
    $requete = "SELECT * FROM fiches WHERE id_fiche = '".pg_escape_string($idFiche)."'";
    $res = $connexion->query($requete);
    $arrayFiche = [];
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        $arrayFiche['numero'] = $row['numero_fiche'];
        $arrayFiche['datedemande'] = date('Y-m-d', strtotime($row['date_demande_fiche']));
        $arrayFiche['recupar'] = $row['recu_par_fiche'];
        $arrayFiche['dateaenvoyer'] = date('Y-m-d', strtotime($row['devis_a_envoyer_pour_le_fiche']));
        $arrayFiche['nomgroupe'] = $row['nom_groupe_fiche'];
        $arrayFiche['nom'] = $row['nom_responsable_fiche'];
        $arrayFiche['prenom'] = $row['prenom_responsable_fiche'];
        $arrayFiche['adresse'] = $row['adresse_responsable_fiche'];
        $arrayFiche['complement'] = $row['complement_fiche'];
        $arrayFiche['codepostal'] = $row['cp_fiche'];
        $arrayFiche['ville'] = $row['ville_fiche'];
        $arrayFiche['numtel'] = $row['numero_telephone_fiche'];
        $arrayFiche['email'] = $row['email_fiche'];
        $arrayFiche['email2'] = $row['email2_fiche'];
        $arrayFiche['datevisite'] = '';
        if(!empty($row['date_visite_fiche'])){
            $arrayFiche['datevisite'] = date('Y-m-d', strtotime($row['date_visite_fiche']));
        }

        $arrayFiche['heurevisite'] = '';
        if(!empty($row['heure_visite_fiche'])){
            $arrayFiche['heurevisite'] = $row['heure_visite_fiche'];
        }

        $arrayFiche['moisvisite'] = '';
        $arrayFiche['option'] = $row['option_fiche'];
        $arrayFiche['envoimail'] = $row['a_envoyer_par_mail_fiche'];
        $arrayFiche['envoicourrier'] = $row['a_envoyer_par_courrier_fiche'];
        $arrayFiche['motobecane'] = $row['motobecane_fiche'];
        $arrayFiche['metiersdantan'] = $row['metier_dantan_fiche'];
        $arrayFiche['nbadulte'] = $row['nb_adulte_fiche'];
        $arrayFiche['nbenfant'] = $row['nb_enfant_fiche'];
        $arrayFiche['nbaccompagnateur'] = $row['nb_accompagnateur_fiche'];
        $arrayFiche['pmr'] = $row['pmr_fiche'];
        $arrayFiche['specificite'] = $row['specificite_fiche'];
        $arrayFiche['mois_visite'] = '';
        if(!empty($row['mois_visite_fiche'])){
            $arrayFiche['mois_visite'] = $row['mois_visite_fiche'];
        }

        $arrayFiche['commentaires'] = $row['commentaires_fiche'];
        $arrayFiche['prestationssuplementaires'] = json_decode($row['prestations_complementaire_fiche'], TRUE);
        $arrayFiche['infoFiche'] = 'Fiche réalisée par '.$row['auteur_fiche'].' le '.date('d/m/Y', strtotime($row['date_creation_fiche']));
    }

    return $arrayFiche;
}

function getDetailFicheAValider($connexion, $numeroDevis){
    $arrayPresationFiche = getPrestations($connexion, 1);

    $requete = "SELECT * FROM fiches WHERE numero_fiche = '".pg_escape_string($numeroDevis)."'";
    $res = $connexion->query($requete);
    $arrayFiche = [];
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        $arrayFiche['numero'] = $row['numero_fiche'];
        $arrayFiche['datedemande'] = date('d/m/Y', strtotime($row['date_demande_fiche']));
        $arrayFiche['recupar'] = $row['recu_par_fiche'];

        /* CONTACT GROUPE */
        $adresse = $arrayFiche['adresse'].' '.$arrayFiche['codepostal'].' '.$arrayFiche['ville'];
        $arrayFiche['contactgroupe'] = $row['nom_groupe_fiche'].' - '.$row['nom_responsable_fiche'].' '.$row['prenom_responsable_fiche'].' - '.$row['numero_telephone_fiche'].' - '.$row['email_fiche'].' - '.$adresse;
        $arrayFiche['dateaenvoyer'] = date('d/m/Y', strtotime($row['devis_a_envoyer_pour_le_fiche']));


        $arrayFiche['datevisite'] = '';
        if(!empty($row['date_visite_fiche'])){
            $arrayFiche['datevisite'] = date('d/m/Y', strtotime($row['date_visite_fiche']));
        }

        if(!empty($row['heure_visite_fiche'])){
            $arrayFiche['datevisite'] .= ' '.$row['heure_visite_fiche'];
        }

        $arrayFiche['musee'] = '';
        if($row['motobecane_fiche'] === 1){
            $arrayFiche['musee'] .= 'Motobécane, ';
        }
        if($row['metier_dantan_fiche'] === 1){
            $arrayFiche['musee'] .= 'Village métiers d\'antan, ';
        }
        $arrayFiche['musee'] = substr($arrayFiche['musee'], 0, -2);
        $pmr = '(Pas d\'accueil PMR)';
        if($row['pmr_fiche'] === 1){
            $pmr = '(Accueil PMR)';
        }
        $arrayFiche['participants'] = $row['specificite_fiche'].' - '.$row['nb_adulte_fiche'].' adulte(s) + '.$row['nb_enfant_fiche'].' enfant(s) + '.$row['nb_accompagnateur_fiche'].' accompagnateur(s) '.$pmr;
        $arrayFiche['prestationssuplementaires'] = json_decode($row['prestations_complementaire_fiche'], TRUE);

        $arrayFiche['lesprestationssupplementaires'] = '';
        foreach($arrayFiche['prestationssuplementaires'] as $keyF => $valF){
            $arrayFiche['lesprestationssupplementaires'] .= $arrayPresationFiche[$keyF]['designationSimple'].', ';
        }

        $arrayFiche['lesprestationssupplementaires'] = substr($arrayFiche['lesprestationssupplementaires'], 0, -2);
    }

    return $arrayFiche;
}

function archiveFiche($connexion, $dateToday, $auteur, $idFiche){
    $requete = "UPDATE fiches SET auteur_archive_fiche = '".pg_escape_string($auteur)."', date_archive_fiche = '".$dateToday."', archive_fiche = 1 WHERE id_fiche = '".pg_escape_string($idFiche)."'";
    $connexion->query($requete);
    insertLog($connexion, '[ARCHIVE FICHE] '.$requete, $_SESSION['user']['login']);
}

function addFiche($connexion, $dateToday, $dateDenvoi, $auteur){
    $numeroFiche = getLastNumeroFiche($connexion);
    $requete = "INSERT INTO fiches (numero_fiche, date_demande_fiche, recu_par_fiche, devis_a_envoyer_pour_le_fiche, specificite_fiche, date_creation_fiche, auteur_fiche) VALUES ('".pg_escape_string($numeroFiche)."', '".$dateToday."', 'Téléphone', '".$dateDenvoi."', 'Visiteurs', '".$dateToday."', '".pg_escape_string($auteur)."')";
    $connexion->query($requete);
    $idFicheAdded = $connexion->lastInsertId();
    incrementeLastNumeroFiche($connexion);
    insertLog($connexion, '[ADD FICHE] '.$requete, $_SESSION['user']['login']);

    return array('idFicheAdded' => $idFicheAdded, 'numeroFicheAdded' => $numeroFiche);
}

function getLastNumeroFiche($connexion){
    $requete = "SELECT last_numero_fiche_parametre FROM parametres WHERE id_parametre = 1";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $lastNumeroFiche = $row['last_numero_fiche_parametre'];
    return formatIntToNumeroFiche($lastNumeroFiche);
}

function formatIntToNumeroFiche($int) {
    $formattedNumber = sprintf("%05d", $int);
    $result = 'F' . $formattedNumber;
    return $result;
}

function incrementeLastNumeroFiche($connexion){
    $requete = "UPDATE parametres SET last_numero_fiche_parametre = last_numero_fiche_parametre + 1 WHERE id_parametre = 1";
    $res = $connexion->query($requete);
}

function modFiche($connexion, $elementMod, $valueFiche, $idFiche){
    $requete = "UPDATE fiches SET ".$elementMod."_fiche = '".pg_escape_string($valueFiche)."' WHERE id_fiche = '".pg_escape_string($idFiche)."'";
    $connexion->query($requete);

    if($elementMod === 'mois_visite'){
        $requete = "UPDATE fiches SET date_visite_fiche = NULL, heure_visite_fiche = '' option_fiche = '0' WHERE id_fiche = '".pg_escape_string($idFiche)."'";
        $connexion->query($requete);
    }

    if($elementMod === 'date_visite'){
        $requete = "UPDATE fiches SET mois_visite_fiche = '' WHERE id_fiche = '".pg_escape_string($idFiche)."'";
        $connexion->query($requete);
    }

    insertLog($connexion, '[MOD FICHE '.$_POST['idFiche'].'] '.$requete, $_SESSION['user']['login']);
}

function getFichesDatatable($connexion){
    $requete = "SELECT * FROM fiches WHERE archive_fiche = 0";
    $res = $connexion->query($requete);
    $arrayFinal = [];
    $i = 0;
    while($row = $res->fetch(PDO::FETCH_ASSOC)){
        $arrayFinal[$i]['DT_RowId'] = $row['id_fiche'];
        $arrayFinal[$i]['numero'] = $row['numero_fiche'];
        $arrayFinal[$i]['date'] = date('d/m/Y', strtotime($row['date_demande_fiche']));

        $info = '';
        if($row['nom_groupe_fiche'] !== ''){
            $info .= $row['nom_groupe_fiche'].' - ';
        }

        if($row['nom_responsable_fiche'] !== '' OR $row['prenom_responsable_fiche'] !== ''){
            $info .= $row['prenom_responsable_fiche'].' '.$row['nom_responsable_fiche'].' - ';
        }

        if($row['numero_telephone_fiche'] !== ''){
            $info .= $row['numero_telephone_fiche'].' - ';
        }

        $info = substr($info, 0, -3);
        $info .= '<br />';
        $libelleParticipant = 'participant';
        $nbParticipants = $row['nb_adulte_fiche'] + $row['nb_enfant_fiche'] + $row['nb_accompagnateur_fiche'];
        if($nbParticipants > 0){
            $libelleParticipant .= 's';
        }
        $info .= $nbParticipants.' '.$libelleParticipant;

        $arrayFinal[$i]['infos'] = $info;
        $arrayFinal[$i]['devis'] = 0;
        $arrayFinal[$i]['avalider'] = 0;
        $arrayFinal[$i]['mail'] = $row['a_envoyer_par_mail_fiche'];
        $arrayFinal[$i]['papier'] = $row['a_envoyer_par_courrier_fiche'];
        $arrayFinal[$i]['refuse'] = 0;
        $arrayFinal[$i]['commande'] = 0;
        $arrayFinal[$i]['qui'] = getInitials($row['auteur_fiche']);

        $i++;
    }

    return array('data' => $arrayFinal);
}

?>