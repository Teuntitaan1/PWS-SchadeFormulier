<?php
// Functie die op basis van de filters meegegeven vanuit de schadeserver een query returned die weer uitgevoerd kan worden.
function BuildQuery($Keywords, $DateArray, $ToiletIDArray, $OriginArray, $ValidityArray) : string {
    // Null checks
    if ($ValidityArray == null || $OriginArray == null) {
        return "OnreachableQuery";
    }
    if ($DateArray[1] == null) {
        $DateArray[1] = (new DateTime())->sub(new DateInterval("PT1H"))->format("o-m-d H:i:s");
    }
    if ($DateArray[2] == null) {
        $DateArray[2] = (new DateTime())->sub(new DateInterval("P1Y"))->format("o-m-d H:i:s");
    }


    // Lege querylist die opgevuld wordt met queries, hier wordt doorheengeloopt en geappendeerd tot de $Query string die uiteindelijk geretourneerd wordt.
    $QueryList = [];

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
    // pas $Date aan., Datearray bestaat uit (Optie, Begindatum, Einddatum)
    switch ($DateArray[0]) {
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

        case "Custom": $DatePart = "Custom"; break;
        default: $DatePart = ""; break;

    }

    // Datum filter
    if ($DatePart != "") {
        if($DatePart == "Custom") { $QueryList[1] = "`Datum` > '$DateArray[1]' AND `Datum` < '$DateArray[2]'";}
        else { $QueryList[1] = "`Datum` > $DatePart"; }
    } else { $QueryList[1] = ""; }

    // ToiletID filter
    if ($ToiletIDArray[0] != "All") {
        $ToiletIDPart = "";
        for ($x = 1; $x < count($ToiletIDArray); $x++) {$ToiletIDPart .= "`ToiletID` = '$ToiletIDArray[$x]' OR ";}
        $ToiletIDPart = rtrim($ToiletIDPart, "OR ");
        // Geen toiletten geselecteerd betekent ook dat de query altijd saus terugstuurd
        if ($ToiletIDPart == "") {
            return "UnreachableQuery";
        }
        $QueryList[2] = $ToiletIDPart;
    } else { $QueryList[2] = "";}

    // Bron filter
    $OriginPart = "";
    for ($x = 0; $x < count($OriginArray); $x++) {
        $OriginPart .= " `Soort` = '".$OriginArray[$x]."' OR ";
    }
    $QueryList[3] = rtrim($OriginPart, "OR ");

    // Betrouwbaarheid filter
    $ValidityPart = "";
    for ($x = 0; $x < count($ValidityArray); $x++) {
        $ValidityPart .= " `Betrouwbaarheid` = '".$ValidityArray[$x]."' OR ";
    }
    $QueryList[4] = rtrim($ValidityPart, "OR ");

    // Kut kut grafjode query appender ik haat mijn leven, telt de hoeveelheid niet lege queries, als die > 0 zijn dan moet de query opgebouwd worden
    // Basis query
    $Query = "SELECT * FROM `SchadeServer`";
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
