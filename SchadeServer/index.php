<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
</head>

    <?php
        // Non-valide url check
        if (!(($_GET["Date"] != null) && ($_GET["ToiletID"] != null) && ($_GET["Origin"] != null) && ($_GET["Validity"] != null))) { header("Location: index.php?Keyword=&Date=PastDay&ToiletID=All&Origin=All&Validity=All");}
        ini_set('display_errors', 1); // kan weggecomment worden
        // Belangrijke bestanden
        require __DIR__ . '/Shared_Vars.php'; // ToiletID list
        require __DIR__ . '/QuerySystem.php'; // SQL query builder en verbeteraar
    ?>

    <body>
        <!--Filter form, hieronder staat de data-->
        <form action="index.php" method="get">
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
            // bouwt de query op op basis van de filters
            $Result = QueryExecuter(BuildQuery($_GET["Keyword"], $_GET["Date"], $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"]));
            //voert query uit
            foreach ($Result as $Value) {
                echo $Value;
            }
        ?>
    </body>
</html>

