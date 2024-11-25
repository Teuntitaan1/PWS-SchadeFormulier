<!--TODO, keuzes ruimer-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht-Verbeterd</title>
    <script src="./script.js"></script>
</head>

    <?php
        $ToiletList = [
            "0M" => "mannentoilet begane grond",
            "0F" => "vrouwentoilet begane grond",
            "1M" => "mannentoilet 1e verdieping",
            "1F" => "vrouwentoilet 1e verdieping",
            "2M" => "mannentoilet 2e verdieping",
            "2F" => "vrouwentoilet 2e verdieping",
            "3M" => "mannentoilet 3e verdieping",
            "3F" => "vrouwentoilet 3e verdieping",
            "0G" => "genderneutraal toilet",
        ];

        ini_set('display_errors', 1); // kan weggecomment worden
    ?>

    <body>
        <!--Filter form, hieronder staat de data TODO, form reworken tot een gebruiksvriendelijker systeem-->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif" value='<?php echo $_GET["Keyword"]?>'>
            <div id="DateDiv">
                <label for="Date">Geschiedenis</label>
                <select id="Date" name="Date" onchange="DateChange()">
                    <option value="PastHour" <?php if($_GET["Date"] == "PastHour"){echo "selected";}?>>In het afgelopen uur</option>
                    <option value="PastDay" <?php if($_GET["Date"] == "PastDay"){echo "selected";}?>>Vandaag</option>
                    <option value="PastWeek" <?php if($_GET["Date"] == "PastWeek"){echo "selected";}?>>Deze week</option>
                    <option value="PastMonth" <?php if($_GET["Date"] == "PastMonth"){echo "selected";}?>>Deze maand</option>
                    <option value="PastYear" <?php if($_GET["Date"] == "PastYear"){echo "selected";}?>>Dit jaar</option>
                    <option value="Always" <?php if($_GET["Date"] == "Always"){echo "selected";}?>>Altijd</option>
                    <option value="Custom">Aangepast..</option>
                </select>
                <div id="CustomDateDiv" class="Collapsed">
                    <!--Hier verbeteren-->
                    <label for="Begin">Begin</label>
                    <input type="date" id="Begin" name="Start">
                    <label for="Eind">Eind</label>
                    <input type="date" id="Eind" name="End">
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
                        echo "<label for='$ToiletID'>$ToiletID</label><input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]'/>";
                    }
                    ?>
                </div>
            </div>

            <div id="OriginDiv">
                <label for="Sensor">Sensor</label><input type="checkbox" id="Sensor" name="Origin[]"/>
                <label for="Formulier">Formulier</label><input type="checkbox" id="Formulier" name="Origin[]"/>
            </div>

            <div id="ValidityDiv">
                <label for="Betrouwbaar">Betrouwbaar</label><input type="checkbox" id="Betrouwbaar" name="Validity[]"/>
                <label for="Eerlijk">Eerlijk</label><input type="checkbox" id="Eerlijk" name="Validity[]"/>
                <label for="Onbetrouwbaar">Onbetrouwbaar</label><input type="checkbox" id="Onbetrouwbaar" name="Validity[]"/>
            </div>
            <input type="submit" value="Filter">
        </form>

    </body>
</html>

<style>
.Collapsed {
    display: none;
}
.Extended {
    display: block;
}
</style>