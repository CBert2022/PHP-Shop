<?php
session_start();

require_once("./inc/functionSql.php");
require_once("./config.php");
require_once("./inc/functionAllg.php");
require_once("./inc/mail.php");
require_once('./inc/Glogger.php');

$ac[8] = 'active';

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
    $no[3] = 'li_none'; // Profil verstecken
    $no[8] = 'li_none'; // Warenkorb verstecken
    $no[2] = 'li_none'; // Bestelllog verstecken
}



// Glogger-Instanz erstellen
$log = new Glogger();
$log->setLogdatei('order_log.log'); // Log-Datei für Bestellungen setzen

$datBestellung = [];
$gesSumme = 0;
$tab = "";
$orderDetails = "";

// Warenkorb leeren
if (isset($_GET['emptyCart'])) {
    $_SESSION['cart'] = []; // Warenkorb als leeres Array setzen
    $_SESSION['fehler'] .= "Der Warenkorb wurde geleert.";
    header('Location: ./shop_cart.php');
    exit;
}

// Logik zum Entfernen eines Artikels aus dem Warenkorb
if (isset($_GET['removeFromCart'])) {
    $product_id = intval($_GET['removeFromCart']);

    // Artikel aus dem Warenkorb entfernen
    foreach ($_SESSION['cart'] as $k => $v) {
        if ($v['id'] == $product_id) {
            unset($_SESSION['cart'][$k]);
            $_SESSION['fehler'] .= "Produkt wurde aus dem Warenkorb entfernt.";
            break;
        }
    }

    // Weiterleitung zur Vermeidung von erneutem Absenden des Formulars
    header('Location: ./shop_cart.php');
    exit;
}

// Warenkorb nur ausgeben, wenn er Artikel beinhaltet
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    // Produkt-IDs aus dem Warenkorb sammeln
    $product_ids = array_column($_SESSION['cart'], 'id');
    $product_ids_str = implode(",", $product_ids);


    // Daten aus der Datenbank abrufen, basierend auf den Produkt-IDs im Warenkorb
    $sql = "SELECT id, name, bild, preis FROM {$config['prefix']}shop WHERE id IN ({$product_ids_str})";
    $product_data = prep_getSQL($sql, [], $config, "008");

    // Tabellen-HTML für den Warenkorb erstellen
    foreach ($_SESSION['cart'] as $cart_item) {
        foreach ($product_data as $key => $product) {
            if ($cart_item['id'] == $product['id']) {
                $product_name = $product['name'];
                $product_image = './uploads/' . $product['bild'];
                $product_price = $product['preis'];
                $product_quantity = $cart_item['quantity'];
                $product_total = $product_price * $product_quantity;
                $gesSumme += $product_total;

                // HTML für das Tabellen-Row erstellen
                $tab .= '<tr>';
                $tab .= '<td>' . $product_name . '</td>';
                $tab .= '<td><img src="' . $product_image . '" width="100"></td>';
                $tab .= '<td>' . $product_price . ' €</td>';
                $tab .= '<td>' . $product_quantity . '</td>';
                $tab .= '<td>' . $product_total . ' €</td>';
                $tab .= '<td><a href="shop_cart.php?removeFromCart=' . $product['id'] . '">Entfernen</a></td>';
                $tab .= '</tr>';
                break; // Wenn Produkt gefunden wurde, zur nächsten Produkt-ID im Warenkorb springen
            }
        }
    }
} else {
    // Warenkorb ist leer
    $tab = '<tr><td colspan="6">Warenkorb ist leer</td></tr>';
}

if (isset($_GET['emptyCart'])) {
}

// Bestellung verarbeiten
if (isset($_POST['checkout'])) {


    $user_id = $_SESSION[$suser]['id'];
    $total_amount = floatval($_POST['total_amount']);

    // Bestellung in die Datenbank einfügen
    $sql = "INSERT INTO {$config['prefix']}orders (user_id, total_amount, created_at) VALUES (:user_id, :total_amount, NOW())";
    $params = [
        ':user_id' => $user_id,
        ':total_amount' => $total_amount
    ];
    $daten = prep_setSQL($sql, $params, $config, "009");

    if (!$daten) {
        $_SESSION["fehler"] .= "Bestellung  nicht geschrieben.";
    } else {
        $_SESSION["fehler"] .= "Bestellung  erfolgreich geschrieben.";
        // Log-Eintrag bei erfolgreicher Bestellung erstellen
        $log->setMessage(3, 'Bestellung', "User ID: $user_id, Betrag: $total_amount €, Produkte: " . json_encode($_SESSION['cart']));




        // SQL-Abfrage, um die neueste Bestellung des Benutzers zu holen
        $sql = "SELECT id FROM {$config['prefix']}orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
        $params = [':user_id' => $user_id];
        $latest_order = prep_getSQL($sql, $params, $config, "011");

        if (!$latest_order) {
            $_SESSION["fehler"] .= "id nicht zugeordnet.";
        } else {
            $order_id = $latest_order[0]['id']; //Zuweisung des order_id
            $_SESSION["fehler"] .= "Id erfolgreich zugeordnet.";
        }

        // print_r($latest_order);

        // Hier Bestellposten in Datenbank einfügen, wenn die Bestellung erfolgreich war
        foreach ($_SESSION['cart'] as $cart_item) {
            $sql = "INSERT INTO {$config['prefix']}order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
            $params = [
                ':order_id' => $order_id,
                ':product_id' => $cart_item['id'],
                ':quantity' => $cart_item['quantity']
            ];
            // print_r($params);
            $produkte = prep_setSQL($sql, $params, $config, "010");
            if (!$produkte) {
                $_SESSION["fehler"] .= "Daten nicht geschrieben.";
            } else {
                $_SESSION["fehler"] .= "Daten geschrieben.";
            }

            // Bestätigungsmail versenden 

            $orderDetails = "Zahlung per Vorkasse.
            Bitte überweise die Gesamtbetrag von $total_amount an:
            Kontoinhaber: Lifestyle Shop
            IBAN: DE12 3456 7890 1234 5678 90
            BIC: FAKEDEFFXXX
            Bankname: Musterbank
            Bankleitzahl (BLZ): 12345678
            Kontonummer: 1234567890
            ";
            sendOrderConfirmation($_SESSION[$suser]['email'], $orderDetails);


            // Warenkorb leeren

            $_SESSION['cart'] = []; // Warenkorb als leeres Array setzen
            $_SESSION['fehler'] .= "Der Warenkorb wurde geleert.";
        }
        $_SESSION['fehler'] = [];
        header('Location: ./success.php');
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <title>Lifestyle Shop - Warenkorb</title>
</head>

<body>
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <div class="container">
        <h1>Warenkorb</h1>
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
                    <th>Name</th>
                    <th>Bild</th>
                    <th>Preis</th>
                    <th>Anzahl</th>
                    <th>Gesamtsumme</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?= $tab ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td><?= number_format($gesSumme, 2, ',', '.') ?> €</td>
                    <td>
                        <form><button name="emptyCart" class="btn btn-secondary">Warenkorb leeren</button>
                        </form>
                    </td>
                </tr>
            </tfoot>
        </table>
        <form method="POST" class="d-flex justify-content-center">
            <input type="hidden" name="user_id" value="<?= $_SESSION[$suser]['id'] ?>">
            <input type="hidden" name="total_amount" value="<?= $gesSumme ?>">
            <button id="checkout" name="checkout" class="btn btn-primary">Jetzt kaufen</button>
        </form>
        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>

</body>

</html>