<?php

require __DIR__ . '/../../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$nomFichier = "donnees.json"; 

if (file_exists($nomFichier)) {
    $jsonData = file_get_contents($nomFichier);
    $data = json_decode($jsonData, true);

    $numDevis = $_POST['numDevis'] ?? null;
    if (!$numDevis) {
        die("Numéro de devis non fourni.");
    }

    $devis = null;
    foreach ($data['devis'] as $item) {
        if ($item['NoDEVIS'] == $numDevis) {
            $devis = $item;
            break;
        }
    }

    if (!$devis) {
        die("Numéro de devis introuvable.");
    }

    $header = file_get_contents("header.txt");
    $footer = file_get_contents("footer.txt");
    $objet = file_get_contents("objet.txt");
    $lignes = file_get_contents("Lignes.txt");
    $debuttable = file_get_contents("debuttable.txt");
    $fintable = file_get_contents("fintable.txt");
    $taux = file_get_contents("taux.txt");
    $reglement = file_get_contents("reglement.txt");
    $bonaccord = file_get_contents("bonaccord.txt");

    $contenu = str_replace("{(NoDEVIS)}", $devis["NoDEVIS"], file_get_contents("lesdevis.txt"));
    $contenu2 = str_replace("{(NoDEVIS)}", $devis["NoDEVIS"], file_get_contents("lesdevis2.txt"));

    // DONNÉES QR
    $qrData = [
        $devis["NoDEVIS"] ?? '',
        $devis["NOM_GROUPE"] ?? '',
        $devis["NOM_RESPONSABLE"] ?? '',
        $devis['DATE_VISITE'] ?? '',
        $devis['HEURE_VISITE'] ?? '',
        $devis["PMR"] ?? '',
        $devis['TLF_RESP'] ?? '',
        $devis['MAIL_RESP'] ?? ''
    ];
    
    $qrDataString = implode(" | ", array_map('trim', $qrData));
    $header = str_replace("{(QRDATA)}", $qrDataString, $header);

    // DONÉES BASE
    $contenu = str_replace("{(DATE)}", $devis["DATE"], $contenu);
    $contenu = str_replace("{(NOM_GROUPE)}", $devis["NOM_GROUPE"], $contenu);
    $contenu = str_replace("{(NOM_RESPONSABLE)}", $devis["NOM_RESPONSABLE"], $contenu);
    $contenu = str_replace("{(ADRESSE)}", $devis["ADRESSE"], $contenu);
    $contenu = str_replace("{(COMP_ADRESSE)}", $devis["COMP_ADRESSE"], $contenu);
    $contenu = str_replace("{(CP)}", $devis["CP"], $contenu);
    $contenu = str_replace("{(VILLE)}", $devis["VILLE"], $contenu);
    $contenu = str_replace("{(PAYS)}", $devis["PAYS"], $contenu);

    //DONNES OBJET
    $objet = str_replace("{(DATE_VISITE)}", $devis["DATE_VISITE"], $objet);
    $objet = str_replace("{(HEURE_VISITE)}", $devis["HEURE_VISITE"], $objet);
    $objet = str_replace("{(PMR)}", $devis["PMR"], $objet);
    $objet = str_replace("{(TLF_RESP)}", $devis["TLF_RESP"], $objet);
    $objet = str_replace("{(MAIL_RESP)}", $devis["MAIL_RESP"], $objet);

    //DONNES RÈGLEMENT
    $reglement = str_replace("{(MODE)}", $devis["MODE"], $reglement);
    $reglement = str_replace("{(NoDEVIS)}", $devis["NoDEVIS"], $reglement);

    $contenuconcat = $header . $contenu . $objet . $debuttable;

    for ($i = 0; $i < 10; $i++) {
        $classe = ($i % 2 == 0) ? "ligne-paire" : "ligne-impaire";
        $ligne = str_replace("{(CODE)}", $i, $lignes);
        $ligne = str_replace("{(CLASS)}", $classe, $ligne); 
        $contenuconcat .= $ligne;
    }

    $contenuconcattotal = $contenuconcat . $fintable . $taux . $reglement . $bonaccord . $footer;
    $contenuconcatpage2 = $header . $contenu2 . $footer;

    try {
        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        $html2pdf->writeHTML($contenuconcattotal);
        $html2pdf->writeHTML($contenuconcatpage2);
        $html2pdf->output("devis_$numDevis.pdf");
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Le fichier JSON n'existe pas.";
}
?>
