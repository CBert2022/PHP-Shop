<?php

/**
 * getSql liefert Daten aus einer DB
 * $config erfolderlich (mit dbname, dbuser &dbpasswort))
 *
 * @param string $sql
 * @param array $c
 * @param string $fehlerNr
 * @return array
 */

// DATEN AUSGEBEN
function getSql($sql, $c, $fehlerNr,) // config übergeben als $c
{
    try {
        // Mit DB verbinden (host, nutzer, passwort)
        $db = new PDO("mysql:host=localhost;dbname=" . $c['dbname'], $c['dbuser'], $c['dbpasswort']);
        // testen ob verbindung steht
        $response = $db->query($sql); // Gibt Objekt zurück | query nur denn daten zurückgegeben werden
        //print_r($response);
        // nimm alles
        $arr = $response->fetchAll(PDO::FETCH_ASSOC); // fetchAll() baut aus Daten ein Array
        // Datenbank schließen
        $db = null;
        //print_r($arr);
        return $arr;
    } catch (PDOException $e) {
        $_SESSION["fehler"] .=   $e->getMessage();
        $_SESSION["fehler"] .= "Fehler $fehlerNr";

        return [-1];
    }
}

/**
 * setSql ändert die Tabelle
 * update,delete,insert into
 *
 * @param string $sql
 * @param array $c
 * @param string $fehlerNr
 * @return int
 */
// DATEN EINGEBEN/ BEARBEITEN
function setSql($sql, $c, $fehlerNr)
{
    try {
        $db = new PDO("mysql:host=localhost;dbname=" . $c['dbname'], $c['dbuser'], $c['dbpasswort']);
        $response = $db->exec($sql); // Gibt Objekt zurück 
        // Datenbank schließen
        $db = null;
        return $response;
    } catch (PDOException $e) {
        $_SESSION["fehler"] .=   $e->getMessage();
        $_SESSION["fehler"] .= "Fehler $fehlerNr";
        return -1;
    }
}

// session_start();
// Prepared Statement = höhere Sicherheit
function prep_setSql($sql, $daten, $c, $fehlerNr)
{
    try {
        $db = new PDO("mysql:host=localhost;dbname=" . $c['dbname'], $c['dbuser'], $c['dbpasswort']);
        $stat = $db->prepare($sql); // Gibt Objekt zurück 
        $r = $stat->execute($daten);
        // Datenbank schließen
        $db = null;
        return $r;
    } catch (PDOException $e) {
        $_SESSION["fehler"] .=   $e->getMessage();
        $_SESSION["fehler"] .= "Fehler $fehlerNr";
        return -1;
    }
}


// $_SESSION['fehler'] = "";
// // : als Platzhalter
// $sql = "INSERT INTO test_user values(null,:na,:vo,:ort)";
// $daten = ['na' => 'Klose', 'vo' => 'Karl', 'ort' => 'Berlin'];
// $r = prep_setSql($sql, $daten, $config, "001");
// echo $r . "-" . $_SESSION['fehler'];



function prep_getSQL($sql, $daten, $c, $fnr)
{
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=" . $c['dbname'], $c['dbuser'], $c['dbpasswort']);
        $stat = $dbh->prepare($sql);
        $stat->execute($daten);
        $arr = $stat->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        return $arr;
    } catch (PDOException $e) {
        $_SESSION["fehler"] .= $e->getMessage();
        $_SESSION["fehler"] .= "Fehler: $fnr";
        return [-1];
    }
}

// $sql = "SELECT * FROM test_user WHERE id=:id1";
// $daten = ['id1' => '2'];
// $ds = prep_getSql($sql, $daten, $config, "002");
// print_r($ds);
