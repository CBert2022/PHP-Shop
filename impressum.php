<? session_start();
require_once("./config.php");

$ac[2] = 'active';
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
    $no[2] = 'li_none'; // Bestelllog verstecken


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <title>Lifestyle Shop - Impressum</title>
</head>

<body>
    <?php
    require_once('./nav.php');
    ?>
    <div class="container">
        <h1>Impressum</h1>
        <p>Angaben gemäß § 5 TMG</p>

        <p>
            Max Mustermann<br>
            Musterstraße 1<br>
            12345 Musterstadt<br>
            Deutschland<br><br>

            Telefon: +49 (0) 123 456789<br>
            E-Mail: info@muster-shop.de
        </p>

        <h2>Vertreten durch:</h2>
        <p>Max Mustermann</p>

        <h2>Umsatzsteuer-ID:</h2>
        <p>Umsatzsteuer-Identifikationsnummer gemäß §27a Umsatzsteuergesetz: DE123456789</p>

        <h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:</h2>
        <p>
            Max Mustermann<br>
            Musterstraße 1<br>
            12345 Musterstadt<br>
            Deutschland
        </p>

        <h2>Plattform der EU-Kommission zur Online-Streitbeilegung:</h2>
        <p><a href="https://ec.europa.eu/consumers/odr">https://ec.europa.eu/consumers/odr</a></p>

        <h2>Datenschutzerklärung</h2>

        <h3>1. Datenschutz auf einen Blick</h3>
        <p>
            Der Schutz Ihrer persönlichen Daten ist uns ein besonderes Anliegen. Diese Datenschutzerklärung informiert Sie über die Art, den Umfang und den Zweck der Verarbeitung von personenbezogenen Daten in unserem Online-Shop.
        </p>

        <h3>2. Verantwortlicher</h3>
        <p>
            Verantwortlich für die Datenverarbeitung auf dieser Website ist:<br>
            Max Mustermann<br>
            Musterstraße 1<br>
            12345 Musterstadt<br>
            Deutschland<br>
            E-Mail: <a href="mailto:datenschutz@muster-shop.de">datenschutz@muster-shop.de</a>
        </p>

        <h3>3. Erhebung und Speicherung personenbezogener Daten sowie Art und Zweck von deren Verwendung</h3>
        <p>
            Beim Besuch der Website: Beim Aufrufen unserer Website werden durch den auf Ihrem Endgerät zum Einsatz kommenden Browser automatisch Informationen an den Server unserer Website gesendet. Diese Informationen werden temporär in einem sog. Logfile gespeichert. Erfasst werden u.a. IP-Adresse, Datum und Uhrzeit des Zugriffs, verwendeter Browser und Betriebssystem. Die Daten werden benötigt, um einen reibungslosen Verbindungsaufbau der Website zu gewährleisten.
        </p>
        <p>
            Bei Nutzung unseres Kontaktformulars: Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert.
        </p>

        <h3>4. Weitergabe von Daten</h3>
        <p>
            Eine Übermittlung Ihrer persönlichen Daten an Dritte zu anderen als den im Folgenden aufgeführten Zwecken findet nicht statt.
        </p>

        <h3>5. Cookies</h3>
        <p>
            Cookies werden eingesetzt, um die Nutzung unseres Angebots für Sie angenehmer zu gestalten. Einige Cookies sind essenziell für den Betrieb der Seite, andere helfen uns, die Benutzererfahrung zu verbessern (Analyse-Cookies). Die Nutzung von Cookies zu Analysezwecken erfolgt nur mit Ihrer ausdrücklichen Einwilligung. Sie können Ihre Einwilligung jederzeit über die Cookie-Einstellungen widerrufen. Nähere Informationen finden Sie in unserer Cookie-Richtlinie.
        </p>

        <h3>6. Analyse-Tools und Werbung</h3>
        <p>
            Zum Zwecke der bedarfsgerechten Gestaltung und fortlaufenden Optimierung unserer Seiten nutzen wir Tracking-Technologien wie Google Analytics. Diese Tools arbeiten ebenfalls mit Cookies und speichern Informationen über Ihre Nutzung der Website.
        </p>

        <h3>7. Social Media Plugins</h3>
        <p>
            Auf unserer Website kommen Social Media Plugins von Anbietern wie Facebook, Instagram und Twitter zum Einsatz. Diese Plugins ermöglichen es Ihnen, Inhalte unserer Website in sozialen Netzwerken zu teilen. Wenn Sie eine Seite aufrufen, die ein solches Plugin enthält, stellt Ihr Browser eine direkte Verbindung mit den Servern des sozialen Netzwerks her und übermittelt Informationen, einschließlich Ihrer IP-Adresse.
        </p>

        <h3>8. Ihre Rechte als betroffene Person</h3>
        <p>
            Sie haben das Recht:
        <ul>
            <li>Auskunft über Ihre von uns verarbeiteten personenbezogenen Daten zu verlangen.</li>
            <li>Berichtigung unrichtiger oder unvollständiger personenbezogener Daten zu verlangen.</li>
            <li>Löschung Ihrer bei uns gespeicherten personenbezogenen Daten zu verlangen, sofern diese nicht zur Erfüllung einer rechtlichen Verpflichtung erforderlich sind.</li>
            <li>Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen, wenn die Richtigkeit der Daten bestritten wird oder die Verarbeitung unrechtmäßig ist.</li>
            <li>Widerspruch gegen die Verarbeitung Ihrer personenbezogenen Daten einzulegen, sofern sich aus Ihrer besonderen Situation Gründe ergeben, die gegen die Datenverarbeitung sprechen.</li>
        </ul>
        </p>

        <h3>9. Bildnachweis</h3>
        <p>
            Die auf dieser Website verwendeten Bilder stammen aus den Bilddatenbanken Unsplash und Pexels. Die Bildrechte liegen bei den jeweiligen Fotografen und den Plattformen, auf denen die Bilder bereitgestellt werden. Wir danken den Künstlern für ihre großartigen Beiträge.
        </p>

        <h3>10. Datensicherheit</h3>
        <p>
            Wir verwenden innerhalb des Website-Besuchs das verbreitete SSL-Verfahren (Secure Socket Layer) in Verbindung mit der jeweils höchsten Verschlüsselungsstufe, die von Ihrem Browser unterstützt wird. Wir setzen zudem geeignete technische und organisatorische Sicherheitsmaßnahmen ein, um Ihre Daten gegen zufällige oder vorsätzliche Manipulationen, teilweisen oder vollständigen Verlust, Zerstörung oder den unbefugten Zugriff Dritter zu schützen.
        </p>

        <h3>11. Aktualität und Änderung dieser Datenschutzerklärung</h3>
        <p>
            Diese Datenschutzerklärung ist aktuell gültig und hat den Stand [Datum]. Durch die Weiterentwicklung unserer Website und Angebote darüber oder aufgrund geänderter gesetzlicher bzw. behördlicher Vorgaben kann es notwendig werden, diese Datenschutzerklärung zu ändern. Die jeweils aktuelle Datenschutzerklärung kann jederzeit auf der Website unter dem Link Datenschutzerklärung von Ihnen abgerufen und ausgedruckt werden.
        </p>

    </div>

    <?php require './footer.php'; ?> <!-- Einfügen des Footers -->
</body>

</html>