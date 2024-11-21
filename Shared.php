<?php
// Gejatte UUID functie
function GenerateUUID() {
    $data = random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
function ValidToiletID($ID): bool {
    global $ToiletList;
    if ($ID != null) {
        if ($ToiletList[$ID] != null) { return true; }
    }
    return false;
}
// Bullshit informatica server maar dit moet want anders kloppen de bestandlinks niet meer
function CleanFileURL($URL) {
    // Ik denk vreselijke code maar trekt de overbodige delen uit de url, doet niets als dit er niet in zit
    return str_replace(array("/var/www", "/public_html"), "", $URL);
}

// GEDEELDE VARIABLEN
$Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if($Connection->connect_error) {die("Connection Failed" . $Connection->connect_error);}

$ToiletList = [
    "0M" => "mannentoilet begane grond",
    "0F" => "vrouwentoilet begane grond",
    "1M" => "mannentoilet 1e verdieping",
    "1F" => "vrouwentoilet 1e verdieping",
    "2M" => "mannentoilet 2e verdieping",
    "2F" => "vrouwentoilet 2e verdieping",
    "3M" => "mannentoilet 3e verdieping",
    "3F" => "vrouwentoilet 3e verdieping",
    "0G" => "genderneutraal toilet",
];

//TODO File transfer tussen arduino en webserver