<!--TODO, keuzes ruimer-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
</head>

    <?php
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
        require dirname(__DIR__, 1). '/Shared.php'; // SQL query builder en verbeteraar
        // Non-valide url check
        if (!(($_GET["Date"] != null) && ($_GET["ToiletID"] != null) && ($_GET["Origin"] != null) && ($_GET["Validity"] != null))) { header("Location: index.php?Keyword=&Date=PastDay&ToiletID=All&Origin=All&Validity=All");}
        ini_set('display_errors', 1); // kan weggecomment worden
    ?>

    <body>
        <!--Filter form, hieronder staat de data -->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif" value=<?php echo $_GET["Keyword"];?>>

            <label for="Date">Geschiedenis</label>
            <select id="Date" name="Date">
                <option value="PastHour" <?php if($_GET["Date"] == "PastHour"){echo "selected";}?>>In het afgelopen uur</option>
                <option value="PastDay" <?php if($_GET["Date"] == "PastWeek"){echo "selected";}?>>Vandaag</option>
                <option value="PastWeek" <?php if($_GET["Date"] == "PastWeek"){echo "selected";}?>>Deze week</option>
                <option value="PastMonth" <?php if($_GET["Date"] == "PastMonth"){echo "selected";}?>>Deze maand</option>
                <option value="PastYear" <?php if($_GET["Date"] == "PastYear"){echo "selected";}?>>Dit jaar</option>
                <option value="Always" <?php if($_GET["Date"] == "Always"){echo "selected";}?>>Altijd</option>
            </select>

            <label for="ToiletID">Toilet</label>
            <select id="ToiletID" name="ToiletID">
                <option value="All">Alle</option>
                <?php
                    foreach($ToiletList as $ID => $ToiletID) { 
                        if($_GET["ToiletID"] == $ID){ echo "<option value='$ID'>$ToiletID</option>";}
                        else { echo "<option value='$ID' selected>$ToiletID</option>";}
                    }
                ?>
            </select>

            <label for="Origin">Bron</label>
            <select id="Origin" name="Origin">
                <option value="All" <?php if($_GET["Origin"] == "All"){echo "selected";}?>>Alle</option>
                <option value="Sensor" <?php if($_GET["Origin"] == "Sensor"){echo "selected";}?>>Toilet-Sensor</option>
                <option value="Formulier" <?php if($_GET["Origin"] == "Formulier"){echo "selected";}?>>Schadeformulier</option>
            </select>

            <label for="Validity">Betrouwbaarheid</label>
            <select id="Validity" name="Validity">
                <option value="All" <?php if($_GET["Validity"] == "All"){echo "selected";}?>>Alle</option>
                <option value="Betrouwbaar" <?php if($_GET["Validity"] == "Betrouwbaar"){echo "selected";}?>>Betrouwbaar</option>
                <option value="Eerlijk" <?php if($_GET["Validity"] == "Eerlijk"){echo "selected";}?>>Eerlijk</option>
                <option value="Onbetrouwbaar" <?php if($_GET["Validity"] == "Onbetrouwbaar"){echo "selected";}?>>Onbetrouwbaar</option>
            </select>

            <input type="submit" value="Filter">
        </form>

        <div id="Results">
            <?php
                $Query = BuildQuery($_GET["Keyword"], $_GET["Date"], $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"]);
                // bouwt de query op op basis van de filters
                $Result = QueryExecuter($Query);
                //voert query uit
                $Count = 0;
                foreach ($Result as $Value) {
                    echo "<div class='Entry'>";
                        echo "
                            <p>Datum: ".$Value["Datum"]."</p>
                            <p>Toilet: ".$ToiletList[$Value["ToiletID"]]."</p>
                            <p>Bron: ".$Value["Soort"]."</p>
                            <p>Omschrijving: ".$Value["Beschrijving"]."</p>
                            <p>Betrouwbaarheid: ".$Value["Betrouwbaarheid"]."</p>
                            ";
                        if ($Value["BewijsNaam"] != null) {
                            // ervanuit gaande dat de server altijd op https is, anders http
                            $FileUrl = CleanFileURL("https://".$_SERVER['SERVER_NAME'].dirname(__DIR__, 1)."/Files/".$Value["BewijsNaam"]);
                            echo "<p>Bewijs: <a href='$FileUrl' target='_blank'>Link</a></p>";
                        }
                    echo "</div>";
                    // Fixt de entryid van de div
                    $Count++;
                }
            ?>
        </div>
    </body>
</html>

