<?php
session_start();
require_once("./inc/functionSql.php");
require_once("./config.php");
require_once("./inc/functionAllg.php");

if (!isset($_SESSION['fehler'])) {
    $_SESSION['fehler'] = "";
}

if (isset($_SESSION[$suser])) {
    $no[4] = 'li_none'; // Registrierungslink verstecken
    $no[5] = 'li_none'; // Loginlink verstecken
    if (trim($_SESSION[$suser]['rechte']) != 'admin') {
        $no[6] = 'li_none';
        $no[7] = 'li_none';
        $no[2] = 'li_none'; // Bestelllog verstecken
    }
} else {
    $no[6] = 'li_none'; // Produkte hinzufügen verstecken
    $no[7] = 'li_none'; // Produkte bearbeiten verstecken
    $no[3] = 'li_none'; // Profil verstecken
    $no[8] = 'li_none'; // Warenkorb verstecken
    $no[2] = 'li_none'; // Bestelllog verstecken
    header("Location:./login.php");
    exit;
}
$ac[7] = 'active';

$r = array_merge($_GET, $_POST);

// Löschen
if (isset($r['del'])) {
    $id = $r['del'];
    $sql = "DELETE FROM {$config['prefix']}shop WHERE id=$id";
    $result = setSql($sql, $config, "003");
    if ($result != 1) {
        $_SESSION["fehler"] = "Daten nicht gelöscht";
        echo "Fehler beim Löschen";
    } else {
        $_SESSION["fehler"] = "Daten gelöscht";
    }
    header('Location: ./prod_liste.php');
    exit;
}



// Daten aus der Datenbank abrufen
$sql = "SELECT id, name, beschreibung, bild, preis, kategorie_id FROM {$config['prefix']}shop";
$ausgabe = prep_getSQL($sql, [], $config, "002");

// HTML-Code für die Tabelle erstellen
$tableRows = '';
foreach ($ausgabe as $key) {
    $bildHTML = '<img src="./uploads/' . $key['bild'] . '" width="100" >';
    $deleteLink = '<a href="prod_liste.php?del=' . $key['id'] . '" onclick="return confirm(\'Wirklich löschen?\')">&#128465;</a>';
    $editLink = '<a href="prod_erfassen.php?edit=' . $key['id'] . '">&#9998;</a>';

    $tableRows .= '<tr>';
    $tableRows .= '<td>' . $key['id'] . '</td>';
    $tableRows .= '<td>' . $key['name'] . '</td>';
    $tableRows .= '<td>' . $key['beschreibung'] . '</td>';
    $tableRows .= '<td>' . $bildHTML . '</td>';
    $tableRows .= '<td>' . $key['preis'] . '</td>';
    $tableRows .= '<td>' . $key['kategorie_id'] . '</td>';
    $tableRows .= '<td>' . $deleteLink . '</td>';
    $tableRows .= '<td>' . $editLink . '</td>';
    $tableRows .= '</tr>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifestyle Shop - Artikelliste</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        } */
    </style>
</head>

<body>
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <div class="container">
        <h1>Artikelliste</h1>
        <div id="fehler">
            <?php
            if (isset($_SESSION["fehler"])) {
                echo $_SESSION["fehler"];
                $_SESSION["fehler"] = "";
            }
            ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Beschreibung</th>
                    <th>Bild</th>
                    <th>Preis</th>
                    <th>Kategorie</th>
                    <th>Löschen</th>
                    <th>Bearbeiten</th>
                </tr>
            </thead>
            <tbody>
                <?= $tableRows ?>
            </tbody>
        </table>
        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>