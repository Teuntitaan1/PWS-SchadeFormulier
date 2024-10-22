<?php include "../Shared_Vars.php"; //include "./SQLConfig.php" ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
</head>

    <body>
        <!--Filter form, hieronder staat de data-->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif">

            <label for="Date">Geschiedenis</label>
            <select id="Date" name="Date">
                <option value="Always">Altijd</option>
                <option value="PastHour">In het afgelopen uur</option>
                <option value="PastDay">Vandaag</option>
                <option value="PastWeek">Deze week</option>
                <option value="PastMonth">Deze maand</option>
                <option value="PastYear">Dit jaar</option>
            </select>

            <label for="ToiletID">Toilet</label>
            <select id="ToiletID" name="ToiletID">
                <option value="All">Alle</option>
                <?php
                if (isset($ToiletList)) {
                    foreach($ToiletList as $ID => $ToiletID)
                    { echo "<option value='$ID'>$ToiletID</option>"; }
                }
                ?>
            </select>

            <label for="Origin">Bron</label>
            <select id="Origin" name="Origin">
                <option value="All">Alle</option>
                <option value="Sensor">Toilet-Sensor</option>
                <option value="Form">Schadeformulier</option>
            </select>

            <label for="Validity">Betrouwbaarheid</label>
            <select id="Validity" name="Validity">
                <option value="All">Alle</option>
                <option value="Sure">Betrouwbaar</option>
                <option value="Maybe">Eerlijk</option>
                <option value="Unsure">Onbetrouwbaar</option>
            </select>

            <input type="submit" value="Filter">
        </form>


        <?php

            // Lege query die opgevult wordt
            $Query = "SELECT * FROM `SchadeServer`";
            if(isset($_GET["Keyword"])) {
                // Keywords om op te filteren, als er keywords zijn, voeg ze toe, anders niet
                $Keywords = explode(",", $_GET["Keyword"]);
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
                $DatePart = match ($_GET["Date"]) {
                    "PastHour" => $CurrentDate->sub(new DateInterval("PT1H"))->format("m/d/y H:i:s"),
                    "PastDay" => $CurrentDate->sub(new DateInterval("P1D"))->format("m/d/y H:i:s"),
                    "PastWeek" => $CurrentDate->sub(new DateInterval("P1W"))->format("m/d/y H:i:s"),
                    "PastMonth" => $CurrentDate->sub(new DateInterval("P1M"))->format("m/d/y H:i:s"),
                    "PastYear" => $CurrentDate->sub(new DateInterval("P1Y"))->format("m/d/y H:i:s"),
                    default => "",
                };
                if ($DatePart != "") {$Query .= " AND WHERE 'Datum' > $DatePart";}
                // TODO op basis van de andere filters moeten er queries gebouwd worden, deze moeten dan toegepast worden en alles moet laten zien worden, alle niet aangepaste filters kunnen zo de query in.
            }
            else {
                // TODO als er geen filters toegepast zijn, laat ze van vandaag zien.
            }
            echo $Query;
//            $Result = $Connection->query($Query);
//
//            if ($Result->num_rows > 0) {
//                // Data laten zien ofzo
//                while($Row = $Result->fetch_assoc()) {
//                    echo 'Hier moet een nette weergave komen';
//                }
//            }
//            $Connection->close();
        ?>
    </body>

</html>

