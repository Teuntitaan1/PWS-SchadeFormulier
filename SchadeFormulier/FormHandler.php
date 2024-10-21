<?php
// Form data ontvangen? Verstuur form
if (isset($_POST['Send'])) {
    // SQL Connectie
    $Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
    if($Connection->connect_error) { die("Connection Failed" . $Connection->connect_error);}
    
    // Is er een bestand verstuurd?
    if (!($_FILES['Evidence'] == null)) {
        $EvidenceData = "'".base64_encode(file_get_contents($_FILES['Evidence']['tmp_name']))."'";
        $EvidenceType = "'".$_FILES["Evidence"]["type"]."'";
    }
    // Zo niet, dan stel je de data in op NULL
    else { $EvidenceType = $EvidenceData = "NULL"; }

    // Query die de data verwerkt.
    $Query = " INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
                VALUES ('".$_POST["ToiletID"]."', 'Formulier', 'Eerlijk', '".$_POST["Description"]."', $EvidenceData, $EvidenceType);";
    // Verzend de query en stuur de leerling terug naar index.php
    $Connection->query($Query); $Connection->close();
    header("location: ./index.php?ToiletID=".$_POST["ToiletID"]."&Done=True");
}
// Terug naar index.php
else { header("location: index.php"); }
// Klaar.
exit();