<?php
session_start();

require_once("./inc/functionSql.php");
require_once("./config.php");
require_once("./inc/functionAllg.php");

$ac[1] = 'active';

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

// Leg Session-Variable für Fehlermeldungen an, wenn sie noch nicht existiert
if (!isset($_SESSION['fehler'])) {
    $_SESSION['fehler'] = "";
}

// Leg Session-Variable für den Warenkorb an, wenn sie noch nicht existiert
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kombiniert GET & POST, um alle übermittelten Formulardaten in einem Array zu haben
$r = array_merge($_GET, $_POST);

// Daten aus der Datenbank abrufen
$sql = "SELECT id, name, beschreibung, bild, preis FROM {$config['prefix']}shop";
$ausgabe = prep_getSQL($sql, [], $config, "008");

// Auswahl der Kategorie
if (isset($r['yoga'])) {
    $sql = "SELECT id, name, beschreibung, bild, preis FROM {$config['prefix']}shop WHERE kategorie_id=3";
    $ausgabe = prep_getSQL($sql, [], $config, "008");
}
if (isset($r['damen'])) {
    $sql = "SELECT id, name, beschreibung, bild, preis FROM {$config['prefix']}shop WHERE kategorie_id=1";
    $ausgabe = prep_getSQL($sql, [], $config, "008");
}
if (isset($r['herren'])) {
    $sql = "SELECT id, name, beschreibung, bild, preis FROM {$config['prefix']}shop WHERE kategorie_id=2";
    $ausgabe = prep_getSQL($sql, [], $config, "008");
}

// HTML-Code für die Bootstrap Cards erstellen
$cardOutput = '';
foreach ($ausgabe as $key) {
    $bildHTML = '<img src="./uploads/' . $key['bild'] . '" class="card-img-top liste-img" alt="' . $key['name'] . '" >';

    $cardOutput .= '<div class="col-md-6 mb-4">';
    $cardOutput .= '<div class="card h-100">';
    $cardOutput .= $bildHTML;
    $cardOutput .= '<div class="card-body">';
    $cardOutput .= '<h5 class="card-title">' . $key['name'] . '</h5>';
    $cardOutput .= '<p class="card-text">' . $key['beschreibung'] . '</p>';
    $cardOutput .= '<p class="card-text"><strong>' . $key['preis'] . ' €</strong></p>';
    $cardOutput .= '</div>';
    $cardOutput .= '<div class="card-footer">';
    $cardOutput .= '<form method="post" class="d-flex addToCart">';
    $cardOutput .= '<input type="hidden" name="product_id" value="' . $key['id'] . '">';
    $cardOutput .= '<select class="form-control me-2" name="quantity">';
    $cardOutput .= '<option value="1">1</option>';
    $cardOutput .= '<option value="2">2</option>';
    $cardOutput .= '<option value="3">3</option>';
    $cardOutput .= '<option value="4">4</option>';
    $cardOutput .= '<option value="5">5</option>';
    $cardOutput .= '</select>';
    $cardOutput .= '<button class="btn btn-secondary" name="addToCart">In den Warenkorb</button>';
    $cardOutput .= '</form>';
    $cardOutput .= '</div>';
    $cardOutput .= '</div>';
    $cardOutput .= '</div>';
}

// Logik zum Hinzufügen in den Warenkorb
if (isset($r['addToCart'])) {
    if (! isset($_SESSION[$suser])) {
        header('Location: ./login.php');
        exit;
    }
    $product_id = intval($r['product_id']);
    $quantity = intval($r['quantity']);


    // Prüfen, ob die Produkt-ID bereits im Warenkorb vorhanden ist
    $artikelImCart = -1;
    foreach ($_SESSION['cart'] as $k => $v) {
        if ($v['id'] == $product_id) {
            $artikelImCart = $k;
            break;
        }
    }

    if ($artikelImCart == -1) {
        // Artikel noch nicht im Warenkorb, hinzufügen
        $_SESSION['cart'][] = ['id' => $product_id, 'quantity' => $quantity];
    } else {
        // Artikel bereits im Warenkorb, Menge aktualisieren
        $_SESSION['cart'][$artikelImCart]['quantity'] += $quantity;
    }
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
</head>

<body class="artikelliste">
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->

    <div class="container mt-4">

        <div class=" my-5">
            <p class="neon-text text-center">Wonach suchst du?</p>
            <div class=" d-flex justify-content-evenly">
                <form methoad="post" class="pt-3">
                    <button type="submit" name="yoga" class="btn btn-secondary ">Yoga</button>
                    <button type="submit" name="damen" class="btn btn-secondary ">Damen</button>
                    <button type="submit" name="herren" class="btn btn-secondary ">Herren</button>
                    <button type="submit" name="alles" class="btn btn-secondary ">Alles</button>
                </form>
            </div>
        </div>
        <div class="row">
            <?= $cardOutput ?>
        </div>
    </div>
    <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>