<?php

// zeigt Array in Tabelle an
function makeTab($daten, $tr)
{
    $tab1 = "";
    //print_r( $daten);
    for ($z = 0; $z < count($daten); $z++) {
        $tab1 .= "\t\t<tr>";
        $daten[$z] = trim($daten[$z]);
        $a = explode($tr, $daten[$z]);
        foreach ($a as $key => $value) {
            $tab1 .= "\n\t\t\t<td>" . $value . '</td>';
        }
        $tab1 .= "</tr>\n";
    };
    return $tab1;
};


// zeigt 2-dimensionale Arrays in Tabelle an
function makeTab2Dim($data)
{
    $tab1 = "";
    foreach ($data as $row) {
        $tab1 .= "\t\t<tr>";

        foreach ($row as $column) {

            $tab1 .= "\n\t\t\t<td>" . $column . '</td>';
        }
        $tab1 .= "</tr>\n";
    }
    return $tab1;
};

function linePlot($w, $h, $rand, $daten)
{

    $plot = "";
    $svg = "";

    // zu verfügung stehende Fläche / anzahl daten
    $abstandX = ($w - 2 * $rand) / count($daten);
    // zur verfügung stehende Fläche/ den größen Wert im Array
    // damit bleiben alle Werte innerhalt der vorgegebenen $w und $h
    $abstandY = 0;
    $verschiebenBeiMinusWerten = 0;

    if (min($daten) > 0) {
        $abstandY = ($h - 2 * $rand) / max($daten);
    } else {
        $abstandY = ($h - 2 * $rand) / (max($daten) - min($daten));
        $verschiebenBeiMinusWerten = min($daten);
    }

    //y-achse
    $plot .= "<line x1='" . ($rand) . "' y1='" . ($rand) . "' x2='" . ($rand) . "' y2='" . ($h - $rand) . "' stroke='black'/>";
    //y-achse anpassen wenn minus werte im array sind

    $y = $h - $rand + $verschiebenBeiMinusWerten * $abstandY;
    //pfeil y achse
    $plot .= "<line x1='" . ($rand) . "' y1='" . ($rand) . "' x2='" . ($rand - $rand / 15) . "' y2='" . ($rand + $rand / 15) . "' stroke='black'/>";
    $plot .= "<line x1='" . ($rand) . "' y1='" . ($rand) . "' x2='" . ($rand + $rand / 15) . "' y2='" . ($rand + $rand / 15) . "' stroke='black'/>";

    //x-achse
    $plot .= "<line x1='" . ($rand) . "' y1='" . ($y) . "' x2='" . ($w - $rand) . "' y2='" . ($y) . "' stroke='black'/>";

    //pfeil x achse
    $plot .= "<line x1='" . ($w - $rand) . "' y1='" . ($y) . "' x2='" . ($w - $rand - $rand / 15) . "' y2='" . ($y - $rand / 15) . "' stroke='black'/>";
    $plot .= "<line x1='" . ($w - $rand) . "' y1='" . ($y) . "' x2='" . ($w - $rand - $rand / 15) . "' y2='" . ($y + $rand / 15) . "' stroke='black'/>";

    // punkte
    for ($i = 0; $i < count($daten); $i++) {
        // $i startet bei 0 und wir d dann hochgezählt
        $cx = $rand + $i * $abstandX;
        $cy = $h - $rand - ($daten[$i] - $verschiebenBeiMinusWerten) * $abstandY;
        $plot .= "<circle cx='$cx' cy='$cy' r='2' stroke='blue' fill='blue'/>";


        // Wenn es nicht der letzte Punkt ist, zeichne eine Linie zum nächsten Punkt
        // sonst endet Line auf der x-achse
        if ($i < count($daten) - 1) {
            $cx2 = $rand + ($i + 1) * $abstandX;
            $cy2 = $h - $rand - ($daten[$i + 1] - $verschiebenBeiMinusWerten) * $abstandY;
            $plot .= "<line x1='$cx' x2='$cx2' y1='$cy' y2='$cy2' stroke='blue'/>";
            $plot .= "<text class='dia' x='$cx' y='$cy'>$daten[$i]</text>";
        }
    }

    $svg = "<svg id=\"p\" width=\"$w\" height=\"$h\" viewbox=\"0 0 $w $h\">$plot</svg>";
    return ($svg);
}

