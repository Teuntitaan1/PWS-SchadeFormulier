<?php
$GLOBALS["ToiletList"] = [
    "0M" => "mannentoilet begane grond",
    "0F" => "vrouwentoilet begane grond",
    "1M" => "mannentoilet 1e verdieping",
    "1F" => "vrouwentoilet 1e verdieping",
    "2M" => "mannentoilet 2e verdieping",
    "2F" => "vrouwentoilet 2e verdieping",
    "3M" => "mannentoilet 3e verdieping",
    "3F" => "vrouwentoilet 3e verdieping",
    "0G" => "genderneutrale toilet",
];

function ValidateToiletID($ID): bool
{
    if($ID != null) {
        if($GLOBALS["ToiletList"][$ID] != null) {
            return true;
        }
    }
    return false;
}