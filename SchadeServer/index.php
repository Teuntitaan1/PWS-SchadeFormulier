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
            $Query = "";
            if(isset($_GET["Keyword"])) {
                // Keywords om op te filteren
                $Keywords = explode(",", $_GET["Keyword"]);
                // format("m/d/y H:i:s");
                $CurrentDate = new DateTime();
                // pas $Date aan aan de juiste filter, voorbeeld: 2024-10-21 16-1:04:2 dus 2024-10-21 16-1:04:2
                switch ($_GET["Date"]) {
                    //TODO aapassen voor specifieke perioode
                    case "PastHour":
                        $CurrentDate->sub(new DateInterval("PT1H")); break;
                    case "PastDay":
                        $CurrentDate->sub(new DateInterval("P1D")); break;
                    case "PastWeek":
                        $CurrentDate->sub(new DateInterval("P1W")); break;
                    case "PastMonth":
                        $CurrentDate->sub(new DateInterval("P1M")); break;
                    case "PastYear":
                        $CurrentDate->sub(new DateInterval("P1Y")); break;
                }
                // TODO op basis van de filters moeten er queries gebouwd worden, deze moeten dan toegepast worden en alles moet laten zien worden, alle niet aangepaste filters kunnen zo de query in.
            }
            else {
                echo "Beta";
                // TODO als er geen filters toegepast zijn, laat ze van vandaag zien.
                $Query = "SELECT * FROM `SchadeServer`";
            }

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

