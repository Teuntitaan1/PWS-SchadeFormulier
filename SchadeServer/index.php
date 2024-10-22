<?php include "../Shared_Vars.php"; include "./QueryBuilder.php" //include "./SQLConfig.php" ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
</head>

    <body>
        <!--Filter form, hieronder staat de data-->
        <form action="index.php" method="get">
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
                <option value="Formulier">Schadeformulier</option>
            </select>

            <label for="Validity">Betrouwbaarheid</label>
            <select id="Validity" name="Validity">
                <option value="All">Alle</option>
                <option value="Betrouwbaar">Betrouwbaar</option>
                <option value="Eerlijk">Eerlijk</option>
                <option value="Onbetrouwbaar">Onbetrouwbaar</option>
            </select>

            <input type="submit" value="Filter">
        </form>


        <?php
            $Query = BuildQuery($_GET["Keyword"], $_GET["Date"], $_GET["ToiletID"],$_GET["Origin"], $_GET["Validity"]);
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

