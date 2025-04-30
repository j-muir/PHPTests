<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générer Devis PDF</title>
</head>
<body>
    <h2>Générer un devis en PDF</h2>
    <form action="testpourpdf_testbdd.php" method="POST">
        <label for="numDevis">Numéro de Devis :</label>
        <input type="text" id="numDevis" name="numDevis" required>
        <button type="submit">Générer PDF</button>
    </form>
</body>
</html>