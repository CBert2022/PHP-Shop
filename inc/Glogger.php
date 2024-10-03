<?php
class Glogger
{
    private $lev = ['keine', 'Error', 'Warning', 'Info', 'Debug'];
    private $logDatei = "logger.log";

    // Level limitieren nach livegang um nur error und warnung zu sehen
    private $aktLev = 3;

    public function __construct()
    {
    }
    public function setLogdatei($n)
    {
        $this->logDatei = $n;
    }
    public function setAktLev($l)
    {
        $this->aktLev = $l;
    }
    public function setMessage($level, $info, $message)
    {
        // in logDatei
        // 2024-06-28 09:00 | $info | $message

        if ($level <= $this->aktLev) {
            // Datei zusammenbauen
            $datum = date('Y-m-d H:i'); // 2024-06-28 09:00
            $log = "$datum|" . $this->lev[$level] . "|$info|$message\n";

            // Inhalt in logger.log schreiben
            $f = file_put_contents($this->logDatei, $log, FILE_APPEND | LOCK_EX);
        }
    }
}
