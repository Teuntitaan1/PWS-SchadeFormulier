<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet</title>
    <link rel="stylesheet" href="style.css">
</head>
    <?php include "Shared_Vars.php"; ?>
    <?php if (!(ValidateToiletID($_GET["ToiletID"]))) {$ToiletID = "1M";} else {$ToiletID = $_GET["ToiletID"];} ?>
    <?php if ($_GET["Done"] != "True") {$Done = "False";} else {$Done = "True";} ?>

    <body>
        <h1>Schadeformulier <?php if (isset($GLOBALS["ToiletList"])) {echo $GLOBALS["ToiletList"][$ToiletID];} ?></h1>
        <p>Niet het goede toilet? Pas het <a href="ToiletChooser.php">hier</a> aan.</p>
        <!--Evidence form-->
        <form action="FormHandler.php" method="post">
            <input type="hidden" name="ToiletID" value=<?php echo $ToiletID; ?>>
            <input type="hidden" name="CurrentDate" value=<?php echo time(); ?>>

            <textarea name="Description" placeholder="Wat is er precies gebeurd?"></textarea>
            Leerlingnummer <input type="number" name="StudentNumber" min="30000" max="50000">
            <input type="file" name="Evidence" accept="image/jpeg">

            <input type="submit" name="Send" value="Verstuur" <?php if ($Done == "True") {echo "disabled";} ?>>
        </form>

        <p><?php if ($Done == "True") {echo "Bedankt voor het invullen :) We gaan meteen aan de bak!";} ?></p>

    </body>

</html>