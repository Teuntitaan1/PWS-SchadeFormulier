<?php
ini_set('display_errors', 1); // kan weggecomment worden
ini_set('display_errors', 1);
$File = file_get_contents('./VideoTest.mp4');
$EvidenceData = "'".base64_encode($File)."'";
// bestandstype, kan video zijn bij de sensor
$EvidenceType = "'".$File["type"]."'";


// Query die de data verwerkt.
$Query = " INSERT INTO `SchadeServer` (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
                VALUES ('0M', 'Sensor', 'Eerlijk', '1e officiele videotest :)', $EvidenceData, $EvidenceType);";
// Verzend de query en stuur de leerling terug naar index.php

echo "Test";
