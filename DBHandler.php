<?php
// UUID Generator
require __DIR__.'/Shared.php';

// Form data ontvangen? Verstuur form
if (isset($_POST['Source'])) {
    // Is er een bestand verstuurd?
    if (!($_FILES['Evidence'] == null)) {
        // Directory waar hij de bestanden opslaat
        $FileDir = __DIR__."/Files/";
        // Random gegeneneerde naam + extensie
        $EvidenceName = GenerateUUID().".".pathinfo($_FILES["Evidence"]["name"],PATHINFO_EXTENSION);
        // Beweeg bestand de goede kant op
        move_uploaded_file($_FILES["Evidence"]["tmp_name"], $FileDir.$EvidenceName);
    }
    // Zo niet, dan stel je de data in op NULL
    else { $EvidenceName = "NULL"; }

    // Query die de data verwerkt.
    $Query = " INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `BewijsNaam`) 
                VALUES ('".$_POST["ToiletID"]."', '".$_POST["Source"]."', '".$_POST["Validity"]."', '".$_POST["Description"]."', '$EvidenceName');";
    // SQL injectie poging dan aso wegsturen
    if (count_chars($Query, ";") > 1) { header("location: ./index.php?ToiletID=".$_POST["ToiletID"]."&Done=False"); exit(); }
    else {$Connection->query($Query); $Connection->close();} // Voer de query uit

    // stuur de leerling terug naar index.php, bij sensor request doe niets
    if ($_POST["Source"] == "Formulier") { header("location: ./index.php?ToiletID=".$_POST["ToiletID"]."&Done=True"); exit(); }
}
// Terug naar index.php, geen andere condities nodig want als deze getriggered wordt vanuit een sensor http request klopt de request niet.
else { header("location: ./index.php"); exit();}
