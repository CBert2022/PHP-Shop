<?php
session_start();
require_once("./config.php");
require_once("./inc/functionSql.php");
$ac[4] = 'active';
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
}

$r = array_merge($_GET, $_POST);
if (isset($r['save'])) {

  // Name
  if (!preg_match("/^[A-Za-z\- ]{2,50}$/", $r['name'])) {
    $_SESSION["fehler"] .= "<br>Ungültiger Name.";
  }

  // Vorname
  if (!preg_match("/^[A-Za-z\- ]{2,50}$/", $r['vorname'])) {
    $_SESSION["fehler"] .= "<br>Ungültiger Vorname.";
  }

  // PLZ (Postleitzahl)
  if (!preg_match("/^\d{5}$/", $r['plz'])) {
    $_SESSION["fehler"] .= "<br>Ungültige PLZ.";
  }

  // Ort
  if (!preg_match("/^[A-Za-z\- ]{2,50}$/", $r['ort'])) {
    $_SESSION["fehler"] .= "<br>Ungültiger Ort.";
  }

  // Straße
  if (!preg_match("/^[A-Za-z0-9\-äöüÄÖÜß ]{2,100}$/", $r['strasse'])) {
    $_SESSION["fehler"] .= "<br>Ungültige Straße.";
  }

  // Hausnummer
  if (!preg_match("/^[A-Za-z0-9]{1,10}$/", $r['nr'])) {
    $_SESSION["fehler"] .= "<br>Ungültige Hausnummer.";
  }

  // E-Mail
  if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $r['email'])) {
    $_SESSION["fehler"] .= "<br>Ungültige E-Mail-Adresse.";
  }

  // Telefon
  if (!preg_match("/^[\+]?[0-9\s]{5,20}$/", $r['tel'])) {
    $_SESSION["fehler"] .= "<br>Ungültige Telefonnummer.";
  }

  // Passwort (mindestens 8 Zeichen, mindestens eine Zahl)
  if (!preg_match("/(?=.*\d)(?=.*[a-z]).{8,}/", $r['pw'])) {
    $_SESSION["fehler"] .= "<br>Ungültiges Passwort.";
  }

  // Vor dem Speichern der Daten
  if ($_SESSION["fehler"] === "") {
    // E-Mail-Adresse prüfen
    $sql_check_email = "SELECT COUNT(*) FROM $config[prefix]user WHERE email = :email";
    $email_count = prep_getSQL($sql_check_email, ['email' => $r['email']], $config, "0002");

    if ($email_count[0]['COUNT(*)'] > 0) {
      $_SESSION["fehler"] .= "<br>E-Mail-Adresse ist bereits vergeben.";
    }
  }

  // Wenn keine Fehler vorhanden sind, speichern
  if ($_SESSION["fehler"] === "") {
    $r['name'] = htmlentities($r['name']);
    $r['vorname'] = htmlentities($r['vorname']);
    $r['plz'] = htmlentities($r['plz']);
    $r['ort'] = htmlentities($r['ort']);
    $r['strasse'] = htmlentities($r['strasse']);
    $r['nr'] = htmlentities($r['nr']);
    $r['email'] = htmlentities($r['email']);
    $r['tel'] = htmlentities($r['tel']);
    $passwordOk = mb_strlen($r['pw']) > 7;
    $r['pw'] = password_hash($config['salt'] . $r['pw'], PASSWORD_DEFAULT);
    if (mb_strlen($r['name']) > 2 && mb_strlen($r['vorname']) > 2 && $passwordOk) {
      $sql = "insert into $config[prefix]user values(null,:name,:vorname,:plz,:ort,:strasse,:nr,:email,:tel,:pw,'user')";
      // print_r($r);
      unset($r['save']);
      $f = prep_setSQL($sql, $r, $config, "0001");
      if (!$f) {
        $_SESSION["fehler"] .= "<br>Daten nicht geschr.";
      } else {
        $_SESSION["fehler"] .= "<br>Registireung erfolgreich, bitte melde dich an.";
      }
    } else {
      $_SESSION["fehler"] .= "<br>Daten nicht geschr.";
    }
    header("Location:./login.php");
    exit;
  }
}


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lifestyle Shop - Registrierung</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles.css">
</head>

<body>
  <?php
  require_once('./nav.php');
  ?>
  <div class="container">
    <main>
      <h1>Registrierung</h1>
      <div id="fehler">
        <?php
        if (isset($_SESSION["fehler"])) {
          echo $_SESSION["fehler"];
          $_SESSION["fehler"] = "";
        }
        ?>
      </div>
      <form action="" method="post">
        <div class=" mb-3 row">
          <label for="name" class="form-label col-sm-4">Name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z\- ]{2,50}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="vorname" class="form-label col-sm-4">Vorname</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="vorname" name="vorname" pattern="[A-Za-z\- ]{2,50}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="plz" class="form-label col-sm-4">PLZ</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="plz" name="plz" pattern="\d{5}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="ort" class="form-label col-sm-4">Ort</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="ort" name="ort" pattern="[A-Za-z\- ]{2,50}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="strasse" class="form-label col-sm-4">Strasse</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="strasse" name="strasse" pattern="[A-Za-z0-9\-äöüÄÖÜß ]{2,100}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="strasse" class="form-label col-sm-4">Hausnummer</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="nr" name="nr" pattern="[A-Za-z0-9]{1,10}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="email" class="form-label col-sm-4">E-Mail</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="tel" class="form-label col-sm-4">Telefon</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="tel" name="tel" pattern="[\+]?[0-9\s]+" minlength="5" maxlength="20" required />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="pw" class="form-label col-sm-4">Passwort</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="pw" name="pw" pattern="(?=.*\d)(?=.*[a-z]).{8,}" required />
          </div>
        </div>
        <button type="submit" id="save" name="save" class="btn btn-primary">
          speichern
        </button>
      </form>
    </main>
  </div>
  <div class="container">

    <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
</body>

</html>