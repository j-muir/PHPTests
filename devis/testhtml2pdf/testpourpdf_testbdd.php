<?php

require_once "connection/connection.php";
require __DIR__ . '/../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

// Función para reemplazar variables en plantillas
function remplacerVariables(string $template, array $variables): string {
    return str_replace(array_keys($variables), array_values($variables), $template);
}

// Obtener el número de devis desde POST
$numDevis = $_POST['numDevis'] ?? null;
if (!$numDevis) {
    die("Numéro de devis non fourni.");
}

// Consulta a la base de datos
$stmt = $pdo->prepare("SELECT * FROM devis_contact WHERE id = :numDevis");
$stmt->execute(['numDevis' => $numDevis]);
$devis = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$devis) {
    die("Numéro de devis introuvable.");
}

$pmrOptions = [
    0 => "Sans",
    1 => "Avec"
];

// Obtener el valor de pmr y convertirlo
$pmr = isset($devis["pmr"]) ? $pmrOptions[$devis["pmr"]] : "Inconnu"; // "Inconnu" si no está presente

$modePaymentOptions = [
    1 => "Virement",  // Si es 1, muestra "Virement"
];

$mode_payment = isset($devis["mode_payment"]) && isset($modePaymentOptions[$devis["mode_payment"]]) ? $modePaymentOptions[$devis["mode_payment"]] : "Autre"; // "Autre" si no está presente o no tiene el valor 1

// Preparar todas las variables para reemplazo
$remplacements = [
    "{(NoDEVIS)}" => $devis["id"] ?? '',
    "{(DATE)}" => $devis["date_devis"] ?? '',
    "{(NOM_GROUPE)}" => $devis["nom_groupe"] ?? '',
    "{(NOM_RESPONSABLE)}" => $devis["nom_responsable"] ?? '',
    "{(ADRESSE)}" => $devis["adresse"] ?? '',
    "{(COMP_ADRESSE)}" => $devis["comp_adresse"] ?? '',
    "{(CP)}" => $devis["code_postal"] ?? '',
    "{(VILLE)}" => $devis["ville"] ?? '',
    "{(PAYS)}" => $devis["pays"] ?? '',
    "{(DATE_VISITE)}" => $devis["date_visite"] ?? '',
    "{(HEURE_VISITE)}" => $devis["heure_visite"] ?? '',
    "{(PMR)}" => $pmr,
    "{(TLF_RESP)}" => $devis["tlf_resp"] ?? '',
    "{(MAIL_RESP)}" => $devis["mail_resp"] ?? '',
    "{(MODE)}" => $mode_payment,
];

// Generar datos QR
$qrData = [
    $devis["id"] ?? '',
    $devis["nom_groupe"] ?? '',
    $devis["nom_responsable"] ?? '',
    $devis["date_visite"] ?? '',
    $devis["heure_visite"] ?? '',
    $devis["pmr"] ?? '',
    $devis["tlf_resp"] ?? '',
    $devis["mail_resp"] ?? ''
];
$qrDataString = implode(" | ", array_map('trim', $qrData));
$remplacements["{(QRDATA)}"] = $qrDataString;

// Cargar plantillas
$header     = remplacerVariables(file_get_contents("header.txt"), $remplacements);
$footer     = remplacerVariables(file_get_contents("footer.txt"), $remplacements);
$objet      = remplacerVariables(file_get_contents("objet.txt"), $remplacements);
$debuttable = remplacerVariables(file_get_contents("debuttable.txt"), $remplacements);
$lignes     = file_get_contents("Lignes.txt");
$fintable   = remplacerVariables(file_get_contents("fintable.txt"), $remplacements);
$taux       = remplacerVariables(file_get_contents("taux.txt"), $remplacements);
$reglement  = remplacerVariables(file_get_contents("reglement.txt"), $remplacements);
$bonaccord  = remplacerVariables(file_get_contents("bonaccord.txt"), $remplacements);
$contenu    = remplacerVariables(file_get_contents("lesdevis.txt"), $remplacements);
$contenu2   = remplacerVariables(file_get_contents("lesdevis2.txt"), $remplacements);

// Recuperar productos desde la tabla boutique
$stmtProduits = $pdo->query("SELECT id_codeproduit, nom_produit, prix_ht FROM boutique");
$produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

// Generar tabla dinámica con datos reales y cantidad fija
$tableRows = '';
$qte = 5;

foreach ($produits as $index => $produit) {
    $classe = ($index % 2 === 0) ? "ligne-paire" : "ligne-impaire";

    $code = htmlspecialchars($produit['id_codeproduit']);
    $description = htmlspecialchars($produit['nom_produit']);
    $puht = number_format((float)$produit['prix_ht'], 2, ',', ' ');
    $mtht = number_format($produit['prix_ht'] * $qte, 2, ',', ' ');

    $ligne = str_replace(
        ["{(CLASS)}", "{(CODE)}", "{(DESCRIPTION)}", "{(QTE)}", "{(PUHT)}", "{(MTHT)}"],
        [$classe, $code, $description, $qte, $puht, $mtht],
        $lignes
    );

    $tableRows .= $ligne;
}

// Concatenar contenido para PDF
$page1 = $header . $contenu . $objet . $debuttable . $tableRows . $fintable . $taux . $reglement . $bonaccord . $footer;
$page2 = $header . $contenu2 . $footer;

// Generar PDF con Html2Pdf
try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->writeHTML($page1);
    $html2pdf->writeHTML($page2);
    $html2pdf->output("devis_$numDevis.pdf");
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
