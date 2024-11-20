<!-- Vage pokkenzooi -->
<?php
ob_start();
require "./SharedVars.php";
?>

<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Schadeformulier toilet</title>
        <link rel="stylesheet" href="./style.css">
    </head>

    <body>
        <?php
            if (!(ValidateToiletID($_GET["ToiletID"]))) { header("location: ToiletChooser.php"); exit(); }
        ?>
        <h1>Schadeformulier <?php echo $ToiletList[$ToiletID]; ?></h1>
        <?php if($_GET["Done"] != "True") {echo "<p>Niet het goede toilet? Pas het toilet <a href='ToiletChooser.php'>hier</a> aan.</p>";} ?>

        <!--Evidence form-->
        <form action="./FormHandler.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="ToiletID" value=<?php echo $_GET["ToiletID"]; ?>>

            <label for="Description">Beschrijving</label>
            <textarea id="Description" name="Description" placeholder="Wat is er precies gebeurd?" minlength="10"></textarea>

            <input type="file" name="Evidence" accept="image/jpeg">

            <input type="submit" name="Send" value="Verstuur" <?php if ($_GET["Done"] == "True") {echo "disabled";} ?>>
        </form>

        <?php if ($_GET["Done"] == "True") {echo `<p>Bedankt voor het invullen :) We gaan meteen aan de bak! Nog een schadeformulier invullen? Klik <a href='./index.php?ToiletID=`.$_GET["ToiletID"].`&Done=False'>Hier</a>.</p>`;} ?>

    </body>

</html>

<!-- Meer vage pokkenzooi -->
<?php ob_end_flush(); ?>