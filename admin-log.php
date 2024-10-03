<?php
session_start();

// // Überprüfen, ob der Benutzer Admin-Rechte hat
// if (!isset($_SESSION[$suser]) || $_SESSION[$suser]['rechte'] != 'admin') {
//     header('Location: login.php');
//     exit;
// }


require_once("./inc/functionSql.php");
require_once("./config.php");
if (!isset($_SESSION['fehler'])) {
    $_SESSION['fehler'] = "";
}

if (isset($_SESSION[$suser])) {
    $no[4] = 'li_none'; // Registrierungslink verstecken
    $no[5] = 'li_none'; // Loginlink verstecken
    if (trim($_SESSION[$suser]['rechte']) != 'admin') {
        $no[6] = 'li_none';
        $no[7] = 'li_none';
    }
} else {
    $no[6] = 'li_none'; // Produkte hinzufügen verstecken
    $no[7] = 'li_none'; // Produkte bearbeiten verstecken
    $no[2] = 'li_none'; // Bestelllog verstecken
    $no[3] = 'li_none'; // Profil verstecken
    $no[8] = 'li_none'; // Warenkorb verstecken
    header("Location:./login.php");
    exit;
}

// Log-Datei laden
$logDatei = 'order_log.log';
$logs = [];

if (file_exists($logDatei)) {
    // Log-Datei Zeile für Zeile einlesen
    $logs = file($logDatei, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bestell-Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <div class="container">
        <h1>Lifestyleshop - Bestell-Logs</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Level</th>
                    <th>Info</th>
                    <th>Nachricht</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <?php
                        // Jede Zeile splitten, um die Log-Komponenten zu erhalten
                        $logDetails = explode('|', $log);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($logDetails[0]) ?></td> <!-- Datum -->
                            <td><?= htmlspecialchars($logDetails[1]) ?></td> <!-- Level -->
                            <td><?= htmlspecialchars($logDetails[2]) ?></td> <!-- Info -->
                            <td><?= htmlspecialchars($logDetails[3]) ?></td> <!-- Nachricht -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Keine Logs vorhanden.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="container">

        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>