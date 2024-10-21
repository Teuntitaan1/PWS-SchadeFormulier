<?php
// SQL Connectie
$ServerName = "localhost";
$Username = "39506";
$Password = "Bte0k";
$DatabaseName = "db_39506";

$Connection = new mysqli($ServerName, $Username, $Password, $DatabaseName);
if($Connection->Connect_Error) {
    die("Connection Failed" . $Connection->Connect_Error);
}

// Form data ontvangen? Verstuur form
if (isset($_POST['Send'])) {

    // Data klaarmaken voor verzending
    $ToiletID = $_POST["ToiletID"];
    $Description = $_POST["Description"];
    
    // Is er een bestand verstuurd?
    if ($_FILES['Evidence'] == null) {
        // Query die de data verwerkt.
        $Query = "
        INSERT INTO `SchadeServer` 
            (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
            VALUES ($ToiletID, 'Formulier', 'Eerlijk', $Description, NULL, NULL)";
    }
    else {
        $EvidenceData = base64_encode(fread(fopen($_FILES['Evidence']['tmp_name'], "r")));
        $EvidenceType = $_FILES["Evidence"]["type"];
        // Query die de data verwerkt.
        $Query = "
        INSERT INTO `SchadeServer` 
            (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
            VALUES ($ToiletID, 'Formulier', 'Eerlijk', $Description, '$EvidenceData', '$EvidenceType')";
    }

    // Verzend de query en stuur de leerling terug naar index.php
    $Connection->query($Query);
    $Connection->close();
    header("location: ../Frontend/index.php?ToiletID=$ToiletID&Done=True");
    
}
// Terug naar index.php
else {
    header("location: index.php");
}

// Klaar.
exit();