<?php

$EvidenceData = "'On sigma'";
$EvidenceType = "'Dikke brie'";

// Query die de data verwerkt.
$Query = "
        INSERT INTO `SchadeServer` 
            (`ToiletID`, `Soort`, `Betrouwbaarheid`, `Beschrijving`, `Bewijs`, `BestandType`) 
            VALUES ('0M', 'Formulier', 'Eerlijk', 'Wigga', $EvidenceData, $EvidenceType);";
echo $Query;