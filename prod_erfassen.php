<?php
session_start();
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
        $no[2] = 'li_none'; // Bestelllog verstecken
    }
} else {
    $no[6] = 'li_none'; // Produkte hinzufügen verstecken
    $no[7] = 'li_none'; // Produkte bearbeiten verstecken
    $no[3] = 'li_none'; // Profil verstecken
    $no[2] = 'li_none'; // Bestelllog verstecken
    $no[8] = 'li_none'; // Warenkorb verstecken
    header("Location:./login.php");
    exit;
}
$ac[6] = 'active';
$r = array_merge($_GET, $_POST);
$btnName = "submit";
$name = "";
$beschreibung = "";
$preis = "";

//Editieren
// 1. Erfassung des zu bearbeitenden DS
if (isset($_GET["edit"])) {

    // id die editiert wird, übergeben durch Blick auf edit in Ausgabe
    $id = intval($_GET["edit"]);
    $sql = "SELECT * FROM {$config['prefix']}shop  WHERE id=$id";
    $dsArr = getSql($sql, $config, "007");
    // print_r($dsArr);
    // Elemente den Datensatz Array dimention 1 = DS, Dimesion 2 Inhalte 
    $name = $dsArr[0]['name'];
    $beschreibung = $dsArr[0]['beschreibung'];
    $bild = $dsArr[0]['bild'];
    $preis = $dsArr[0]['preis'];
    $kategorie_id = $dsArr[0]['kategorie_id'];

    // -> im Input wird der Value PHP-Tag angezeigt, den wir hier definiert haben

    $btnName = "Editieren";
}

// 2. Übermitteln des editierten DS anhand id
if (isset($r["Editieren"])) {
    $idDS = intval($r["edit"]); // Id des Datensatzes

    // Daten aus Input auslesen 
    $r['name'] = htmlentities($r['name']);
    $r['beschreibung'] = htmlentities($r['beschreibung']);
    $r['preis'] = floatval(str_replace(",", ".", $r['preis']));  // Kommas durch Punkte ersetzen und in Gleitkommazahl umwandeln
    $r['kategorie_id'] = intval($r['kategorie_id']);

    // Datei-Upload-Verarbeitung
    if (isset($_FILES['bild']) && $_FILES['bild']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['bild']['name'], PATHINFO_EXTENSION);
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
            $bildnameneu = uniqid() . '.' . $ext;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $bildnameneu;

            // Verzeichnis erstellen, falls es nicht existiert
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['bild']['tmp_name'], $dest_path)) {
                // Neues Bild hochgeladen, aktualisiere den Bildnamen
                $r['bild'] = $bildnameneu;

                // Lösche das alte Bild, falls es existiert und nicht leer ist
                if (!empty($bild) && file_exists('./uploads/' . $bild)) {
                    unlink('./uploads/' . $bild);
                }
            } else {
                $_SESSION["fehler"] = "Fehler beim Hochladen der Datei.";
            }
        } else {
            $_SESSION["fehler"] = "Ungültiger Dateityp. Bitte laden Sie ein Bild im GIF-, JPEG- oder PNG-Format hoch.";
        }
    } else {
        // Kein neues Bild hochgeladen, behalte das vorhandene Bild bei
        $r['bild'] = $bild;
    }

    // Update-Statement vorbereiten
    $sql = "UPDATE {$config['prefix']}shop SET name='{$r['name']}', beschreibung='{$r['beschreibung']}', preis={$r['preis']}, kategorie_id={$r['kategorie_id']}";

    // Nur wenn ein neues Bild hochgeladen wurde, füge das Bild in das Update-Statement ein
    if (isset($r['bild'])) {
        $sql .= ", bild='{$r['bild']}'";
    }

    $sql .= " WHERE id={$idDS}";

    $r = setSql($sql, $config, "007");

    if ($r == 1) {
        $_SESSION["fehler"] .= "<br>Daten geändert";
    } else {
        $_SESSION["fehler"] .= "<br>Daten nicht geändert";
    }

    header('Location:./prod_liste.php');
    exit; // verlasse den Vorgang, lösche hashparameter um realod und doppelten Eintrag zu verhindern
}

