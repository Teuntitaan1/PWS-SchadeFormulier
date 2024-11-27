<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht-Verbeterd</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>
</head>

    <?php
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
        require __DIR__ . '/Shared.php'; // SQL query builder en verbeteraar
        ini_set('display_errors', 1); // kan weggecomment worden
        // Default query voor als de url ongeldig is
        if (($_GET["Date"] == null) || ($_GET["ToiletID"] == null) || ($_GET["Origin"] == null) || ($_GET["Validity"] == null)) { header("Location: index.php?Keyword=&Date=PastDay&Start=&End=&ToiletID%5B%5D=All&ToiletID%5B%5D=0M&ToiletID%5B%5D=0F&ToiletID%5B%5D=1M&ToiletID%5B%5D=1F&ToiletID%5B%5D=2M&ToiletID%5B%5D=2F&ToiletID%5B%5D=3M&ToiletID%5B%5D=3F&ToiletID%5B%5D=0G&Origin%5B%5D=Sensor&Origin%5B%5D=Formulier&Validity%5B%5D=Betrouwbaar&Validity%5B%5D=Eerlijk&Validity%5B%5D=Onbetrouwbaar");}
    ?>

    <body>
        <!--Filter form, hieronder staat de data TODO, form reworken tot een gebruiksvriendelijker systeem-->
        <form action="./index.php" method="get">
            <label for="Keyword">Sleutelwoorden</label>
            <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif" value=''>
            <div id="DateDiv">
                <label for="Date">Geschiedenis</label>
                <select id="Date" name="Date" onchange="DateChange()">
                    <option value="PastHour" <?php if($_GET["Date"] == "PastHour") {echo "selected";}?>>In het afgelopen uur</option>
                    <option value="PastDay" <?php if($_GET["Date"] == "PastDay") {echo "selected";}?>>Vandaag</option>
                    <option value="PastWeek" <?php if($_GET["Date"] == "PastWeek") {echo "selected";}?>>Deze week</option>
                    <option value="PastMonth" <?php if($_GET["Date"] == "PastMonth") {echo "selected";}?>>Deze maand</option>
                    <option value="PastYear" <?php if($_GET["Date"] == "PastYear") {echo "selected";}?>>Dit jaar</option>
                    <option value="Always" <?php if($_GET["Date"] == "Always") {echo "selected";}?>>Altijd</option>
                    <option value="Custom" <?php if($_GET["Date"] == "Custom") {echo "selected";}?>>Aangepast..</option>
                </select>
                <div id="CustomDateDiv" class="Collapsed">
                    <label for="Begin">Begin</label>
                    <input type="date" id="Begin" name="Start" value="<?php echo $_GET["Start"] ?>"/>
                    <label for="Eind">Eind</label>
                    <input type="date" id="Eind" name="End"  value="<?php echo $_GET["End"] ?>"/>
                </div>
            </div>

            <div id="ToiletIDDiv">
                <label for="ToiletID">Toilet</label>
                <select id="ToiletID" name="ToiletID[]" onchange="ToiletIDChange()" >
                    <option value="All" <?php if(in_array("All", $_GET["ToiletID"])) {echo "selected";}?>>Alle</option>
                    <option value="Custom" <?php if(in_array("Custom", $_GET["ToiletID"])) {echo "selected";}?>>Anders...</option>
                </select>
                <div id="IDDiv" class="Collapsed">
                    <?php
                    foreach($ToiletList as $ID => $ToiletID) {
                        if(in_array($ID, $_GET["ToiletID"])) {
                            echo "<label for='$ToiletID'>$ToiletID</label><input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]' checked/>";
                        }
                        else {
                            echo "<label for='$ToiletID'>$ToiletID</label><input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]'/>";
                        }
                    }
                    ?>
                </div>
            </div>

            <div id="OriginDiv">
                <label for="Sensor">Sensor</label><input type="checkbox" id="Sensor" name="Origin[]" value="Sensor" <?php if(in_array("Sensor", $_GET["Origin"])) {echo "checked";}?>/>
                <label for="Formulier">Formulier</label><input type="checkbox" id="Formulier" name="Origin[]" value="Formulier" <?php if(in_array("Formulier", $_GET["Origin"])) {echo "checked";}?>/>
            </div>

            <div id="ValidityDiv">
                <label for="Betrouwbaar">Betrouwbaar</label><input type="checkbox" id="Betrouwbaar" name="Validity[]" value="Betrouwbaar" <?php if(in_array("Betrouwbaar", $_GET["Validity"])) {echo "checked";}?>/>
                <label for="Eerlijk">Eerlijk</label><input type="checkbox" id="Eerlijk" name="Validity[]" value="Eerlijk" <?php if(in_array("Eerlijk", $_GET["Validity"])) {echo "checked";}?>/>
                <label for="Onbetrouwbaar">Onbetrouwbaar</label><input type="checkbox" id="Onbetrouwbaar" name="Validity[]" value="Onbetrouwbaar" <?php if(in_array("Onbetrouwbaar", $_GET["Validity"])) {echo "checked";}?>/>
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
    <script>
        DateChange();
        ToiletIDChange();
    </script>
    </body>
</html>
