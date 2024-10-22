<?php
function BuildQuery($Keywords, $Date, $ToiletID, $Origin, $Validity) : string {
    // Lege query die opgevult wordt
    $Query = "SELECT * FROM `SchadeServer`";
    // Keywords om op te filteren, als er keywords zijn, voeg ze toe, anders niet
    $Keywords = explode(",", $Keywords);
    if($Keywords[0] != "") {
        for ($x = 0; $x < count($Keywords); $x++) {
            $Query .= " WHERE 'Beschrijving' LIKE '%".$Keywords[$x]."'%";
            if (isset($Keywords[$x + 1])) {
                $Query .= " OR";
            }
        }
    }

    // format("m/d/y H:i:s");
    $CurrentDate = new DateTime();
    // pas $Date aan aan de juiste filter, voorbeeld: 2024-10-21 16-1:04:2 dus 2024-10-21 16-1:04:2
    $DatePart = match ($Date) {
        "PastHour" => $CurrentDate->sub(new DateInterval("PT1H"))->format("m/d/y H:i:s"),
        "PastDay" => $CurrentDate->sub(new DateInterval("P1D"))->format("m/d/y H:i:s"),
        "PastWeek" => $CurrentDate->sub(new DateInterval("P1W"))->format("m/d/y H:i:s"),
        "PastMonth" => $CurrentDate->sub(new DateInterval("P1M"))->format("m/d/y H:i:s"),
        "PastYear" => $CurrentDate->sub(new DateInterval("P1Y"))->format("m/d/y H:i:s"),
        default => "",
    };
    if ($DatePart != "") {
        $Query .= " AND ";
        $Query .= "'Datum' > $DatePart AND ";
    }
    if ($ToiletID != "All") {
        $Query .= "'ToiletID' = '".$ToiletID."' AND ";
    }
    if($Origin != "All") {
        $Query .= "'Origin' = '".$Origin."' AND ";
    }
    if ($Validity != "All") {
        $Query .= "'Validity' = '".$Validity."' AND ";
    }
    // TODO op basis van de andere filters moeten er queries gebouwd worden, deze moeten dan toegepast worden en alles moet laten zien worden, alle niet aangepaste filters kunnen zo de query in.
    $Query = rtrim($Query, " AND");
    $Query .= " ORDER by 'Datum' DESC';";
    return $Query;
}