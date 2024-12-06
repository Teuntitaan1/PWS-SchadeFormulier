<?php

// Gejatte UUID functie
function GenerateUUID()
{
    $data = random_bytes(16);
    assert(strlen($data) == 16);
    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
// chatgpt blesst ons met een mimetype functie mashallah
function GetMimeType($FileUrl): string {
        $mime_types = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/x-php',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'mp4' => 'video/mp4',
            'mkv' => 'video/x-matroska',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'mpg' => 'video/mpeg',
            'mpeg' => 'video/mpeg',
        ];
        $extensie = strtolower(pathinfo($FileUrl, PATHINFO_EXTENSION));
        return $mime_types[$extensie];
}
function ValidToiletID($ID): bool
{
    global $ToiletList;
    if ($ID != null) {
        if ($ToiletList[$ID] != null) {
            return true;
        }
    }
    return false;
}

// Bullshit informatica server maar dit moet want anders kloppen de bestandlinks niet meer
function CleanFileURL($URL)
{
    // Ik denk vreselijke code maar trekt de overbodige delen uit de url, doet niets als dit er niet in zit
    return str_replace(array("/var/www", "/public_html"), "", $URL);
}

// GEDEELDE VARIABLEN
$Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if ($Connection->connect_error) {
    die("Connection Failed" . $Connection->connect_error);
}
$ToiletList = [
    "0M" => "mannentoilet op de begane grond",
    "0F" => "vrouwentoilet op de begane grond",
    "1M" => "mannentoilet op de 1e verdieping",
    "1F" => "vrouwentoilet op de 1e verdieping",
    "2M" => "mannentoilet op de 2e verdieping",
    "2F" => "vrouwentoilet op de 2e verdieping",
    "3M" => "mannentoilet op de 3e verdieping",
    "3F" => "vrouwentoilet op de 3e verdieping",
    "0G" => "genderneutrale toilet",
];
//TODO File transfer tussen arduino en webserver