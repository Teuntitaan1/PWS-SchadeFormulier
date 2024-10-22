<?php
function BuildQuery($Keywords, $Date, $ToiletID, $Origin, $Validity) : string {
    // Lege querylist die opgevuld wordt met queries, hier wordt doorheengeloopt en geappendeerd tot de $Query string die uiteindelijk geretourneerd wordt.
    $QueryList = [];
    $Query = "SELECT * FROM `SchadeServer`";

    if ($Keywords != null && $Date != null && $ToiletID != null && $Origin != null && $Validity != null) {
        // Keywords om op te filteren, als er keywords zijn, voeg ze toe, anders niet
        $Keywords = explode(",", $Keywords);
        if($Keywords[0] != "") {
            $KeywordPart = "";
            for ($x = 0; $x < count($Keywords); $x++) {
                $KeywordPart.= " `Beschrijving` LIKE '%".$Keywords[$x]."%'";
                if (isset($Keywords[$x + 1])) {
                    $KeywordPart .= " OR";
                }
            }
            $QueryList[0] = $KeywordPart;
        }
        // pas $Date aan.
        $DatePart = match ($Date) { // format("m/d/y H:i:s");
            "PastHour" =>  "'".(new DateTime())->sub(new DateInterval("PT1H"))->format("m/d/y H:i:s")."'",
            "PastDay" =>   "'".(new DateTime())->sub(new DateInterval("P1D"))->format("m/d/y H:i:s")."'",
            "PastWeek" =>  "'".(new DateTime())->sub(new DateInterval("P1W"))->format("m/d/y H:i:s")."'",
            "PastMonth" => "'".(new DateTime())->sub(new DateInterval("P1M"))->format("m/d/y H:i:s")."'",
            "PastYear" =>  "'".(new DateTime())->sub(new DateInterval("P1Y"))->format("m/d/y H:i:s")."'",
            default => "",
            // Mist aanpasbare periode
        };

        // De simpele filters
        if ($DatePart != "") { $QueryList[1] = "`Datum` < $DatePart"; } else { $QueryList[1] = ""; }
        if ($ToiletID != "All") { $QueryList[2] = "`ToiletID` = '".$ToiletID."'"; } else { $QueryList[2] = ""; }
        if ($Origin != "All") { $QueryList[3] = "`Origin` = '".$Origin."'"; } else { $QueryList[3] = ""; }
        if ($Validity != "All") { $QueryList[4] = "`Validity` = '".$Validity."'"; } else { $QueryList[4] = ""; }

        // Kut kut query appender ik haat mijn leven, telt de hoeveelheid niet lege queries, als die > 0 zijn dan moet de query opgebouwd worden
        if (count(array_filter($QueryList, fn($Query) => $Query !== "")) > 0) {
            $Query .= " WHERE ";
            for ($x = 0; $x < count($QueryList); $x++) {
                if ($QueryList[$x] != "") {
                    $Query.= $QueryList[$x];

                    if ($QueryList[$x + 1] != "") {
                        $Query .= " AND ";
                    }
                }
            }
        }
    }
    return $Query . " ORDER by `Datum` DESC;";
}