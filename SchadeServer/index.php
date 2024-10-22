<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <link rel="stylesheet" href="./style.css">
</head>

    <?php
        require __DIR__ . '/Shared_Vars.php';
        require __DIR__ . '/QueryBuilder.php';
    ?>

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
                if (isset($GLOBALS["ToiletList"])) {
                    foreach($GLOBALS["ToiletList"] as $ID => $ToiletID)
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
            // Non-valide url check
            if (($_GET["Date"] != null) && ($_GET["ToiletID"] != null) && ($_GET["Origin"] != null) && ($_GET["Validity"] != null)) {
                // SQL Connectie
                $Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
                if($Connection->connect_error) { die("Connection Failed" . $Connection->connect_error); }

                // bouwt de query op op basis van de filters
                $Query = BuildQuery($_GET["Keyword"], $_GET["Date"], $_GET["ToiletID"], $_GET["Origin"], $_GET["Validity"]);
                echo $Query;
                //voert query uit
                $Result = $Connection->query($Query);
                if ($Result) {
                    // Loop through the results and display them
                    while ($Row = $Result->fetch_assoc()) {
                        // TODO dit moet een nette tabel worden.
                        echo $Row["Beschrijving"];
                    }
                }
                else {
                    echo "Geen data gevonden!";
                }
                $Connection->close();
            }
            else {
                // Terug naar een wel valide header
                header("Location: index.php?Keyword=&Date=Always&ToiletID=All&Origin=All&Validity=All");
            }


        ?>
    </body>

</html>

