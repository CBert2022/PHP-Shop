<?php
session_start();
require_once("./config.php");
require_once("./inc/functionSql.php");
header("Access-Control-Allow-Origin: http://localhost:8090"); // Ersetze 8080 durch deinen Port, falls nötig

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

// Daten aus der Datenbank abrufen für Yoga-Cards
$sql = "SELECT id, name, beschreibung, bild, preis 
        FROM {$config['prefix']}shop 
        WHERE kategorie_id = 3 
        ORDER BY RAND() 
        LIMIT 5";
$ausgabe = prep_getSQL($sql, [], $config, "008");
//print_r($ausgabe);

// Daten aus der Datenbank abrufen für Damen-Cards
$sql = "SELECT id, name, beschreibung, bild, preis 
        FROM {$config['prefix']}shop 
        WHERE kategorie_id = 1 
        ORDER BY RAND() 
        LIMIT 5";
$damen = prep_getSQL($sql, [], $config, "008");

// Daten aus der Datenbank abrufen für Herren-Cards
$sql = "SELECT id, name, beschreibung, bild, preis 
        FROM {$config['prefix']}shop 
        WHERE kategorie_id = 2 
        ORDER BY RAND() 
        LIMIT 5";
$herren = prep_getSQL($sql, [], $config, "008");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifestyle Shop</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php require './nav.php'; ?> <!-- Einfügen der Navigationsleiste -->
    <header class="header">
        <div class="container">
            <h1 class="neon-text">Willkommen im Lifestyle Shop</h1>
            <p>Entdecken Sie die neuesten Trends in Mode, Fitness und Lifestyle.</p>
            <a href="./shop_liste2.php" class="btn btn-secondary">Jetzt Einkaufen</a>
        </div>
    </header>
    <div class="container yoga">
        <div class="d-flex justify-content-center align-items-center ">
            <h1>Yoga Angebote</h1>
        </div>
        <div class="row  d-flex justify-content-evenly">
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">

                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $ausgabe[0]['bild'] ?>" width="100" alt="<?= $ausgabe[0]['name']  ?>">

                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $ausgabe[0]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $ausgabe[0]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>

            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $ausgabe[1]['bild'] ?>" width="100" alt="<?= $ausgabe[1]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $ausgabe[1]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis: <?= $ausgabe[1]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $ausgabe[2]['bild'] ?>" width="100" alt="<?= $ausgabe[2]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $ausgabe[2]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $ausgabe[2]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $ausgabe[3]['bild'] ?>" width="100" alt="<?= $ausgabe[3]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $ausgabe[3]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $ausgabe[3]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $ausgabe[4]['bild'] ?>" width="100" alt="<?= $ausgabe[4]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $ausgabe[4]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $ausgabe[4]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
        </div>
        <div class="d-flex pb-5">
            <a href="./shop_liste2.php?yoga" class="btn btn-secondary ">Entdecken</a>
        </div>

    </div>
    <div class="container damen">
        <div class="d-flex justify-content-center align-items-center ">
            <h1>Damen Angebote</h1>
        </div>
        <div class="row  d-flex justify-content-evenly">
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $damen[0]['bild'] ?>" width="100" alt="<?= $damen[0]['name']  ?>">

                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $damen[0]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $damen[0]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $damen[1]['bild'] ?>" width="100" alt="<?= $damen[1]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $damen[1]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis: <?= $damen[1]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $damen[2]['bild'] ?>" width="100" alt="<?= $damen[2]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $damen[2]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $damen[2]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $damen[3]['bild'] ?>" width="100" alt="<?= $damen[3]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $damen[3]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $damen[3]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $damen[4]['bild'] ?>" width="100" alt="<?= $damen[4]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $damen[4]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $damen[4]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>

        </div>
        <div class="d-flex pb-5">
            <a href="./shop_liste2.php?damen" class="btn btn-secondary ">Entdecken</a>
        </div>

    </div>
    <div class="container yoga">
        <div class="d-flex justify-content-center align-items-center ">
            <h1>Herren Angebote</h1>
        </div>
        <div class="row  d-flex justify-content-evenly">
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $herren[0]['bild'] ?>" width="100" alt="<?= $herren[0]['name']  ?>">

                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $herren[0]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $herren[0]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $herren[1]['bild'] ?>" width="100" alt="<?= $herren[1]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $herren[1]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis: <?= $herren[1]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $herren[2]['bild'] ?>" width="100" alt="<?= $herren[2]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $herren[2]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $herren[2]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $herren[3]['bild'] ?>" width="100" alt="<?= $herren[3]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $herren[3]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $herren[3]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="http://localhost/Projektarbeit/shop_liste2.php?yoga" class="card mb-5 shadow-lg">
                    <div class="imgBoot ">
                        <img class="card-img" src="./uploads/<?= $herren[4]['bild'] ?>" width="100" alt="<?= $herren[4]['name']  ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $herren[4]['name']  ?></h5>
                        <p class="card-text"></p>
                        <p class="card-text">Preis:<?= $herren[4]['preis']  ?> € </p>
                        <!-- <a href="#" class="btn btn-primary">Details</a> -->
                    </div>
                </a>
            </div>

        </div>
        <div class="d-flex pb-5">
            <a href="./shop_liste2.php?herren" class="btn btn-secondary ">Entdecken</a>
        </div>

    </div>

    <div class="container">

        <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
    </div>
    <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>