<?php
session_start();
require_once("./config.php");
require_once("./inc/functionSql.php");

$ac[0] = 'active';
if (!isset($_SESSION['fehler'])) {
    $_SESSION['fehler'] = "";
}
if (isset($_SESSION[$suser])) {
    $no[4] = 'li_none'; // Registrierungslink verstecken
    $no[5] = 'li_none'; // Loginlink verstecken
    if (trim($_SESSION[$suser]['rechte']) != 'admin') {
        $no[6] = 'li_none'; // Produkte hinzufügen
        $no[7] = 'li_none'; // Produkte bearbeiten
        $no[2] = 'li_none'; // Bestelllog verstecken
    }
} else {
    $no[6] = 'li_none'; // Produkte hinzufügen verstecken
    $no[7] = 'li_none'; // Produkte bearbeiten verstecken
    $no[3] = 'li_none'; // Profil verstecken
    $no[8] = 'li_none'; // Warenkorb verstecken
    $no[2] = 'li_none'; // Bestelllog verstecken
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Lifestyle Shop - Bestellbestätigung</title>
</head>

<body> <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <div class="container">

        <h1>Vielen Dank für deine Bestellung</h1>
        <p>
            Du hast eine Mail als Bestellbestätigung erhalten.

            Sobald die Rechnung per Vorkasse gezahlt wurde, versenden wir die Produkte 😀.
        </p>
    </div>

    <div class="container">

        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>