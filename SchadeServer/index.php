<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht-Verbeterd</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>
</head>

    <?php
        require dirname(__DIR__, 1). '/Shared.php'; // SQL query builder en verbeteraar
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
        // Default query voor als de url ongeldig is
        if (($_GET["Date"] == null) || ($_GET["ToiletID"] == null) || ($_GET["Origin"] == null) || ($_GET["Validity"] == null) || (($_GET["SortType"] == null || $_GET["SortValue"] == null))) { header("Location: index.php?Keyword=&Date=PastDay&Start=&End=&ToiletID%5B%5D=All&ToiletID%5B%5D=0M&ToiletID%5B%5D=0F&ToiletID%5B%5D=1M&ToiletID%5B%5D=1F&ToiletID%5B%5D=2M&ToiletID%5B%5D=2F&ToiletID%5B%5D=3M&ToiletID%5B%5D=3F&ToiletID%5B%5D=0G&Origin%5B%5D=Sensor&Origin%5B%5D=Formulier&Origin%5B%5D=1&Validity%5B%5D=Betrouwbaar&Validity%5B%5D=Eerlijk&Validity%5B%5D=Onbetrouwbaar&Validity%5B%5D=1&SortValue=Datum&SortType=DESC");}
    ?>

    <body>
        <!--Filter form, hieronder staat de data TODO, form reworken tot een gebruiksvriendelijker systeem-->
        <form action="./index.php" method="get" id="FilterForm">
            <h1 id="Title">@Schadesysteem</h1>
            <h1 id="SubTitle">Filters</h1>
            <div id="KeywordDiv">
                <label for="Keyword">Sleutelwoorden</label>
                <input id=Keyword type="text" name="Keyword" placeholder="Appel, Banaan, Druif" value='<?php echo $_GET["Keyword"];?>'>
            </div>

            <hr>

            <div id="DateDiv">
                <label for="Date">Wanneer?</label>
                <select id="Date" name="Date" onchange="DateChange()">
                    <option value="PastHour" <?php if($_GET["Date"] == "PastHour") {echo "selected";}?>>In het afgelopen uur</option>
                    <option value="PastDay" <?php if($_GET["Date"] == "PastDay") {echo "selected";}?>>Vandaag</option>
                    <option value="PastWeek" <?php if($_GET["Date"] == "PastWeek") {echo "selected";}?>>Deze week</option>
                    <option value="PastMonth" <?php if($_GET["Date"] == "PastMonth") {echo "selected";}?>>Deze maand</option>
                    <option value="PastYear" <?php if($_GET["Date"] == "PastYear") {echo "selected";}?>>Dit jaar</option>
                    <option value="Always" <?php if($_GET["Date"] == "Always") {echo "selected";}?>>Altijd</option>
                    <option value="Custom" <?php if($_GET["Date"] == "Custom") {echo "selected";}?>>Aangepast..</option>
                </select>
            </div>
            <div id="CustomDateDiv" class="Collapsed">
                <div><label for="Begin">Tussen </label> <input type="date" id="Begin" name="Start" value="<?php echo $_GET["Start"] ?>"/></div>
                <div><label for="Eind">En </label><input type="date" id="Eind" name="End"  value="<?php echo $_GET["End"] ?>"/></div>
            </div>

            <hr>

            <div id="ToiletIDDiv">
                <label for="ToiletID">Toilet:</label>
                <select id="ToiletID" name="ToiletID[]" onchange="ToiletIDChange()" >
                    <option value="All" <?php if(in_array("All", $_GET["ToiletID"])) {echo "selected";}?>>Alle</option>
                    <option value="Custom" <?php if(in_array("Custom", $_GET["ToiletID"])) {echo "selected";}?>>Anders...</option>
                </select>
            </div>
            <div id="IDDiv" class="Collapsed">
                <?php
                foreach($ToiletList as $ID => $ToiletID) {
                    if(in_array($ID, $_GET["ToiletID"])) {
                        echo "<input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]' checked/> <label class='Option' for='$ToiletID'>Het $ToiletID</label>";
                    }
                    else {
                        echo "<input type='checkbox' id='$ToiletID' value='$ID' name='ToiletID[]'/> <label class='Option' for='$ToiletID'>Het $ToiletID</label>";
                    }
                    echo "<br>";
                }
                ?>
            </div>

            <hr>

            <div id="OriginDiv">
                <label>Bron:</label>
                <input type="hidden" name="Origin[]" value="1"/>
                <br><input type="checkbox" id="Sensor" name="Origin[]" value="Sensor" <?php if(in_array("Sensor", $_GET["Origin"])) {echo "checked";}?>/><label for="Sensor" class="Option">Sensor</label>
                <br><input type="checkbox" id="Formulier" name="Origin[]" value="Formulier" <?php if(in_array("Formulier", $_GET["Origin"])) {echo "checked";}?>/><label for="Formulier" class="Option">Formulier</label>
            </div>

            <hr>

            <div id="ValidityDiv">
                <label>Betrouwbaarheid:</label>
                <input type="hidden" name="Validity[]" value="1"/>
                <br><input type="checkbox" id="Betrouwbaar" name="Validity[]" value="Betrouwbaar" <?php if(in_array("Betrouwbaar", $_GET["Validity"])) {echo "checked";}?>/><label for="Betrouwbaar" class="Option">Betrouwbaar</label>
                <br><input type="checkbox" id="Eerlijk" name="Validity[]" value="Eerlijk" <?php if(in_array("Eerlijk", $_GET["Validity"])) {echo "checked";}?>/><label for="Eerlijk" class="Option">Eerlijk</label>
                <br><input type="checkbox" id="Onbetrouwbaar" name="Validity[]" value="Onbetrouwbaar" <?php if(in_array("Onbetrouwbaar", $_GET["Validity"])) {echo "checked";}?>/><label for="Onbetrouwbaar" class="Option">Onbetrouwbaar</label>
            </div>

            <hr>

            <div id="SortDiv">
                <div>
                    <label for="SortValue">Sorteer: </label>
                    <select id="SortValue" name="SortValue">
                        <option value="Datum" <?php if($_GET["SortValue"] == "Datum") {echo "selected";}?>>datum</option>
                        <option value="ToiletID" <?php if($_GET["SortValue"] == "ToiletID") {echo "selected";}?>>toilet</option>
                        <option value="Bron" <?php if($_GET["SortValue"] == "Bron") {echo "selected";}?>>bron</option>
                        <option value="Betrouwbaarheid" <?php if($_GET["SortValue"] == "Betrouwbaarheid") {echo "selected";}?>>betrouwbaarheid</option>
                    </select>
                </div>
                <hr>
                <div>
                    <label for="SortType">Volgorde:</label>
                    <select id="SortType" name="SortType">
                        <option value="ASC" <?php if($_GET["SortType"] == "ASC") {echo "selected";}?>>oplopend</option>
                        <option value="DESC" <?php if($_GET["SortType"] == "DESC") {echo "selected";}?>>aflopend</option>
                    </select>
                </div>
            </div>

            <div id="SubmitButtonDiv"><input id="SubmitButton" name="submit" type="submit" value="Filter"></div>
        </form>
        <div id="ResultsDiv">
            <table id="ResultsTable">
                <tr id="TableHeader">
                    <th>Datum:</th>
                    <th>Toilet:</th>
                    <th>Bron:</th>
                    <th>Beschrijving:</th>
                    <th>Betrouwbaarheid:</th>
                    <th>Bewijs:</th>
                </tr>
                <?php 
                    $Query = BuildQuery($_GET["Keyword"], array($_GET["Date"], $_GET["Start"], $_GET["End"]), $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"], array($_GET["SortValue"], $_GET["SortType"]));
                    //bouwt de query op op basis van de filters
                    $Result = QueryExecuter($Query);
                    $Count = 0;
                    foreach ($Result as $Value) {
                        $URL = CleanFileURL("https://".$_SERVER['SERVER_NAME'].dirname(__DIR__, 1)."/Files/".$Value["BewijsNaam"]);
                        echo 
                        "
                        <tr class='Entry' id='Entry$Count' onclick='EntryChange($Count)'>
                            <td><p class='Date'>".$Value["Datum"]."</p></td>
                            <td><p class='ToiledID'>".$Value["ToiletID"]."</p></td>
                            <td><p class='Source'>".$Value["Bron"]."</p></td>
                            <td><p class='Description'>".$Value["Beschrijving"]."</p></td>
                            <td><p class='Validity'>".$Value["Betrouwbaarheid"]."</p></td>
                            <td><p class='Link'><a href='$URL' target='_blank'>Link</a></p></td>
                        </tr>
                        <tr class='SubEntry SubEntry-Collapsed' id='SubEntry$Count'>
                            <td>
                                <div class='SubEntryDiv'>
                                    <div class='InfoDiv'>
                                        <p><strong>Waar?</strong> <i>Het ".$ToiletList[$Value["ToiletID"]]."</i></p>
                                        <h3>Wat is er gebeurd?</h3>
                                        <p class='DescriptionExpanded'>".$Value["Beschrijving"]."</p>
                                    </div>
                                    <img src='$URL' class='Evidence' alt='Evidence'>
                                </div>
                            </td>
                        </tr>
                        ";
                        $Count++;
                    }
                ?>
            </table>
            <p id="ResultsCount"><strong><?php echo count($Result); ?></strong> resultaten. :)</p>
        </div>
    <script>
        // Reset de juiste divs
        DateChange();
        ToiletIDChange();
    </script>
    </body>
</html>