if (isset($r['submit'])) {
    $r['name'] = htmlentities($r['name']);
    $r['beschreibung'] = htmlentities($r['beschreibung']);
    $r['preis'] = floatval(str_replace(",", ".", $r['preis']));  // Kommas durch Punkte ersetzen und in Gleitkommazahl umwandeln
    $r['kategorie_id'] = intval($r['kategorie_id']);


    // Datei-Upload-Verarbeitung
    if (isset($_FILES['bild']) && $_FILES['bild']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['bild']['name'], PATHINFO_EXTENSION);
        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
            $bildnameneu = uniqid() . '.' . $ext;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $bildnameneu;

            // Verzeichnis erstellen, falls es nicht existiert
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['bild']['tmp_name'], $dest_path)) {
                $r['bild'] = $bildnameneu;
            } else {
                $_SESSION["fehler"] = "Fehler beim Hochladen der Datei.";
            }
        } else {
            $_SESSION["fehler"] = "Ungültiger Dateityp. Bitte laden Sie ein Bild im GIF-, JPEG- oder PNG-Format hoch.";
        }
    } else {
        $_SESSION["fehler"] = "Es wurde keine Datei hochgeladen oder ein Fehler ist aufgetreten.";
    }
    // print_r($r);
    // Datenbank-Operation, nur wenn keine Fehler aufgetreten sind
    if (empty($_SESSION["fehler"])) {
        $sql = "INSERT INTO {$config['prefix']}shop  VALUES (null, :name, :beschreibung, :bild,:preis,:kategorie_id)";
        unset($r['submit']);
        $daten = prep_setSql($sql, $r, $config, "001");

        if (!$daten) {
            $_SESSION["fehler"] = "Daten nicht geschrieben.";
        } else {
            $_SESSION["fehler"] = "Daten erfolgreich geschrieben.";
        }
    }

    header('Location: ./prod_liste.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <title>Lifestyle Shop - Produkt Erfassung</title>
</head>

<body>
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <div class="container">


        <h1>Artikel erfassen</h1>
        <div id="fehler">
            <?php
            if (isset($_SESSION["fehler"])) {
                echo $_SESSION["fehler"];
                $_SESSION["fehler"] = "";
            }
            ?>
        </div>
        <!-- enctype attribut nötig für datei upload -->
        <form class="form" method="post" enctype="multipart/form-data">
            <div class=" mb-3 row">
                <label for="name" class="form-label col-sm-4">Artikelname:</label>
                <div class="col-sm-8">
                    <input type="text" id="name" name="name" class="form-control" value="<?= $name ?>" />
                </div>
            </div>
            <div class=" mb-3 row">
                <label for="beschreibung" class="form-label col-sm-4">Beschreibung:</label>
                <div class="col-sm-8">
                    <input type="text" id="beschreibung" name="beschreibung" class="form-control" value="<?= $beschreibung ?>" />
                </div>
            </div>
            <div class=" mb-3 row">
                <label for="preis" class="form-label col-sm-4">Preis:</label>
                <div class="col-sm-8">
                    <input type="text" name="preis" id="preis" class="form-control" value="<?= $preis ?>">
                </div>
            </div>
            <div class=" mb-3 row">
                <label for="kategorie_id" class="form-label col-sm-4">Kategorie:</label>
                <div class="col-sm-8">
                    <input type="number" name="kategorie_id" id="kategorie_id" class="form-control" value="<?= $kategorie_id ?>">
                </div>
            </div>
            <div class=" mb-3 row">
                <label for="bild" class="form-label col-sm-4">Bild:</label>
                <div class="col-sm-8">
                    <input type="file" name="bild" id="bild" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png" value="<?= $bild ?>">
                </div>
            </div>
            <button class="btn btn-primary" name="<?= $btnName  ?>" id="submit"><?= $btnName  ?></button>
        </form>
        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>