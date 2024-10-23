<?php
// SQL Connectie
$Conncection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if($Conncection->connect_error) { die("Connection Failed" . $Conncection->connect_error);}

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
    if ($ToiletID != "All") { $QueryList[2] = "`ToiletID` = $ToiletID"; } else { $QueryList[2] = ""; }
    if ($Origin != "All") { $QueryList[3] = "`Soort` = '".$Origin."'"; } else { $QueryList[3] = ""; }
    if ($Validity != "All") { $QueryList[4] = "`Betrouwbaarheid` = $Validity"; } else { $QueryList[4] = ""; }

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
    // Nieuwste eerst
    return $Query . " ORDER by `Datum` DESC;";
}

// Voert de query uit, en returned de resultaten.
function QueryExecuter($Query) : array {
    if (isset($Connection)) {
        // query uitvoeren en data ophalen
        $Result = $Connection->query($Query)->fetch_all(MYSQLI_ASSOC);
        if (count($Result) > 0) {
            return $Result;
        }
    }
    return [];
}