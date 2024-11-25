<!--TODO, keuzes ruimer-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht-Verbeterd</title>
    <script src="./script.js"></script>
</head>

    <?php
        require dirname(__DIR__, 2). '/Shared.php'; // SQL query builder en verbeteraar
        // Non-valide url check
        if (!(($_GET["Date"] != null) && ($_GET["ToiletID"] != null) && ($_GET["Origin"] != null) && ($_GET["Validity"] != null))) { header("Location: index.php?Keyword=&Date=PastDay&ToiletID=All&Origin=All&Validity=All");}
        ini_set('display_errors', 1); // kan weggecomment worden
    ?>

    <body>
        <?php echo $_GET["Keyword"]; ?>
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
                <div id="CustomDiv" class="Collapsed">
                    <!--Hier verbeteren-->
                    <label for="Begin">Begin</label>
                    <input type="date" id="Begin" name="Start">
                    <label for="Eind">Eind</label>
                    <input type="date" id="Eind" name="End">
                </div>
            </div>
            <label for="ToiletID">Toilet</label>
            <select id="ToiletID" name="ToiletID" multiple>
                <option value="All" <?php if($_GET["ToiletID"] == "All"){echo "selected";}?>>Alle</option>
                <?php
                    foreach($ToiletList as $ID => $ToiletID) { 
                        if($_GET["ToiletID"] == $ID) {
                            echo "<option value='$ID' selected>$ToiletID</option>";
                        }
                        else {
                            echo "<option value='$ID'>$ToiletID</option>"; 
                        }
                    }
                ?>
            </select>

            <label for="Origin">Bron</label>
            <select id="Origin" name="Origin" multiple>
                <option value="All" <?php if($_GET["Origin"] == "All"){echo "selected";}?>>Alle</option>
                <option value="Sensor" <?php if($_GET["Origin"] == "Sensor"){echo "selected";}?>>Toilet-Sensor</option>
                <option value="Formulier" <?php if($_GET["Origin"] == "Formulier"){echo "selected";}?>>Schadeformulier</option>
            </select>

            <label for="Validity">Betrouwbaarheid</label>
            <select id="Validity" name="Validity" multiple>
                <option value="All" <?php if($_GET["Validity"] == "All"){echo "selected";}?>>Alle</option>
                <option value="Betrouwbaar" <?php if($_GET["Validity"] == "Betrouwbaar"){echo "selected";}?>>Betrouwbaar</option>
                <option value="Eerlijk" <?php if($_GET["Validity"] == "Eerlijk"){echo "selected";}?>>Eerlijk</option>
                <option value="Onbetrouwbaar" <?php if($_GET["Validity"] == "Onbetrouwbaar"){echo "selected";}?>>Onbetrouwbaar</option>
            </select>

            <input type="submit" value="Filter">
        </form>

    </body>
</html>

<style>
#CustomDiv {
}
.Collapsed {
    display: none;
}
.Extended {
    display: block;
}
</style>