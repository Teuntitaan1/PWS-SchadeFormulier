<?php
// SQL Connectie
$Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if($Connection->Connect_Error) { die("Connection Failed" . $Connection->Connect_Error);}

// Form data ontvangen? Verstuur form
if (isset($_POST['Send'])) {
    // Data klaarmaken voor verzending
    $ToiletID = $_POST["ToiletID"];
    $Description = $_POST["Description"];
    
    // Is er een bestand verstuurd?
    if (!($_FILES['Evidence'] == null)) {
        $EvidenceData = base64_encode(file_get_contents($_FILES['Evidence']['tmp_name']));
        $EvidenceType = $_FILES["Evidence"]["type"];
        // Query die de data verwerkt.
        $Query = "
        INSERT INTO `SchadeServer` 
            (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
            VALUES ('$ToiletID', 'Formulier', 'Eerlijk', '$Description', '$EvidenceData', '$EvidenceType');";
    }
    else {
        // Query die de data verwerkt. Zelfde als erboven maar dan met values NULL
        $Query = "INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) VALUES ($ToiletID, 'Formulier', 'Eerlijk', $Description, NULL, NULL)";
    }

    // Verzend de query en stuur de leerling terug naar index.php
    $Connection->query($Query); $Connection->close();
    header("location: ../Frontend/index.php?ToiletID=$ToiletID&Done=True");
}
// Terug naar index.php
else {header("location: index.php");}

// Klaar.
exit();