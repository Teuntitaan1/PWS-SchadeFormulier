<?php
// UUID Generator
require dirname(__DIR__, 1).'/Shared.php';

$ToiletID = $_POST['ToiletID'];
$Source = $_POST['Source'];
$Validity = $_POST['Validity'];
$Description = $_POST['Description'];

// Null check
if (($ToiletID == null) || ($Source == null) || ($Validity == null) || ($Description == null)) {
    http_response_code(404);
    error_log("Null check failed");
    exit();
}

$EvidenceName = null;
// Is er een bestand verstuurd?
if (!($_FILES['Evidence'] == null)) {
    if ($_FILES['Evidence']['error'] == 0) {
        // Directory waar hij de bestanden opslaat
        $FileDir = dirname(__DIR__, 1)."/Files/";
        // Random gegeneneerde naam + extensie
        $EvidenceName = GenerateUUID().".".pathinfo($_FILES["Evidence"]["name"],PATHINFO_EXTENSION);
        // Beweeg bestand de goede kant op
        move_uploaded_file($_FILES["Evidence"]["tmp_name"], $FileDir.$EvidenceName);
    }
    else {
        http_response_code(500);
        error_log("File upload failed");
        exit();
    }
}

// Query die de data verwerkt.
$Query = " INSERT INTO `SchadeServer` (`ToiletID`, `Bron`, `Betrouwbaarheid`, `Beschrijving`, `BewijsNaam`) 
            VALUES ('$ToiletID', '$Source', '$Validity', '$Description', '$EvidenceName');";
// SQL injectie poging dan aso wegsturen
if (!(substr_count($Query, ";") > 1)) {
    $QueryResult = $Connection->query($Query);
    $Connection->close();
    if($QueryResult) {header("location: ./index.php?ToiletID=$ToiletID&Done=True");}
    else { http_response_code(500); error_log("Sql server error");}
}
else {http_response_code(403); error_log("Fuck you sql injector");}
exit();
