<?php
// Functie die op basis van de filters meegegeven vanuit de schadeserver een query returned die weer uitgevoerd kan worden.
function BuildQuery($Keywords, $DateArray, $ToiletIDArray, $OriginArray, $ValidityArray, $SortArray) : string {
    // Null checks
    if ($ValidityArray == array("1") || $OriginArray == array("1")) { return "UnreachableQuery"; }
    if ($DateArray[1] == null) { $DateArray[1] = (new DateTime())->sub(new DateInterval("PT1H"))->format("o-m-d H:i:s"); }
    if ($DateArray[2] == null) { $DateArray[2] = (new DateTime())->sub(new DateInterval("P1Y"))->format("o-m-d H:i:s"); }

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
        case "PastHour": $DatePart = "'".(new DateTime())->sub(new DateInterval("PT1H"))->format("o-m-d H:i:s")."'"; break;
        case "PastDay": $DatePart = "'".(new DateTime())->sub(new DateInterval("P1D"))->format("o-m-d H:i:s")."'"; break;
        case "PastWeek": $DatePart = "'".(new DateTime())->sub(new DateInterval("P1W"))->format("o-m-d H:i:s")."'"; break;
        case "PastMonth": $DatePart = "'".(new DateTime())->sub(new DateInterval("P1M"))->format("o-m-d H:i:s")."'"; break;
        case "PastYear": $DatePart = "'".(new DateTime())->sub(new DateInterval("P1Y"))->format("o-m-d H:i:s")."'"; break;

        case "Custom": $DatePart = "Custom"; break;
        default: $DatePart = ""; break;
    }

    // custom Datum filter
    if ($DatePart != "") {
        if($DatePart == "Custom") { $QueryList[1] = "(`Datum` > '$DateArray[1]' AND `Datum` < '$DateArray[2]')";}
        else { $QueryList[1] = "`Datum` > $DatePart"; }
    } else { $QueryList[1] = ""; }

    // ToiletID filter
    if ($ToiletIDArray[0] != "All") {
        $ToiletIDPart = "";
        if($ToiletIDArray[0] == "Custom") {
            for ($x = 1; $x < count($ToiletIDArray); $x++) {$ToiletIDPart .= "`ToiletID` = '$ToiletIDArray[$x]' OR ";}
            $ToiletIDPart = rtrim($ToiletIDPart, "OR ");
        }
        // Geen toiletten geselecteerd betekent ook dat de query altijd saus terugstuurd
        if ($ToiletIDPart == "") { return "UnreachableQuery"; }
        $QueryList[2] = "(".$ToiletIDPart. ")";
    } else { $QueryList[2] = "";}

    // Bron filter
    $OriginPart = "";
    for ($x = 1; $x < count($OriginArray); $x++) { $OriginPart .= "`Soort` = '".$OriginArray[$x]."' OR ";}
    $OriginPart = rtrim($OriginPart, "OR ");
    if ($OriginPart != "") {$OriginPart = "(".$OriginPart.")";}
    $QueryList[3] = $OriginPart;

    // Betrouwbaarheid filter
    $ValidityPart = "";
    for ($x = 1; $x < count($ValidityArray); $x++) { $ValidityPart .= "`Betrouwbaarheid` = '".$ValidityArray[$x]."' OR "; }
    $ValidityPart = rtrim($ValidityPart, "OR ");
    if ($ValidityPart != "") {$ValidityPart = "(".$ValidityPart.")";}
    $QueryList[4] = $ValidityPart;


    // Kut kut grafjodeballen query appender ik haat mijn leven, telt de hoeveelheid niet lege queries, als die > 0 zijn dan moet de query opgebouwd worden
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
    // Homo sql injectors hebben niets op mij
    if (strpos($Query, ";")) {return  "UnreachableQuery"; }
    // Sortarray bepaalt waarop ie filter en hoe
    return $Query . " ORDER by `$SortArray[0]` $SortArray[1];";
}

// Voert de query uit, en returned de resultaten.
function QueryExecuter($Query) : array {
    if ($Query == "UnreachableQuery") {return [];}
    // query uitvoeren en data ophalen
    global $Connection;
    $Result = $Connection->query($Query)->fetch_all(MYSQLI_ASSOC);
    if (count($Result) > 0) {
        return $Result;
    }
    return [];
}
