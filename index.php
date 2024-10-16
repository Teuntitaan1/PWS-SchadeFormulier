<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet</title>
    <link rel="stylesheet" href="style.css">
</head>
    <?php include "Shared_Vars.php"; ?>
    <?php if ($_GET["ToiletID"] == null) {$ToiletID = "1M";} else {$ToiletID = $_GET["ToiletID"];} ?>

    <body>
        <h1>Schadeformulier <?php if (isset($ToiletList)) {echo $ToiletList[$ToiletID];} ?></h1>
        <!--Evidence form-->
        <form action="FormHandler.php" method="post">
            <input type="hidden" name="ToiletID" value=<?php echo $ToiletID; ?>>
            <input type="hidden" name="CurrentDate" value=<?php echo time(); ?>>

            <textarea name="Description" placeholder="Wat is er precies gebeurd?"></textarea>
            Leerlingnummer <input type="number" name="StudentNumber" min="30000" max="50000">
            <input type="file" name="Evidence" accept="image/jpeg">

            <input type="submit" name="Send" value="Verstuur" <?php if ($_GET["Done"] == "True") {echo "disabled";} ?>>
        </form>

        <p><?php if ($_GET["Done"] == "True") {echo "Bedankt voor het invullen :) We gaan meteen aan de bak";} ?></p>

    </body>

</html>