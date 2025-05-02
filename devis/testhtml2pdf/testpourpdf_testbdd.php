<?php

require_once "connection/connection.php";
require __DIR__ . '/../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

// Función para reemplazar variables en plantillas
function remplacerVariables(string $template, array $variables): string {
    return str_replace(array_keys($variables), array_values($variables), $template);
}

// Obtener el número de devis desde POST desde index.php
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

// Conversión de valores para PMR y Mode_Payment
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

// Recuperar productos y datos del presupuesto desde las tablas boutique (b) y devis_lignes (d). Se realiza un INNER JOIN entre devis_lignes y boutique para obtener la información detallada del producto a partir del código. Luego filtra las líneas del presupuesto para obtener solo las que pertenecen al presupuesto específico cuyo ID se pasa como parámetro (:devis_id).
    $stmtLignes = $pdo->prepare("
    SELECT b.id_codeproduit, b.nom_produit, b.prix_ht, b.tva, dl.quantite 
    FROM devis_lignes dl
    JOIN boutique b ON dl.code_produit = b.id_codeproduit
    WHERE dl.devis_id = :devis_id
    ");
    $stmtLignes->execute(['devis_id' => $numDevis]);
    $produits = $stmtLignes->fetchAll(PDO::FETCH_ASSOC);

// Inicializar variables para calcular totales
    $subtotalHT = 0;
    
    $totalsTTC = [
        5 => 0,
        10 => 0,
        20 => 0
    ];

    $totalsTva = [
        5 => 0,
        10 => 0,
        20 => 0
    ];

// Declaración de variable para obtener los datos del html y poder generar las líneas.
    $lignes = file_get_contents("Lignes.txt");

// Generar tabla dinámica con datos recuperados de la query stmtLignes
    $tableRows = '';
    foreach ($produits as $index => $produit) {
        $classe = ($index % 2 === 0) ? "ligne-paire" : "ligne-impaire"; // Asigna una clase css diferente a cada linea, según si es par o impar.
        $code = htmlspecialchars($produit['id_codeproduit']);
        $description = htmlspecialchars($produit['nom_produit']);
        $qte = (int)$produit['quantite']; // int asegura que los datos sean pasados como un entero.
        $puht = number_format((float)$produit['prix_ht'], 2, ',', ' '); // float asegura que los datos sean pasados con décimales. Formatea el número al formato europeo, usando una coma para separar y no un punto.
        $mthtRaw = $produit['prix_ht'] * $qte; // Calculo del monto total sin impuestos.
        $mtht = number_format($mthtRaw, 2, ',', ' ');
        $subtotalHT += $mthtRaw;
        
    // Calcular el total con impuestos según el tipo de IVA
        $tauxTva = $produit['tva'];
        switch ($tauxTva) {
            case 5:
                $mttc = $mthtRaw * 1.05;  // Aplica el 5% de IVA
                $totalsTTC[5] += $mttc;
                break;
            case 10:
                $mttc = $mthtRaw * 1.10;  // Aplica el 10% de IVA
                $totalsTTC[10] += $mttc;
                break;
            case 20:
                $mttc = $mthtRaw * 1.20;  // Aplica el 20% de IVA
                $totalsTTC[20] += $mttc;
                $totalsTva[20] += ($mttc - $mthtRaw);  // Calcula el IVA (diferencia entre TTC y HT) para el 20%
                break;
            default:
                // Si no es ninguno de los tipos válidos de IVA, no hacer nada
                break;
        }

    $ligne = str_replace(
    ["{(CLASS)}", "{(CODE)}", "{(DESCRIPTION)}", "{(QTE)}", "{(PUHT)}", "{(MTHT)}"],
    [$classe, $code, $description, $qte, $puht, $mtht],
    $lignes
    );

    $tableRows .= $ligne; // Cada linea generada se añade a $tablerows. Esto se utilizará luego para la concatenación de contenido.
}

// Calcular acompte (40% del total TTC) y reste à payer
    $stotalTTC = array_sum($totalsTTC);
    $acompte = $stotalTTC * 0.40;
    $reste = $stotalTTC - $acompte;

// Preparar todas las variables para reemplazo (placeholders)
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
    "{(STOTALHT)}" => number_format($subtotalHT, 2, ',', ' '),
    "{(TX20HT)}" => number_format($totalsTTC[20] - $totalsTva[20], 2, ',', ' '),
    "{(TX10TVA)}" => number_format($totalsTTC[10] - $totalsTva[10], 2, ',', ' '),
    "{(TX5TVA)}" => number_format($totalsTTC[5] - $totalsTva[5], 2, ',', ' '),
    "{(TX20TVA)}" => number_format($totalsTva[20], 2, ',', ' '),
    "{(TX10HT)}" => number_format($totalsTTC[10], 2, ',', ' '), 
    "{(TX5HT)}" => number_format($totalsTTC[5], 2, ',', ' '),
    "{(STOTALTTC)}" => number_format(array_sum($totalsTTC), 2, ',', ' ') ,
    "{(ACOMPTE)}" => number_format($acompte, 2, ',', ' '),
    "{(RESTEPAYER)}" => number_format($reste, 2, ',', ' ')
];

// Generar datos para QR
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

// Cargar plantillas usando la función declarada al principio, y reemplaza los placeholders en las plantillas por datos de la bdd.
$header     = remplacerVariables(file_get_contents("header.txt"), $remplacements);
$footer     = remplacerVariables(file_get_contents("footer.txt"), $remplacements);
$objet      = remplacerVariables(file_get_contents("objet.txt"), $remplacements);
$debuttable = remplacerVariables(file_get_contents("debuttable.txt"), $remplacements);
$fintable   = remplacerVariables(file_get_contents("fintable.txt"), $remplacements);
$taux       = remplacerVariables(file_get_contents("taux.txt"), $remplacements);
$reglement  = remplacerVariables(file_get_contents("reglement.txt"), $remplacements);
$bonaccord  = remplacerVariables(file_get_contents("bonaccord.txt"), $remplacements);
$contenu    = remplacerVariables(file_get_contents("lesdevis.txt"), $remplacements);
$contenu2   = remplacerVariables(file_get_contents("lesdevis2.txt"), $remplacements);

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