function getBilder($verzeichnis, $rekursiv, $datein = [])
{

    $h = opendir($verzeichnis);


    //Klassifizieren der Datein ob Verzeichnis oder Datei
    while ($name = readdir($h)) {
        //ergibt den ganzen Pfad
        $na = "$verzeichnis/" . $name;
        //liefert bool Datei:true/false
        if (is_file($na)) {
            //zeigt Dateiendung, z.B jpg und Ändert to lower case falls jmd PNG schreibt
            $ext = strtolower(pathinfo($na, PATHINFO_EXTENSION));
            // schließt hier test.txt aus, da falsche Endung
            if ($ext == "png" || $ext == "jpg" || $ext == "gif" || $ext == "jepg") {
                $datein[] = $na;
            }
        }
        //liefert bool Ordner:true/false
        if (is_dir($na)) {
            // ausschließen der . und .. Verzeichnisse
            if ($rekursiv && $name != '.' && $name != '..') {

                $datein = getBilder($na, $rekursiv, $datein);
            }
        }
    }
    // sort($datein);
    return $datein;
}

// PAGINIERUNG

/**
 * Paginierung
 *
 * @param int $seite
 * @param int $dsAnz
 * @param int $maxProSeite
 * @param boolean $alle
 * @return string
 */
function pagination($zielDatein, $seite, $dsAnz, $maxProSeite, $alle = true) // standardmäßig, werden alle Seitenlinks gezeigt
{
    $seitenlink = "";
    $seitenMax = ceil($dsAnz / $maxProSeite); // ceil rundet

    // 1 Datensatz zurück
    if ($seite <= 1) {
        $linkZurueck = 1;
    } else {
        $linkZurueck = $seite - 1;
    }
    $seitenlink .= "<a class='c_pagination' href='$zielDatein?s=$linkZurueck'><</a>";

    // 10 Datensätze zurück
    if ($seite <= 1) {
        $linkZurueck = 1;
    } else {
        $linkZurueck = $seite - 10;
    }
    $seitenlink .= "<a class='c_pagination' href='$zielDatein?s=$linkZurueck'><<</a>";

    // Pagination-Links erstellen
    for ($i = 1; $i <= $seitenMax; $i++) {
        if ($i == $seite) {
            $seitenlink .= "<a class='c_pagination c_pag_active' href='$zielDatein?s=$i'>$i</a> ";
        } elseif ($i == 1 || $i == $seitenMax || ($seite - 2 <= $i && $i <= $seite + 2 || $alle)) {
            $seitenlink .= "<a class='c_pagination' href='$zielDatein?s=$i'>$i</a> ";
        } elseif ($i == 2) {
            $seitenlink .= "<span>...</span> ";
        } elseif ($i == $seitenMax - 1) {
            $seitenlink .= "<span>...</span>";
        }
    }


    // 10 Datensätze vor
    if ($seite >= $seitenMax) {
        $linkZurueck = $seitenMax;
    } else {
        $linkVor = $seite + 10;
    }
    $seitenlink .= "<a class='c_pagination' href='$zielDatein?s=$linkVor'>>></a>";

    // 1 Datensatz vorw
    if ($seite >= $seitenMax) {
        $linkVor = $seitenMax;
    } else {
        $linkVor = $seite + 1;
    }
    $seitenlink .= "<a class='c_pagination' href='$zielDatein?s=$linkVor'>></a>";


    return $seitenlink;
}
