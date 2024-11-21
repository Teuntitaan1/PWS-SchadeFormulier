<!--TODO, gebruiksvriendelijker maken door keuzes op te slaan-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
    <script src="script.js"></script>
</head>

    <?php
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
        require __DIR__ . '/SharedVars.php'; // SQL query builder en verbeteraar
        // Non-valide url check
        if (!(($_GET["Date"] != null) && ($_GET["ToiletID"] != null) && ($_GET["Origin"] != null) && ($_GET["Validity"] != null))) { header("Location: index.php?Keyword=&Date=PastDay&ToiletID=All&Origin=All&Validity=All");}
        ini_set('display_errors', 1); // kan weggecomment worden
    ?>

    <body>
        <!--Filter form, hieronder staat de data-->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif">

            <label for="Date">Geschiedenis</label>
            <select id="Date" name="Date">
                <option value="PastDay">Vandaag</option>
                <option value="PastHour">In het afgelopen uur</option>
                <option value="PastWeek">Deze week</option>
                <option value="PastMonth">Deze maand</option>
                <option value="PastYear">Dit jaar</option>
                <option value="Always">Altijd</option>
            </select>

            <label for="ToiletID">Toilet</label>
            <select id="ToiletID" name="ToiletID">
                <option value="All">Alle</option>
                <?php
                    foreach($ToiletList as $ID => $ToiletID)
                    { echo "<option value='$ID'>$ToiletID</option>"; }
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

        <div class="collapsable">
            <?php
                $Query = BuildQuery($_GET["Keyword"], $_GET["Date"], $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"]);
                // bouwt de query op op basis van de filters
                $Result = QueryExecuter($Query);
                //voert query uit
                foreach ($Result as $Value) {
                    echo "<div>";
                        echo "
                        <p>Datum: ".$Value["Datum"]."</p>
                        <p>Toilet: ".$ToiletList[$Value["ToiletID"]]."</p>
                        <p>Bron: ".$Value["Soort"]."</p>
                        <p>Omschrijving: ".$Value["Beschrijving"]."</p>
                        <p>Betrouwbaarheid: ".$Value["Betrouwbaarheid"]."</p>
                        ";
                    if ($Value["BestandType"] != null) {
                        if (preg_match('#image/#', $Value["BestandType"])) {
                            echo "<p>Bewijs:</p>";
                            echo '<img src="data:'.$Value["BestandType"].';base64,'.$Value['Bewijs'].'"/>';
                        }
                        else if (preg_match('#video#', $Value["BestandType"])) {
                            //TODO video zooi implementeren
                        }
                    }
                    echo "</div>";

                }
            ?>
        </div>
    </body>
</html>

