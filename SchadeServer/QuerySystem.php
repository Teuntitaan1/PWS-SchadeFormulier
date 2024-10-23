<?php
// Functie die op basis van de filters meegegeven vanuit de schadeserver een query returned die weer uitgevoerd kan worden.
function BuildQuery($Keywords, $Date, $ToiletID, $Origin, $Validity) : string {
    // Lege querylist die opgevuld wordt met queries, hier wordt doorheengeloopt en geappendeerd tot de $Query string die uiteindelijk geretourneerd wordt.
    $QueryList = [];
    $Query = "SELECT * FROM `SchadeServer`";
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
    switch ($Date) {
        case "PastHour":
            $DatePart = "'".(new DateTime())->sub(new DateInterval("PT1H"))->format("o-m-d H:i:s")."'"; break;
        case "PastDay":
            $DatePart = "'".(new DateTime())->sub(new DateInterval("P1D"))->format("o-m-d H:i:s")."'"; break;
        case "PastWeek":
            $DatePart = "'".(new DateTime())->sub(new DateInterval("P1W"))->format("o-m-d H:i:s")."'"; break;
        case "PastMonth":
            $DatePart = "'".(new DateTime())->sub(new DateInterval("P1M"))->format("o-m-d H:i:s")."'"; break;
        case "PastYear":
            $DatePart = "'".(new DateTime())->sub(new DateInterval("P1Y"))->format("o-m-d H:i:s")."'"; break;
        default:
            $DatePart = ""; break;
        // Mist aanpasbare periode
    }

    // De simpele filters
    if ($DatePart != "") { $QueryList[1] = "`Datum` > $DatePart"; } else { $QueryList[1] = ""; }
    if ($ToiletID != "All") { $QueryList[2] = "`ToiletID` = '$ToiletID'"; } else { $QueryList[2] = ""; }
    if ($Origin != "All") { $QueryList[3] = "`Soort` = '$Origin'"; } else { $QueryList[3] = ""; }
    if ($Validity != "All") { $QueryList[4] = "`Betrouwbaarheid` = '$Validity'"; } else { $QueryList[4] = ""; }

    // Kut kut query appender ik haat mijn leven, telt de hoeveelheid niet lege queries, als die > 0 zijn dan moet de query opgebouwd worden
    $AmountOfAND = count(array_filter($QueryList, fn($Query) => $Query !== ""));
    $NotEmptyQuery = $AmountOfAND > 0;
    if ($NotEmptyQuery) {
        $Query .= " WHERE ";
        for ($x = 0; $x <= count($QueryList); $x++) {
            if ($QueryList[$x] != "") {
                //Append Query
                $Query.= $QueryList[$x];
                // Mag hij nog AND toevoegen?
                if ($AmountOfAND > 1) {
                    $Query .= " AND ";
                    $AmountOfAND--;
                }
            }
        }
    }
    // Nieuwste eerst
    return $Query . " ORDER by `Datum` DESC;";
}

// Voert de query uit, en returned de resultaten.
function QueryExecuter($Query) : array {
    // SQL Connectie
    $Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
    if($Connection->connect_error) { die("Connection Failed" . $Connection->connect_error);}

    // query uitvoeren en data ophalen
    $Result = $Connection->query($Query)->fetch_all(MYSQLI_ASSOC);
    if (count($Result) > 0) {
        return $Result;
    }
    return [];
}
