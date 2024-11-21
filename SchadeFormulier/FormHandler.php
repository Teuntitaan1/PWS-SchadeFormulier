<?php
// UUID Generator
require dirname(__DIR__, 1).'/Shared.php';

// Form data ontvangen? Verstuur form
if (isset($_POST['Send'])) {
    // Is er een bestand verstuurd?
    if (!($_FILES['Evidence'] == null)) {
        // Directory waar hij de bestanden opslaat
        $FileDir = dirname(__DIR__, 1)."/Files/";
        // Random gegeneneerde naam + extensie
        $EvidenceName = GenerateUUID().".".pathinfo($_FILES["Evidence"]["name"],PATHINFO_EXTENSION);
        // Beweeg bestand de goede kant op
        move_uploaded_file($_FILES["Evidence"]["tmp_name"], $FileDir.$EvidenceName);
    }
    // Zo niet, dan stel je de data in op NULL
    else { $EvidenceName = "NULL"; }

    // Query die de data verwerkt.
    $Connection->query(" INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `BewijsNaam`) 
                VALUES ('".$_POST["ToiletID"]."', 'Formulier', 'Eerlijk', '".$_POST["Description"]."', '$EvidenceName');");
    // Verzend de query en stuur de leerling terug naar index.php
    $Connection->close();
    header("location: ./index.php?ToiletID=".$_POST["ToiletID"]."&Done=True");
}
// Terug naar index.php
else { header("location: ./index.php"); }
// Klaar.
exit();