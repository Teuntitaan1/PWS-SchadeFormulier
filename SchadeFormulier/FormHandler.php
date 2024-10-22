<?php
// Form data ontvangen? Verstuur form
if (isset($_POST['Send'])) {
    // SQL Connectie
    $Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
    if($Connection->connect_error) { die("Connection Failed" . $Connection->connect_error);}
    
    // Is er een bestand verstuurd?
    if (!($_FILES['Evidence'] == null)) {
        // leest het bestand uit, encrypt hem naar een Binary large object blebber
        $EvidenceData = "'".base64_encode(file_get_contents($_FILES['Evidence']['tmp_name']))."'";
        // bestandstype, kan video zijn bij de sensor
        $EvidenceType = "'".$_FILES["Evidence"]["type"]."'";
    }
    // Zo niet, dan stel je de data in op NULL
    else { $EvidenceType = $EvidenceData = "NULL"; }

    // Query die de data verwerkt.
    $Connection->query(" INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
                VALUES ('".$_POST["ToiletID"]."', 'Formulier', 'Eerlijk', '".$_POST["Description"]."', $EvidenceData, $EvidenceType);");
    // Verzend de query en stuur de leerling terug naar ertg.php
    $Connection->close();
    header("location: ./index.php?ToiletID=".$_POST["ToiletID"]."&Done=True");
}
// Terug naar ertg.php
else { header("location: ./index.php"); }
// Klaar.
exit();