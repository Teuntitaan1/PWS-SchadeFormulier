<?php
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

$ToiletList = [
    "0G" => "genderneutrale toilet",
    "0M" => "mannentoilet op de begane grond",
    "0F" => "vrouwentoilet op de begane grond",
    "1M" => "mannentoilet op de 1e verdieping",
    "1F" => "vrouwentoilet op de 1e verdieping",
    "2M" => "mannentoilet op de 2e verdieping",
    "2F" => "vrouwentoilet op de 2e verdieping",
    "3M" => "mannentoilet op de 3e verdieping",
    "3F" => "vrouwentoilet op de 3e verdieping",
];
