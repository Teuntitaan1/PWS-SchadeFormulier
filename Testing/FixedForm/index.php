<!--TODO, keuzes ruimer-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht-Verbeterd</title>
    <script src="./script.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>

    <?php
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
        require __DIR__ . '/Shared.php'; // SQL query builder en verbeteraar
        ini_set('display_errors', 1); // kan weggecomment worden
    ?>

    <body>
        <!--Filter form, hieronder staat de data TODO, form reworken tot een gebruiksvriendelijker systeem-->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif" value=''>
            <div id="DateDiv">
                <label for="Date">Geschiedenis</label>
                <select id="Date" name="Date" onchange="DateChange()">
                    <option value="PastHour">In het afgelopen uur</option>
                    <option value="PastDay">Vandaag</option>
                    <option value="PastWeek">Deze week</option>
                    <option value="PastMonth">Deze maand</option>
                    <option value="PastYear">Dit jaar</option>
                    <option value="Always">Altijd</option>
                    <option value="Custom">Aangepast..</option>
                </select>
                <div id="CustomDateDiv" class="Collapsed">
                    <label for="Begin">Begin</label>
                    <input type="date" id="Begin" name="Start"/>
                    <label for="Eind">Eind</label>
                    <input type="date" id="Eind" name="End"/>
                </div>
            </div>

            <div id="ToiletIDDiv">
                <label for="ToiletID">Toilet</label>
                <select id="ToiletID" name="ToiletID[]" onchange="ToiletIDChange()">
                    <option value="All">Alle</option>
                    <option value="Custom">Anders...</option>
                </select>
                <div id="IDDiv" class="Collapsed">
                    <?php
                    foreach($ToiletList as $ID => $ToiletID) {
                        echo "<label for='$ToiletID'>$ToiletID</label><input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]' checked/>";
                    }
                    ?>
                </div>
            </div>

            <div id="OriginDiv">
                <label for="Sensor">Sensor</label><input type="checkbox" id="Sensor" name="Origin[]" value="Sensor" checked/>
                <label for="Formulier">Formulier</label><input type="checkbox" id="Formulier" name="Origin[]" value="Formulier" checked/>
            </div>

            <div id="ValidityDiv">
                <label for="Betrouwbaar">Betrouwbaar</label><input type="checkbox" id="Betrouwbaar" name="Validity[]" value="Betrouwbaar" checked/>
                <label for="Eerlijk">Eerlijk</label><input type="checkbox" id="Eerlijk" name="Validity[]" value="Eerlijk" checked/>
                <label for="Onbetrouwbaar">Onbetrouwbaar</label><input type="checkbox" id="Onbetrouwbaar" name="Validity[]" value="Onbetrouwbaar" checked/>
            </div>
            <input type="submit" value="Filter">
        </form>
        <div id="Results">
            <?php
            $Query = BuildQuery($_GET["Keyword"], array($_GET["Date"], $_GET["Start"], $_GET["End"]), $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"]);
            // bouwt de query op op basis van de filters
            echo $Query;
            ?>
        </div>
    </body>
</html>
