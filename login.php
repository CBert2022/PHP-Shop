<?php
session_start();
require_once("./config.php");
require_once("./inc/functionSql.php");
// require_once("./inc/Glogger.php");

$ac[5] = 'active';

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
  $no[2] = 'li_none'; // Bestelllog verstecken
  $no[8] = 'li_none'; // Warenkorb verstecken
  // header("Location:./login.php");
  // exit;
}

$email = "";
$pw = "";
if (!isset($_SESSION['fehler'])) {
  $_SESSION['fehler'] = "";
}
if (isset($_GET['logout'])) {
  //$log->setMessage(3, "user", "logout id=" . $_SESSION[$suser]['id']);
  unset($_SESSION[$suser]);
  header("Location:./index.php");
  exit;
}
if (isset($_SESSION[$suser])) {
  header("Location:./index.php");
  exit;
} else {
  $no[6] = 'li_none';
}

$r = array_merge($_GET, $_POST);
if (isset($r['login'])) {
  unset($r['login']);

  // E-Mail
  if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $r['email'])) {
    $_SESSION["fehler"] .= "<br>Ungültige E-Mail-Adresse.";
  }

  // Passwort (mindestens 8 Zeichen, mindestens eine Zahl)
  if (!preg_match("/(?=.*\d)(?=.*[a-z]).{8,}/", $r['pw'])) {
    $_SESSION["fehler"] .= "<br>Ungültiges Passwort.";
  }

  // Wenn keine Fehler vorhanden sind, speichern
  if ($_SESSION["fehler"] === "") {
    $r['email'] = htmlentities($r['email']);

    if (mb_strlen($r['email']) > 5 && mb_strlen($r['pw']) > 3) {
      $sql = "select * from $config[prefix]user where email=:email ";
      $pw = $r['pw'];
      unset($r['pw']);
      $daten = prep_getSQL($sql, $r, $config, "0002");
      if (count($daten) == 1) {
        if (password_verify($config['salt'] . $pw, $daten[0]['pw'])) {
          unset($daten[0]['pw']);
          $_SESSION[$suser] = $daten[0];

          header("Location:./index.php");
          exit;
        }
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lifestyle Shop - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles.css">
</head>

<body>
  <?php
  require_once('./nav.php');
  ?>
  <div class="container">
    <main>
      <h1>Login</h1>
      <div id="fehler">
        <?php
        if (isset($_SESSION["fehler"])) {
          echo $_SESSION["fehler"];
          $_SESSION["fehler"] = "";
        }
        ?>
      </div>
      <form method="post">
        <div class=" mb-3 row">
          <label for="email" class="form-label col-sm-4">E-Mail</label>
          <div class="col-sm-8">
            <input type="mail" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" />
          </div>
        </div>
        <div class=" mb-3 row">
          <label for="pw" class="form-label col-sm-4">Passwort</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="pw" name="pw" pattern="(?=.*\d)(?=.*[a-z]).{8,}" required />

          </div>
        </div>
        <button type="submit" id="login" name="login" class="btn btn-primary">
          Login
        </button>
      </form>
    </main>
  </div>
  <div class="container">

    <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
  </div>
  <script src="https://kit.fontawesome.com/85dc656ef6.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>